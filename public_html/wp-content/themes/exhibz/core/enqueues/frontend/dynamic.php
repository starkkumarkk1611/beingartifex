<?php if (!defined('ABSPATH')) die('Direct access forbidden.');
/**
 * dynamic css, generated by customizer options
 */

if ( defined( 'FW' ) ) {
    

    $typography = exhibz_option( 'typography' );
    $body_bg_img = exhibz_option( 'body_bg_img' );
      
    if(is_array($body_bg_img) && isset($body_bg_img['url']) && $body_bg_img['url'] !=''){
        $body_bg_img = $body_bg_img['url'];
   }
   $body_bg_url = 'background-image:url('. $body_bg_img .');'; 




    $body_bg = exhibz_option( 'style_body_bg', '#fff' );

    $body_text_color = exhibz_option( 'style_body_text_color', '#5a5a5a' );
    $style_primary = exhibz_option( 'style_primary', '#ff007a');
    $title_color = exhibz_option( 'title_color', '#1c1c24');
    $secondary_color = exhibz_option( 'secondary_color','#3b1d82');
    $button_settings = exhibz_option('header_cta_button_settings','#00c1c1');
    $header_nav_sticky_bg = exhibz_option('header_nav_sticky_bg');
    $banner_title_color = exhibz_option( 'banner_title_color');

    $global_body_font = exhibz_option( 'body_font' );
    
    Exhibz_Unyson_Google_Fonts::add_typography_v2( $global_body_font );
    $body_font = exhibz_advanced_font_styles( $global_body_font );
    $body_font .= "color: $body_text_color;";
    $heading_font_one = exhibz_option( 'heading_font_one' );
    Exhibz_Unyson_Google_Fonts::add_typography_v2( $heading_font_one );
    $heading_font_one = exhibz_advanced_font_styles( $heading_font_one );
   
    $heading_font_two = exhibz_option( 'heading_font_two' );
    Exhibz_Unyson_Google_Fonts::add_typography_v2( $heading_font_two );
    $heading_font_two = exhibz_advanced_font_styles( $heading_font_two );

    $heading_font_three = exhibz_option( 'heading_font_three' );
    Exhibz_Unyson_Google_Fonts::add_typography_v2( $heading_font_three );
    $heading_font_three = exhibz_advanced_font_styles( $heading_font_three );

    // init custom css
    $custom_css	 = exhibz_option( 'custom_css' );
    $output = $custom_css;
 
    
  

    // global style
    $output	.= "
        html.fonts-loaded body{ $body_font }
        
        html.fonts-loaded h1,
        html.fonts-loaded h2{
            $heading_font_one
        }
        html.fonts-loaded h3{ 
            $heading_font_two 
        }

        html.fonts-loaded h4{ 
            $heading_font_three
        }

        .banner-title,
        .page-banner-title .breadcrumb li,
        .page-banner-title .breadcrumb,
        .page-banner-title .breadcrumb li a{
            color: $banner_title_color;
        }

        a, .post-meta span i, .entry-header .entry-title a:hover, .sidebar ul li a:hover,
        .navbar.navbar-light ul.navbar-nav > li ul.dropdown-menu li:hover a,
        .elementor-widget-exhibz-latestnews .post:hover .post-body .entry-header .entry-title a,
        .btn-link:hover, .footer-menu ul li a:hover, .schedule-tabs-item .schedule-listing-item .schedule-slot-time,
        .navbar.navbar-light ul.navbar-nav > li ul.dropdown-menu li .dropdown-item.active{
            color: $style_primary;
        }

        a:hover,.navbar.navbar-light ul.navbar-nav > li ul.dropdown-menu li.active a{
            color: $secondary_color;
        }
        .hero-form-content {
            border-top-color:  $style_primary;
        }
        .entry-header .entry-title a,
        .ts-title,
        h1, h2, h3, h4,h5,
        .elementor-widget-exhibz-latestnews .post .post-body .entry-header .entry-title a,
        .blog-single .post-navigation h3,
        .entry-content h3{
            color: $title_color;
        }
     
        body{
            background-color: $body_bg;
        }
        body{
            $body_bg_url;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        body,
        .post-navigation span,
        .post-meta,
        .post-meta a{
            color:  $body_text_color;
        }
        .single-intro-text .count-number, .sticky.post .meta-featured-post,
        .sidebar .widget .widget-title:before, .pagination li.active a, .pagination li:hover a,
        .pagination li.active a:hover, .pagination li:hover a:hover,
        .sidebar .widget.widget_search .input-group-btn, .tag-lists a:hover, .tagcloud a:hover,
        .BackTo, .ticket-btn.btn:hover, .schedule-listing .schedule-slot-time,
        .btn-primary, .navbar-toggler, .schedule-tabs-item ul li:before,
        .btn, .btn-primary, .wp-block-button .wp-block-button__link:not(.has-background),
        .ts-single-speaker .ts-social-list li a,
        .header-fullwidth .header-fullwidth-nav .navbar.navbar-light ul.navbar-nav > li > a:before,
        .ts-footer-social ul li a:hover, .ts-schedule-nav ul li a.active,
        .elementor-widget-accordion .elementor-accordion .elementor-accordion-item .elementor-active,
        .ts-speakers-style4 .ts-speaker .ts-speaker-info .ts-title,
        .testimonial-thumb .quote-icon,
        .schedule-tab-wrapper .etn-schedule-speaker .etn-schedule-single-speaker .etn-schedule-speaker-title,
        .etn-btn, 
        .attr-btn-primary, 
        .etn-ticket-widget .etn-btn,
        .post .play-btn.video-btn,
        .testimonial-item .testimonial-body .client-info .client-name::before,
        .ts-schedule-alt .schedule-listing .multi-speaker-2 .speaker-content .schedule-speaker,
        #preloader,
        .woocommerce div.product form.cart .button,
        .woocommerce ul.products li.product .added_to_cart,
        .sidebar.sidebar-woo .woocommerce-product-search button,
        .woocommerce table.cart td.actions button.button,
        .woocommerce a.button,
        .woocommerce button.button.alt,
        .woocommerce table.cart td.actions button.button:hover,
        .woocommerce a.button:hover,
        .woocommerce button.button.alt:hover,
        .woocommerce .checkout-button.button.alt.wc-forward,
        .woocommerce .woocommerce-Reviews #review_form #respond .form-submit input,
        .woocommerce span.onsale,
        .sinlge-event-registration,
        .etn_exhibz_inline_form_top .btn.btn-primary,
        .ts-event-archive-wrap .etn-event-item .ts_etn_thumb_meta_wraper .ts-event-term,
        .etn_load_more_button span{
            background: $style_primary;
        }
     
        .ts-map-tabs .elementor-tabs-wrapper .elementor-tab-title.elementor-active a,
        .wp-block-quote:before,
        .blog-single .post-navigation .post-next a:hover, 
        .blog-single .post-navigation .post-previous a:hover,
        .archive .ts-speaker:hover .ts-title a,
        .post-navigation span:hover, .post-navigation h3:hover,
        .etn-event-single-content-wrap .etn-event-meta .etn-event-category span,
        .etn-schedule-wrap .etn-schedule-info .etn-schedule-time,
        .footer-area .ts-footer-3 .footer-widget h3{
            color: $style_primary;
        }

        .ts-map-tabs .elementor-tabs-wrapper .elementor-tab-title.elementor-active a,
        .ts-map-tabs .elementor-tabs-wrapper .elementor-tab-title a:before,
        .schedule-tabs-item .schedule-listing-item:after,
        .ts-gallery-slider .owl-nav .owl-prev, .ts-gallery-slider .owl-nav .owl-next,
        .ts-schedule-alt .ts-schedule-nav ul li a.active{
            border-color: $style_primary;
        }
        .ts-schedule-alt .ts-schedule-nav ul li a::before,
        .schedule-tab-wrapper .attr-nav li:after,
        .schedule-tab-wrapper .etn-nav li a:after,
        .schedule-tab-wrapper .etn-schedule-speaker .etn-schedule-single-speaker .etn-schedule-speaker-title:after,
        .ts-schedule-alt .schedule-listing .multi-speaker-2 .speaker-content .schedule-speaker::after{
            border-color: $style_primary transparent transparent transparent;
        }

        .ts-schedule-nav ul li a:before{
            border-color: transparent $style_primary transparent transparent;
        }

        blockquote.wp-block-quote, 
        .wp-block-quote, 
        .wp-block-quote:not(.is-large):not(.is-style-large),
         blockquote.wp-block-pullquote, .wp-block-quote.is-large,
          .wp-block-quote.is-style-large,
          blockquote, .wp-block-quote:not(.is-large), .wp-block-quote:not(.is-style-large),
         .wp-block-pullquote:not(.is-style-solid-color){
             border-left-color:  $style_primary;
         }
         
         .schedule-tab-wrapper .attr-nav li.attr-active,
         .schedule-tab-wrapper .etn-nav li a.etn-active,
         .woocommerce div.product .woocommerce-tabs ul.tabs li.active{
             border-bottom-color:  $style_primary;
         }
        
        .woocommerce ul.products li.product .added_to_cart:hover,
        .nav-center-logo .navbar.navbar-light .collapse.justify-content-end ul.navbar-nav > li.nav-ticket-btn > a,
            .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover{background-color: $style_primary;}
            .woocommerce ul.products li.product .button,.woocommerce ul.products li.product .added_to_cart,
			.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.sponsor-web-link a:hover i
        {
          background-color: $style_primary;
          color: #fff;
        }

        .ts-single-speaker .ts-social-list li a:hover,
        .etn-ticket-widget .etn-btn:hover,
        .ts-speakers-style4 .ts-speaker .ts-speaker-info p{
            background: $secondary_color;
        }

        ";

    // footer style

    $footer_bg_color = exhibz_option( 'footer_bg_color', '#1a1831' );
    $footer_padding_top = exhibz_option( 'footer_padding_top', '250px' );

    $footer_bg_img = exhibz_option( 'footer_bg_img' );
      
    if(is_array($footer_bg_img) && isset($footer_bg_img['url']) && $footer_bg_img['url'] !=''){
        $footer_bg_img = $footer_bg_img['url'];
   }
   $footer_bg_url = 'background-image:url('. $footer_bg_img .');'; 

    // header btn
    $header_btn_bg_color = '';
    $header_btn_bg_color = isset($button_settings['header_btn_bg_color'])?$button_settings['header_btn_bg_color']:'#00c1c1';
  
      if($header_btn_bg_color==''){

         $header_btn_bg_color = '#00c1c1';
      }
   
       $output .= "
            .ticket-btn.btn{
               background-color: $header_btn_bg_color;  
          }
          ";

    // header sticky background 
    $output .= "
        @media (min-width: 1200px){
            .sticky.header-transparent,.div,
            .sticky.header-classic {
                background: $header_nav_sticky_bg;
            }
          } 
        ";
     $output	.= "

        .ts-footer{
            background-color: $footer_bg_color;
            padding-top:$footer_padding_top;
            $footer_bg_url;
        }
              

        ";


    wp_add_inline_style( 'exhibz-style', $output );

    
    $global_body_font = exhibz_option( 'body_font' );
    $heading_font_one = exhibz_option( 'heading_font_one' );   
    $heading_font_two = exhibz_option( 'heading_font_two' );
    $heading_font_three = exhibz_option( 'heading_font_three' );
    $elementkitsicons = exhibz_option('optimization_elementkitsicons_enable', 'yes');
    
    $font_list = [
        $global_body_font['family'],
        $heading_font_one['family'],
        $heading_font_two['family'],
        $heading_font_three['family']
    ];
    $ekitsicons_enable = [
        $elementkitsicons
    ];

    wp_add_inline_script( 'exhibz-script', 'var fontList = ' . wp_json_encode( $font_list ), 'before' );
    wp_add_inline_script( 'exhibz-all-script', 'var ekitsicons_enable = ' . wp_json_encode( $ekitsicons_enable ), 'before' );
    
}

