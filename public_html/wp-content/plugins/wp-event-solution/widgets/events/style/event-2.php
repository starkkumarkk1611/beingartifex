<?php
if (!defined('ABSPATH')) exit;

use \Etn\Utils\Helper as Helper;

$data           = Helper::post_data_query('etn', $event_count, $order, $event_cat, 
'etn_category', null, null, $event_tag,  $orderby_meta, $orderby, $filter_with_status);
$date_format    = Helper::get_option("date_format");
$date_options   = Helper::get_date_formats();

?>
<div class='etn-row etn-event-wrapper etn-event-list2'>
    <?php
    if (!empty($data)) {
        foreach ($data as $value) {

            $social             = get_post_meta($value->ID, 'etn_event_socials', true);
            $etn_event_location = get_post_meta($value->ID, 'etn_event_location', true);
            $etn_start_date     = get_post_meta($value->ID, 'etn_start_date', true);
            $event_start_date   = !empty( $date_format ) ? date_i18n($date_options[$date_format], strtotime($etn_start_date)) : date_i18n(get_option("date_format"), strtotime($etn_start_date));
            $category           =  Helper::cate_with_link($value->ID, 'etn_category');
            $variation_price    = [];
            $etn_ticket_variations    = get_post_meta($value->ID,"etn_ticket_variations", true); 
            if(!empty($etn_ticket_variations) && is_array($etn_ticket_variations)){
                foreach($etn_ticket_variations as $index => $price){
                    $variation_price[$index] =  $price['etn_ticket_price'];
                } 
                $min_price = min($variation_price); 
                $max_price = max($variation_price);  
            } 
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
                        <div class="event-top-meta">
                            <?php if (isset($etn_event_location) && $etn_event_location != '') { ?>
                                <div class="etn-event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($etn_event_location); ?></div>
                            <?php } ?>

                            <?php if (!empty($variation_price[0]) && !empty($variation_price) && class_exists('woocommerce')){  ?>
                                <div class='etn-ticket-price'>
                                    <i class="fas fa-money-bill"></i>

                                    <?php
                                        $currency = get_woocommerce_currency_symbol();
                                        if($min_price === $max_price){
                                            $price =  $currency . $min_price;
                                        }else {
                                            $price =  $currency . $min_price ."-". $currency . $max_price;
                                        } 
                                    ?>
                                    <?php echo esc_html($price); ?>
                                </div>
                            <?php } ?>
                        </div>

                        <h3 class="etn-title etn-event-title"><a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>"> <?php echo esc_html(get_the_title($value->ID)); ?></a> </h3>
                        <p><?php echo esc_html(Helper::trim_words(get_the_excerpt($value->ID), $etn_desc_limit)); ?></p>
                        <div class="etn-event-footer">
                            <div class="etn-event-date">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo esc_html($event_start_date); ?>
                            </div>
                            <div class="etn-atend-btn">
                                <?php
                                $show_form_button = apply_filters("etn_form_submit_visibility", true, $value->ID);
                                if ($show_form_button === false) {
                                    ?>
                                    <a href="#" class="etn-btn etn-btn-border"><?php echo esc_html__('Expired!', "eventin"); ?> </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>" class="etn-btn etn-btn-border"><?php echo esc_html__('Attend', 'eventin') ?> <i class="fas fa-arrow-right"></i></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- content end-->
                </div>
                <!-- etn event item end-->
            </div>
            <?php
        }
    }else{
        ?>
        <p class="etn-not-found-post"><?php echo esc_html__('No Post Found'); ?></p>
        <?php
    } ?>
</div>