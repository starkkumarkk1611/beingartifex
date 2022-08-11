 <?php   $footer_bg = exhibz_option("footer_bg_color");
    $footer_copyright_color = exhibz_option("footer_copyright_color");

    if ($footer_copyright_color != '') {
        $footer_copyright_color = "style='color:{$footer_copyright_color}'";
    }
    ?>

 <div class="footer-area">
     <!-- footer start-->
     <footer class="ts-footer ts-footer-item" style="background-color:<?php echo esc_attr($footer_bg); ?>">
         <div class="container">
             <div class="row footer-border">
                 <div class="col-lg-6">

                     <!-- footer menu-->
                     <?php if (has_nav_menu('footermenu')) : ?>
                         <div class="footer-menu mb-30">
                             <?php                               // footer Nav
                                wp_nav_menu(array(
                                    'theme_location' => 'footermenu',
                                    'depth'          => 1,

                                ));
                                ?>
                         </div><!-- footer menu end-->
                     <?php endif; ?>
                     <!-- footer menu end-->

                     <?php if (defined('FW')) : ?>
                         <div class="ts-footer-social">
                             <ul>
                                 <?php                                   $social_links = exhibz_option('footer_social_links', []);

                                    foreach ($social_links as $sl) :
                                        $class = 'ts-' . str_replace('fa fa-', '', $sl['icon_class']);
                                    ?>
                                     <li class="<?php echo esc_attr($class); ?>">
                                         <a href="<?php echo esc_url($sl['url']); ?>" rel="noreferrer">
                                             <i class="<?php echo esc_attr($sl['icon_class']); ?>" aria-hidden="true"></i>
                                             <span title="<?php esc_attr_e($sl['title'], 'exhibz'); ?>"><?php esc_html_e($sl['title'], 'exhibz'); ?></span>
                                         </a>
                                     </li>
                                 <?php endforeach; ?>
                             </ul>
                         </div>
                     <?php endif; ?>
                 </div><!-- col end-->
                 <div class="col-lg-6 align-self-center">

                     <?php


                        if (shortcode_exists('mc4wp_form')) {
                            $mailchimp = Exhibz_option("footer_style")["style-2"]["footer_mailchimp"];
                            echo do_shortcode($mailchimp);
                        }
                        ?>
                     <div class="copyright-text d text-right-bottom">
                        <p <?php echo wp_kses_post($footer_copyright_color); ?>>
                            <?php 
                                $copyright_text = exhibz_option('footer_copyright', 'Exhibz. All rights reserved');
                                echo esc_html__('&copy; ','exhibz') . date('Y') .'&nbsp;'. exhibz_kses($copyright_text);
                            ?>
                        </p>
                     </div>
                 </div>
             </div><!-- row end-->
         </div><!-- container end-->
     </footer>
     <!-- footer end-->
     <div class="BackTo">
         <a href="#" class="icon icon-chevron-up"></a>
     </div>

 </div>
 <!-- ts footer area end-->