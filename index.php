<?php
/**
 * Plugin Name: Woo based Stock Bar
 * Description: Shows bar for stock product available thats is lots of stock , half gone and nearly gone.
 * Version: 1.0.0
 * Author: Shashank Baindur
 * Tags: woocommerce, ecommerce, product, images, stock , quantity , bar .
 * License: GPLv2 or later
 */
define('STOCKBAR_PLUGIN_URL', plugin_dir_url(__FILE__));

function load_stockbar_assets() {
		wp_enqueue_style('stockbarstyle', STOCKBAR_PLUGIN_URL . 'css/stock-bar.css');
	}

	add_action('wp_enqueue_scripts', 'load_stockbar_assets');

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {



class Stockbar_Widget extends WP_Widget {

	public function __construct() {
			parent::__construct(
					'Stockbar_Widget', // Base ID
					'Stock Quantity Bar', // Name
					array('description' => __('Woocommerce Stock Quantity Bar', 'custom-text_domain'),) // Args
			);
		}

	public function widget($args, $instance) {
			$title = apply_filters('widget_title', $instance['title']);

			echo $args['before_widget'];
			if (!empty($title))
				echo $args['before_title'] . $title . $args['after_title'];

			global $wpdb , $product , $woocommerce ;

		$cntrem = $wpdb->get_results("select count(*) as cnt from wp_woocommerce_order_itemmeta a , wp_woocommerce_order_items b , wp_posts c where a.meta_value='".$product->id."' and a.order_item_id=b.order_item_id and c.ID=b.order_id and c.post_status like '%completed%'");

		$sold_items = $cntrem[0]->cnt;

		$total_stock_quantity= number_format($product->stock,0,'','');
		if( ($sold_items!='0') && ($sold_items!=$total_stock_quantity))
		{
			$tot_percent = round((($sold_items)/ ($total_stock_quantity)) * 100);
		}
		elseif( ($sold_items==$total_stock_quantity))
		{
			$tot_percent = 0;
		}
		else
		{
			$tot_percent = 100;
		}


		if ( $tot_percent < 100 && $tot_percent >= 70) {
				if ( $tot_percent <= 100 && $tot_percent > 85) {

		$content_stockbar = '
				<div class="product-stock-countdown">
					<div class="countdown-container">
						<div class="countdown-measure red" style="width: 10%;"></div>
					</div>
					<div class="countdown-legend">
						<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
						<span style="left:50%;" class="tier-amber">HALF GONE</span>
						<span style="right:0px;" class="tier-green">PLENTY IN STOCK</span>
					</div>
				</div><!--echo "LOTS OF STOCK"; -->';
				  } if ( $tot_percent <= 84 && $tot_percent >= 70) {
		 $content_stockbar .= '		<div class="product-stock-countdown">
					<div class="countdown-container">
						<div class="countdown-measure red" style="width: 25%;"></div>
					</div>
					<div class="countdown-legend">
						<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
						<span style="left:50%;" class="tier-amber">HALF GONE</span>
						<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
					</div>
				</div><!--echo "LOTS OF STOCK"; -->';
				  }
		 $content_stockbar .= '		<div class="clear"></div>';
				  } elseif ( $tot_percent <= 69 && $tot_percent >= 40) {
							if ( $tot_percent <= 69 && $tot_percent > 59) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure green" style="width:40%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "HALF GONE"; -->';
							 } if ( $tot_percent <= 58 && $tot_percent >= 40) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure green" style="width:50%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "HALF GONE"; -->';
							  }
		 $content_stockbar .= '	<div class="clear"></div>';
					  } else  {
							if ( $tot_percent <= 39 && $tot_percent >= 20) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure amber" style="width: 70%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "NEARLY SOLD OUT"; -->';
							  } if ( $tot_percent <= 19 && $tot_percent >= 1) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure amber" style="width: 100%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "NEARLY SOLD OUT"; -->';
							  }
		 $content_stockbar .= '	<div class="clear"></div>';
					}
				//start 100%
						if ( $tot_percent == 100) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
									<div class="countdown-container">
										<div class="countdown-measure amber" style="width: 100%;"></div>
									</div>
									<div class="countdown-legend">
										<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
										<span style="left:50%;" class="tier-amber">HALF GONE</span>
										<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
									</div>
								</div><!--echo "NEARLY SOLD OUT"; -->
								<div class="clear"></div>';
							 }
				//end 100%
				// start 0%
						if ( ($tot_percent == 0) && ( $sold_items  != 0) && ($total_stock_quantity  != 0)) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
									<div class="countdown-container">
										<div class="countdown-measure red" style="width: 5%;"></div>
									</div>
									<div class="countdown-legend">
										<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
										<span style="left:50%;" class="tier-amber">HALF GONE</span>
										<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
									</div>
								</div><!--echo "NEARLY SOLD OUT"; -->
								<div class="clear"></div>';
							  }
				// end 0%
				// start 0%
				if ( ($tot_percent == 0) && ( $sold_items  == 0) && ($total_stock_quantity  == 0)){
		 $content_stockbar .= '	<div class="product-stock-countdown">
									<div class="countdown-container">
										<div class="countdown-measure amber" style="width: 100%;"></div>
									</div>
									<div class="countdown-legend">
										<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
										<span style="left:50%;" class="tier-amber">HALF GONE</span>
										<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
									</div>
								</div><!--echo "NEARLY SOLD OUT"; -->
								<div class="clear"></div>';
						  }
			echo __($content_stockbar, 'custom-text_domain');
			echo $args['after_widget'];
		}

		public function form($instance) {
			if (isset($instance['title'])) {
				$title = $instance['title'];
			} else {
				$title = __('Product Stock Bar', 'custom-text_domain');
			}
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
				<br/>
				<span>Plugin Developed By:</span>
				<span>Shashank Baindur</span>
			</p>
			<?php
		}

		public function update($new_instance, $old_instance) {
			$instance = array();
			$instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
			return $instance;
		}

	}



	/** registring widget */
	function Stockbar_Widget_register() {
		register_widget('Stockbar_Widget');
	}

	add_action('widgets_init', 'Stockbar_Widget_register');

	function Woocommerce_Stockbar_Shortcode_function() {
		global $wpdb , $product , $woocommerce ;

		$cntrem = $wpdb->get_results("select count(*) as cnt from wp_woocommerce_order_itemmeta a , wp_woocommerce_order_items b , wp_posts c where a.meta_value='".$product->id."' and a.order_item_id=b.order_item_id and c.ID=b.order_id and c.post_status like '%completed%'");

		$sold_items = $cntrem[0]->cnt;

		$total_stock_quantity= number_format($product->stock,0,'','');
		if( ($sold_items!='0') && ($sold_items!=$total_stock_quantity))
		{
			$tot_percent = round((($sold_items)/ ($total_stock_quantity)) * 100);
		}
		elseif( ($sold_items==$total_stock_quantity))
		{
			$tot_percent = 0;
		}
		else
		{
			$tot_percent = 100;
		}

		if ( $tot_percent < 100 && $tot_percent >= 70) {
				if ( $tot_percent <= 100 && $tot_percent > 85) {

		$content_stockbar = '
				<div class="product-stock-countdown">
					<div class="countdown-container">
						<div class="countdown-measure red" style="width: 10%;"></div>
					</div>
					<div class="countdown-legend">
						<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
						<span style="left:50%;" class="tier-amber">HALF GONE</span>
						<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
					</div>
				</div><!--echo "LOTS OF STOCK"; -->';
				} if ( $tot_percent <= 84 && $tot_percent >= 70) {
		 $content_stockbar .= '		<div class="product-stock-countdown">
					<div class="countdown-container">
						<div class="countdown-measure red" style="width: 25%;"></div>
					</div>
					<div class="countdown-legend">
						<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
						<span style="left:50%;" class="tier-amber">HALF GONE</span>
						<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
					</div>
				</div><!--echo "LOTS OF STOCK"; -->';
				}
		 $content_stockbar .= '		<div class="clear"></div>';
				} elseif ( $tot_percent <= 69 && $tot_percent >= 40) {
							if ( $tot_percent <= 69 && $tot_percent > 59) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure green" style="width:40%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "HALF GONE"; -->';
				} if ( $tot_percent <= 58 && $tot_percent >= 40) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure green" style="width:50%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "HALF GONE"; -->';
				 }
		 $content_stockbar .= '	<div class="clear"></div>';
				} else  {
							if ( $tot_percent <= 39 && $tot_percent >= 20) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure amber" style="width: 70%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "NEARLY SOLD OUT"; -->';
							} if ( $tot_percent <= 19 && $tot_percent >= 1) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
								<div class="countdown-container">
									<div class="countdown-measure amber" style="width: 100%;"></div>
								</div>
								<div class="countdown-legend">
									<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
									<span style="left:50%;" class="tier-amber">HALF GONE</span>
									<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
								</div>
							</div><!--echo "NEARLY SOLD OUT"; -->';
							 }
		 $content_stockbar .= '	<div class="clear"></div>';
				 }
				//start 100%
						if ( $tot_percent == 100) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
									<div class="countdown-container">
										<div class="countdown-measure amber" style="width: 100%;"></div>
									</div>
									<div class="countdown-legend">
										<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
										<span style="left:50%;" class="tier-amber">HALF GONE</span>
										<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
									</div>
								</div><!--echo "NEARLY SOLD OUT"; -->
								<div class="clear"></div>';
							 }
				//end 100%
				// start 0%
					if ( ($tot_percent == 0) && ( $sold_items  != 0) && ($total_stock_quantity  != 0)) {
		 $content_stockbar .= '	<div class="product-stock-countdown">
									<div class="countdown-container">
										<div class="countdown-measure red" style="width: 5%;"></div>
									</div>
									<div class="countdown-legend">
										<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
										<span style="left:50%;" class="tier-amber">HALF GONE</span>
										<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
									</div>
								</div><!--echo "NEARLY SOLD OUT"; -->
								<div class="clear"></div>';
							}
				// end 0%
				// start 0%
					if ( ($tot_percent == 0) && ( $sold_items  == 0) && ($total_stock_quantity  == 0)){
		 $content_stockbar .= '	<div class="product-stock-countdown">
									<div class="countdown-container">
										<div class="countdown-measure amber" style="width: 100%;"></div>
									</div>
									<div class="countdown-legend">
										<span style="left:0px;" class="tier-red">NEARLY SOLD OUT</span>
										<span style="left:50%;" class="tier-amber">HALF GONE</span>
										<span style="right:0px;" class="tier-green">LOTS OF STOCK</span>
									</div>
								</div><!--echo "NEARLY SOLD OUT"; -->
								<div class="clear"></div>';
							 }
				// end 0%
		return $content_stockbar;
	}

	add_shortcode('Product_Stockbar', 'Woocommerce_Stockbar_Shortcode_function');

}
?>
