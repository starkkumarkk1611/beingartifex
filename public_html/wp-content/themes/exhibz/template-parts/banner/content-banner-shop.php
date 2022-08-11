<?php

/**
 * Blog Header
 *
 */

$banner_bg    = $banner_title = $banner_subtitle = '';

if (defined('FW')) {

   $banner_settings = exhibz_option('shop_banner_settings');
   //Page settings
   $show = (isset($banner_settings['show'])) ? $banner_settings['show'] : 'yes';
   $show_breadcrumb = (isset($banner_settings['show_breadcrumb'])) ? $banner_settings['show_breadcrumb'] : 'yes';

   if(is_shop()){
      $banner_title_value = exhibz_meta_option( get_option( 'woocommerce_shop_page_id' ), 'header_title' );
      $banner_image  = exhibz_meta_option( get_option( 'woocommerce_shop_page_id' ), 'header_image' );
   } else {
      $banner_title_value = exhibz_meta_option( get_the_ID(), 'header_title' );
      $banner_image  = exhibz_meta_option( get_the_ID(), 'header_image' );
   }

   if($banner_title_value != ''){
      $banner_title = $banner_title_value;
   }elseif($banner_settings['title'] != ''){
      $banner_title = $banner_settings['title'];
      
   }else{
      if(is_shop()){
         $banner_title   = esc_html__('Shop','exhibz');
      } else{
         $banner_title   = get_the_title();
      }      
   }

   if(!empty($banner_image)) {
      $banner_image = $banner_image['url']; 
   } elseif(!empty($banner_settings['image'])) {
      $banner_image = (is_array($banner_settings['image']) && $banner_settings['image']['url'] != '') ?
      $banner_settings['image']['url'] : EXHIBZ_IMG . '/banner/banner_bg.jpg';
   } else {
      $banner_image = EXHIBZ_IMG . '/banner/banner_bg.jpg';
   }

   $single_title = (isset($banner_settings['single_title']) && $banner_settings['single_title'] != '') ?
      $banner_settings['single_title'] : esc_html__('Product Details', 'exhibz');

} else {
   $banner_image = EXHIBZ_IMG . '/banner/banner_bg.jpg';
   $banner_title = esc_html__('Shop', 'exhibz');
   $single_title = esc_html__('Product Details', 'exhibz');
   $show = 'yes';
   $show_breadcrumb = 'yes';
}
if (isset($banner_image) && $banner_image != '') {
   $banner_bg = 'style="background-image:url(' . esc_url($banner_image) . ');"';
}

if (isset($show) && $show == 'yes') : ?>

   <div id="page-banner-area" class="page-banner-area" <?php echo wp_kses_post($banner_bg); ?>>
      <!-- Subpage title start -->
      <div class="page-banner-title">

         <div class="text-center">

            <p class="banner-title">
               <?php              if(is_shop()){
                  if($banner_title != ''){
                     echo exhibz_kses($banner_title);
                  } else{
                     $shop_title = explode(':',get_the_archive_title() );
                     if(isset($shop_title[1])){
                        echo exhibz_kses($shop_title[1]);
                     }else{
                        echo exhibz_kses($banner_title);
                     }
                  }
               
               }elseif(is_product()){
                     echo exhibz_kses( $single_title );
               }else{
                     echo exhibz_kses( $banner_title );
               }

               ?>
            </p>


            <?php if ($show_breadcrumb == 'yes') : ?>
               <?php woocommerce_breadcrumb(); ?>
            <?php endif; ?>
         </div>
      </div><!-- Subpage title end -->
   </div><!-- Page Banner end -->

<?php endif; ?>