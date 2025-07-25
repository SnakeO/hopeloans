<?php
/**
 * Add quantity field on the archive page.
 * @via https://shopplugins.com/add-a-quantity-field-to-the-woocommerce-archive-pages/
 */

class ModifyWooProductLoop
{
	function __construct()
	{
		$this->groupLayout();
		$this->removeLinkOutToDetailPage();
		$this->addExcerpt();
		$this->addQtyInput();
		$this->changeAddToCartText();
		$this->permalinkProductToHopeLoansPage();
	}

	/**
	 * Add some surrounding layout HTML
	 */
	function groupLayout()
	{
		add_action('woocommerce_before_shop_loop_item', function()
		{
			echo '<div class="thumb-and-qty">';
		}, -9999);

		add_action('woocommerce_before_shop_loop_item_title', function()
		{
			echo '</div><!-- /thumb-and-qty  --><div class="product-info">';
		}, PHP_INT_MAX);

		add_action('woocommerce_after_shop_loop_item', function()
		{
			echo '</div><!-- /product-info -->';
		}, PHP_INT_MAX);
	}

	function removeLinkOutToDetailPage()
	{
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	}

	function addExcerpt()
	{
		add_action( 'woocommerce_after_shop_loop_item', function()
		{
			$product = wc_get_product( get_the_ID() );
			$product_details = $product->get_data();
			echo "<p>$product_details[description]</p>";
		}, 1);
	}

	function addQtyInput()
	{
		add_action( 'woocommerce_before_shop_loop_item_title', function() 
		{
			$product = wc_get_product( get_the_ID() );

			if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) 
			{
				woocommerce_quantity_input(array( 
					'min_value' => 1, 
					'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() 
				));
			}

		}, 11, 9 );

		// add required javascript
		add_action( 'init', function() 
		{
			wc_enqueue_js( '
				// update quantity on add-to-cart
				jQuery( ".product" ).on( "change input update", ".quantity .qty", updateAddToCartQty);
				jQuery( ".product" ).on( "click", ".plus,.minus", updateAddToCartQty);

				function updateAddToCartQty() 
				{
					var jproduct = jQuery( this ).parents( ".product" );
					var add_to_cart_button = jproduct.find( ".add_to_cart_button" );
					var qty = jproduct.find(".qty").val();

					// For AJAX add-to-cart actions
					add_to_cart_button.data( "quantity", qty );

					// For non-AJAX add-to-cart actions
					add_to_cart_button.attr( "href", "?add-to-cart=" + add_to_cart_button.attr( "data-product_id" ) + "&quantity=" + qty );
				
					console.log("jproduct", jproduct, add_to_cart_button, jproduct.find(".qty"), qty);
				}

				// Plus and Minus buttons
				$(".plus").on("click",function(e)
				{
					var val = parseInt($(this).prev("input").val());
					$(this).prev("input").val( val+1 );
				});

				$(".minus").on("click",function(e)
				{
					var val = parseInt($(this).next("input").val());
					if(val > 1){
						$(this).next("input").val( val-1 );
					}
				});
			' );
		});
	}

	function changeAddToCartText()
	{
		add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
			return __( 'Add to Basket &raquo;', 'woocommerce' );
		});

		add_filter( 'woocommerce_product_add_to_cart_text', function() {
			return __( 'Add to Basket &raquo;', 'woocommerce' );
		}); 
	}

	function permalinkProductToHopeLoansPage()
	{
		add_filter('post_type_link', function($post_link, $post, $leavename, $sample )
		{
			if( $post->post_type != 'product' ) {
				return $post_link;
			}

			// which cat are we in?
			$terms = get_the_terms( $post->ID, 'product_cat' );
			foreach ($terms as $term) {
				$product_cat = $term;
				break;
			}

			return site_url('/give-a-hopeloan/#' . $product_cat->slug);

		}, 20, 4);
	}

}