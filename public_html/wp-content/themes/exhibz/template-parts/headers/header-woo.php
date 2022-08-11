<?php
if (defined('FW')) {
	$button_settings = exhibz_option('header_cta_button_settings');
	//Page settings
	$header_btn_show = $button_settings['header_btn_show'];
	$header_btn_url = $button_settings['header_btn_url'];
	$header_btn_title = $button_settings['header_btn_title'];

	// header cart
	$show_shopping_cart = exhibz_option('header_nav_shopping_cart_section','no');

} else {
	$header_btn_show = "no";
	$header_btn_url = "#";
	$header_btn_title = "Buy Ticket";

	// cart
	$show_shopping_cart = 'yes';
}


?>
<!-- header nav start-->
<header class="header-standard header-woo<?php echo (exhibz_option('header_nav_sticky_section', 'no') == "yes") ? "navbar-fixed" : ''; ?> ">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-6 align-self-center">

				<?php if (exhibz_text_logo()) : ?>
					<h1 class="logo-title">
						<a rel='home' class="logo" href="<?php echo esc_url(home_url('/')); ?>">
							<?php echo esc_html(exhibz_text_logo()); ?>
						</a>
					</h1>
				<?php else : ?>
					<a class="navbar-brand logo" href="<?php echo esc_url(home_url('/')); ?>">
						<img width="158" height="46" src="<?php
									echo esc_url(
										exhibz_src(
											'general_dark_logo',
											EXHIBZ_IMG . '/logo/logo-dark.png'
										)
									);
									?>" alt="<?php bloginfo('name'); ?>">
					</a>
				<?php endif; ?>

			</div><!-- Col end -->
			<div class="<?php echo esc_html($header_btn_show == 'yes'|| $show_shopping_cart == 'yes') ? 'col-lg-7' : 'col-lg-9'; ?>">
				<?php get_template_part('template-parts/navigations/nav', 'primary'); ?>
			</div>

			<?php if ($header_btn_show == 'yes' || $show_shopping_cart == 'yes') { ?>
				<div class="col-lg-3 d-none d-lg-block text-lg-right">

					<!-- header cart --> 
					<?php if($show_shopping_cart == "yes" && class_exists( 'WooCommerce' )): ?>     
						<a class="cart-btn" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'exhibz'); ?>">
							<span class="icon icon-cart"></span>
							<sup><?php echo sprintf(_n('%d item', '%d', WC()->cart->cart_contents_count, 'autrics'), WC()->cart->cart_contents_count);?></sup>
						</a>
					<?php endif; ?>  
					<!-- hader cart end --> 

					<?php 
						if($header_btn_show == 'yes'):
					?>
					<a class="ticket-btn btn" href="<?php echo esc_url($header_btn_url); ?>">
						<?php echo esc_html($header_btn_title); ?>
					</a>
					<?php endif; ?>
				</div>
			<?php } ?>
		</div><!-- Row end -->
	</div>
	<!--Container end -->
</header><!-- Header end -->