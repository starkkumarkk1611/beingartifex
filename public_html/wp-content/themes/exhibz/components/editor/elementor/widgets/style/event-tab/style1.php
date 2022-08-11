<?php
use \Etn\Utils\Helper as Helper;
$date_format    = Helper::get_option("date_format");
$date_options   = Helper::get_date_formats();

$i = 0;

?>
<!-- schedule tab start -->
<div class="container">
    <div class="exhibz-event-tab">
        <div class="event-tab-wrapper etn-tab-wrapper event-tab-1">
        <ul class='etn-nav'>
        
            <?php           if( !empty($event_cats ) ){
                foreach((array)$event_cats as $key=> $cat_id){

                    $i++;
                    $category =  get_term($cat_id);
                    $category_name = (!empty($cat_id)) ? $category->name : '';
                    $active_class = ($i===1) ? 'etn-active' : '';
                    ?>
                    <li>
                        <a href='#' class='etn-tab-a <?php echo esc_attr($active_class); ?>' data-id='tab<?php echo esc_attr($widget_id) . "-" . $i; ?>'>
                            <?php                           echo esc_html($category_name); 
                            ?>
                        </a>
                    </li>
                    <?php               }
            }
            ?>
        </ul>

        <div class='etn-tab-content clearfix etn-schedule-wrap'>
            <?php           if( !empty($event_cats ) ){

                $j = 0;
                foreach($event_cats as $key=> $event_cat){
                    $j++;
                    $event_cat = [$event_cat];
                    $active_class = (($j == 1) ? 'tab-active' : '');
                    ?>
                    <div class="etn-tab <?php echo esc_attr($active_class); ?>" data-id='tab<?php echo esc_attr($widget_id) . "-" . $j; ?>'>
                    <?php                   if (!defined('ABSPATH')) exit;


                    $data           = Helper::post_data_query('etn', $event_count, $order, $event_cat, 'etn_category', null, null, $event_tag,  $orderby_meta, $orderby, $filter_with_status);
                    $date_format    = Helper::get_option("date_format");
                    $date_options   = Helper::get_date_formats();
                    ?>
                <div class='etn-row etn-event-wrapper'>
                    <?php                   if (!empty($data)) {
                    foreach ($data as $value) {

                        $social             = get_post_meta($value->ID, 'etn_event_socials', true);
                        $etn_event_location = get_post_meta($value->ID, 'etn_event_location', true);
                        $etn_start_date     = get_post_meta($value->ID, 'etn_start_date', true);
                        $event_start_date   = !empty( $date_format ) ? date_i18n($date_options[$date_format], strtotime($etn_start_date)) : date_i18n(get_option("date_format"), strtotime($etn_start_date));
                        $category           =  Helper::cate_with_link($value->ID, 'etn_category', 0);
                        ?>
                        <div class="etn-col-md-6 etn-col-lg-<?php echo esc_attr($etn_event_col); ?>">
                            <div class="etn-event-item">
                                <!-- thumbnail -->
                                <?php if (get_the_post_thumbnail_url($value->ID)) { ?>
                                    <div class="etn-event-thumb">
                                        <a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>">
                                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($value->ID)); ?>" alt="<?php the_title_attribute($value->ID); ?>">
                                        </a>
                                        <div class="etn-event-category">
                                            <?php echo  Helper::kses($category); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- thumbnail start-->

                                <!-- content start-->
                                <div class="etn-event-content">
                                    <div class="event-metas">
                                        <div class="etn-event-date">
                                            <i class="far fa-calendar-alt"></i>
                                            <?php echo esc_html($event_start_date); ?>
                                        </div>
                                    </div>
                                    <h3 class="etn-title etn-event-title"><a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>"> <?php echo wp_trim_words(get_the_title($value->ID), $etn_title_limit, ''); ?></a> </h3>
                                    <p><?php echo esc_html(Helper::trim_words($value->post_content, $etn_desc_limit)); ?></p>
                                    <div class="etn-event-footer">
                                        
                                        <?php if (isset($etn_event_location) && $etn_event_location != '') { ?>
                                        <div class="etn-event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($etn_event_location); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- content end-->
                            </div>
                            <!-- etn event item end-->
                        </div>
                        <?php                   }
                }else{
                    ?>
                    <p class="etn-not-found-post"><?php echo esc_html__('No Post Found', 'exhibz'); ?></p>
                    <?php               } ?>
            </div>
                    </div>
            
                <?php               }
            }
            ?>
        </div>
    </div>
    </div>
</div>


