<?php
/**
 * Add a custom product tab.
 */
function custom_product_tabs( $tabs) {
	$tabs['giftcard_size_price'] = array(
		'label'		=> __( 'Size price', 'woocommerce' ),
		'target'	=> 'size_options',
		'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );


/**
 * Contents of the size price per sq feet options product tab.
 */
function size_price_options_product_tab_content() {
		global $post;
			
		$key_1_value = get_post_meta( get_the_ID(), '_product_attributes', true );
			?>
			<div id='size_options' class='panel woocommerce_options_panel gfl'>
				<select type="" name="material">   
					 <option>Please select a material</option>
					 <option>test1</option>
					 <option>test1</option>
					 <option>test1</option>
				 </select>
		<?php 	echo '<table class="size_price_sq">';
		
			$key_price = get_post_meta( get_the_ID(), '_size_price_rate', true );	
			
			$saveddSize = json_decode($key_price,true);
			// echo '<pre>';
			// print_r($saveddSize);exit;
			$newArr = array();

			if(count($saveddSize)>0)
			{
				foreach($saveddSize['size_price'] as $k => $v){
					$newArr[trim($k)] = $v;
				}
		    }
		foreach ($key_1_value as $key => $productdata) {
			 $varData = strtolower($productdata['name']) ;
			if($varData=='size')
			{
				$size =  $productdata['value'];

				$sizedata = explode('|', $size);

				foreach ($sizedata as $key => $size_options) { 
					?><tr><td><?php echo $size_options;?></td>
						
							<?php 
								$size_options = trim($size_options);

			if(isset($newArr[$size_options]) && !empty($newArr[$size_options])) { 
								
							 ?>
						<td>
						<input type="text" class="price_sq_input price_sq_com" name="size_price[<?php echo $size_options;?>][area]" 
						 class="size_percentage" value="<?php echo $newArr[$size_options]['area'];?>">  Sqft Pre Skid
						</td>
						<td><input type="text" class="price_sq_com" name="size_price[<?php echo $size_options;?>][cost]" 
						 class="size_percentage" value="<?php echo $newArr[$size_options]['cost'];?>"> $/ Per sq/ft
						</td>
							<?php }else{ ?>
				<!-- 		<input type="checkbox" name="size_name" id="size_name" class="size_name">	 -->
				<td>
					<input type="text" class="price_sq_input price_sq_com" name="size_price[<?php echo $size_options;?>][area]" 
						1 class="size_percentage">$/ Per sq/ft
				</td>
				<td>
					<input type="text" class="price_sq_com" name="size_price[<?php echo $size_options;?>][cost]" 
						 class="size_percentage1">	 Sqft Pre Skid
						<?php } ?>
						</td>
					</tr>

			<?php 	}



			}
			
		}
         echo '<tr class="valid_msg"><td>';
         echo '</td></tr>';
		echo '</table>';
	// Note the 'id' attribute needs to match the 'target' parameter set above
	?>
</div>

<?php
	}

add_filter( 'woocommerce_product_data_panels', 'size_price_options_product_tab_content' ); // WC 2.6 and up

add_filter( 'woocommerce_product_data_panels', 'size_price_options_product_tab_content' ); // WC 2.6 and up


/**
 * Save the custom fields.
 */
function save_giftcard_option_fields( $post_id ) {
	
	// echo '<pre>';
	// print_r($_POST);exit;

		if ( isset( $_POST['size_price']) ) :

		$post_data = array('size_price'=>$_POST['size_price']);

		$dataval = json_encode($post_data);
		update_post_meta( $post_id, '_size_price_rate', $dataval);
	endif;
	
}
add_action( 'woocommerce_process_product_meta_simple', 'save_giftcard_option_fields'  );
add_action( 'woocommerce_process_product_meta_variable', 'save_giftcard_option_fields'  );