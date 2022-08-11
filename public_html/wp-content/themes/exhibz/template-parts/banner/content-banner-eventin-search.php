<?php   $banner_image            = '';
    $banner_title            = '';
    $banner_sub_title        = '';
    $blog_banner_title_color = "";
    $show_breadcrumb         = "";
    $blog_show_banner        = "";
    $blog_show_search_form   = "yes";

    if ( defined( 'FW' ) ) { 

        $banner_settings = exhibz_option('event_banner_settings'); 
    
        //image
        $banner_image = ( is_array($banner_settings['event_banner_image']) && $banner_settings['event_banner_image']['url'] != '') ? 
        $banner_settings['event_banner_image']['url'] : EXHIBZ_IMG.'/banner/banner_bg.jpg';

        //show
        $blog_show_banner = (isset($banner_settings['event_show_banner'])) ? $banner_settings['event_show_banner'] : 'yes'; 
    
        $show_breadcrumb =  (isset($banner_settings['event_show_breadcrumb'])) ? $banner_settings['event_show_breadcrumb'] : 'yes';
        $blog_show_search_form =  (isset($banner_settings['eventin_search_page_show_search_form'])) ? $banner_settings['eventin_search_page_show_search_form'] : 'yes';
       
        

    }else{
        //default
        $banner_image = EXHIBZ_IMG.'/banner/banner_bg.jpg';
        $blog_banner_title_color = "#FFFFFF";
        $show_breadcrumb         = "no";
    }

    if( isset($banner_image) && $banner_image != ''){
        $banner_image = esc_url( $banner_image );
    }

    
    $event_location = "";
    if (isset($_GET['etn_event_location']) && !empty($_GET['etn_event_location'])) {
        $event_location = $_GET['etn_event_location'];
    }
    $count = count(get_exhibz_eventin_data());
?>
<?php if($blog_show_banner === "yes") { ?>
<section class="ts-banner banner-area ts_eventin_banner blog-banner <?php echo esc_attr($banner_image == ''?'banner-solid':'banner-bg'); ?>"  style="background-image: url(<?php echo esc_attr( $banner_image ); ?>)">
    <div class="container">
        <div class="d-flex align-items-cente">
            <div class="row w-100">
                <div class="col-lg-12 text-center">
                    <h1 class="banner-title banner-blog-title" style="color: <?php echo esc_attr($blog_banner_title_color === '' ? '#ffffff' : $blog_banner_title_color); ?>">
                        <?php echo esc_html__( "Search: Event in ".$event_location."", "exhibz" ); ?>
                    </h1>
                    <p class="banner-subtitle banner-blog-title" style="color: <?php echo esc_attr($blog_banner_title_color === '' ? '#ffffff' : $blog_banner_title_color); ?>">
                        <?php echo esc_html__( "Discover ". $count ." Upcoming "._n( "Event", "Events", $count, "exhibz" )."", "exhibz" ); ?>
                    </p>
                </div>
            </div>
        </div>
        <?php           if( $show_breadcrumb == 'yes' && !is_home(  ) ){
                exhibz_get_breadcrumbs();
            }
        ?>
    </div>
</section>
<?php } ?>

<?php if($blog_show_search_form === "yes") { ?>
<section class="banner_search_form_wraper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php get_exhibz_event_search_form(); ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>