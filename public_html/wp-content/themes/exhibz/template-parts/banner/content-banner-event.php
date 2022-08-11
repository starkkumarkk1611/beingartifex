<?php 

   $exhibz_banner_image    =  '';
   $exhibz_banner_title    = '';
   $exhibz_header_style    = 'standard';
   
if ( defined( 'FW' ) ) { 
   
   $exhibz_banner_settings         = exhibz_option('event_banner_setting'); 
   $exhibz_banner_style            = exhibz_option('sub_page_banner_style');
   $exhibz_header_style            = exhibz_option('header_layout_style', 'standard');

   $exhibz_banner_image             = exhibz_meta_option( get_the_ID(), 'event_banner_image' );

    //image
    if(is_array($exhibz_banner_image) && $exhibz_banner_image['url'] != '' ){
      $exhibz_banner_image = $exhibz_banner_image['url'];
   }elseif( is_array($exhibz_banner_settings['banner_event_image']) && $exhibz_banner_settings['banner_event_image']['url'] != ''){
         $exhibz_banner_image = $exhibz_banner_settings['banner_event_image']['url'];
   }else{
      
         $exhibz_banner_image = EXHIBZ_IMG.'/banner/banner_bg.jpg';
   }


   //title 
   $exhibz_banner_title = (isset($exhibz_banner_settings['banner_event_title']) && $exhibz_banner_settings['banner_event_title'] != '') ? 
   $exhibz_banner_settings['banner_event_title'] : get_bloginfo( 'name' );
   
   //show
   $exhibz_show = (isset($exhibz_banner_settings['event_show_banner'])) ? $exhibz_banner_settings['event_show_banner'] : 'yes'; 
   // banner overlay
   $exhibz_show = (isset($exhibz_banner_settings['event_show_banner'])) ? $exhibz_banner_settings['event_show_banner'] : 'yes'; 
    
   //breadcumb 
   $exhibz_show_breadcrumb =  (isset($exhibz_banner_settings['event_show_breadcrumb'])) ? $exhibz_banner_settings['event_show_breadcrumb'] : 'yes';

 }else{
   //default
   $exhibz_banner_image             = '';
   $exhibz_banner_title             = get_bloginfo( 'name' );
   $exhibz_show                     = 'yes';
   $exhibz_show_breadcrumb          = 'no';
     
 }
 if( isset($exhibz_banner_image) && $exhibz_banner_image != ''){
    $exhibz_banner_image = 'style="background-image:url('.esc_url( $exhibz_banner_image ).');"';
}
$exhibz_banner_heading_class = '';
if($exhibz_header_style=="transparent"):
   $exhibz_banner_heading_class  = "mt-80";   
endif;  
?>

<?php if(isset($exhibz_show) && $exhibz_show == 'yes'): ?>

     <div class="event-banner ts_eventin_banner align-items-center <?php echo esc_attr($exhibz_banner_image == ''?'banner-solid':'banner-bg'); ?>" <?php echo exhibz_kses( $exhibz_banner_image ); ?>>
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-12">
                        <h2 class="banner-title <?php echo esc_attr($exhibz_banner_heading_class); ?>">
                           <?php 
                              if(is_archive()){
                                    the_archive_title();
                              }elseif(is_single()){
                                 the_title();
                              }
                              else{
                                 $exhibz_title = str_replace(['{', '}'], ['<span>', '</span>'],$exhibz_banner_title ); 
                                 echo exhibz_kses( $exhibz_title);
                              }
                           ?> 
                        </h2>
                        <?php if(isset($exhibz_show_breadcrumb) && $exhibz_show_breadcrumb == 'yes'): ?>
                           <?php exhibz_get_breadcrumbs('/'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>  
  
<?php endif; ?>     