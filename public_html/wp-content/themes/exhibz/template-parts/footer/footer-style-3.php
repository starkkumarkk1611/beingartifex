 <?php   $footer_bg = exhibz_option("footer_bg_color");
    $footer_copyright_color = exhibz_option("footer_copyright_color");

    if ($footer_copyright_color != '') {
        $footer_copyright_color = "style='color:{$footer_copyright_color}'";
    }
    ?>

 <div class="footer-area">
     <!-- footer start-->
     <footer class="ts-footer ts-footer-3 ts-footer-item" style="background-color:<?php echo esc_attr($footer_bg); ?>">
         <div class="container">
             <div class="row justify-content-between">
                <div class="col-lg-4">

                     <!-- footer left  -->
                     <?php if ( is_active_sidebar( 'footer_left' ) ) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar( 'footer_left' ); ?>
                        </div>
                    <?php endif; ?>
                     
                     <!-- footer left end-->

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

                    <?php if ( is_active_sidebar( 'footer_center' ) ) : ?>
                        <div class="col-lg-4">
                           <div class="footer-widget footer-two">
                                <?php dynamic_sidebar( 'footer_center' ); ?>
                           </div>
                        </div>
                    <?php endif; ?>

                 <div class="col-lg-4">
                      <!-- footer left  -->
                      <?php if ( is_active_sidebar( 'footer_right' ) ) : ?>
                        <div class="footer-widget footer-three">
                            <?php dynamic_sidebar( 'footer_right' ); ?>
                        </div>
                    <?php endif; ?>
                 </div>
             </div><!-- row end-->

            <div class="row footer-border">
                <div class="col-12 text-center">
                    <div class="copyright-text">
                        <p <?php echo wp_kses_post($footer_copyright_color); ?>>
                        <?php  
                            $copyright_text = exhibz_option('footer_copyright', '&copy; '.date('Y').', Exhibz. All rights reserved');
                            echo esc_html__('&copy; ','exhibz') . date('Y') .'&nbsp;'. exhibz_kses($copyright_text);
                        ?></p>
                    </div>
                </div>
            </div>
             <!-- /.row -->
         </div><!-- container end-->
     </footer>
     <!-- footer end-->
     <div class="BackTo">
         <a href="#" class="icon icon-chevron-up"></a>
     </div>

 </div>
 <!-- ts footer area end-->