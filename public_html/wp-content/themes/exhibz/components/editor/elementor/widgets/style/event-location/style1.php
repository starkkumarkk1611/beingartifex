<?php
if(!empty($location_slugs)){
    $cats = $location_slugs;
}else{
    $args_cat = array(
        'taxonomy'     => 'event_location',
        'number' => $event_count,
        'hide_empty' => false,
    );
    $tax_terms = get_terms( $args_cat );
    $category_list = [];
    if(!empty($tax_terms)){
        foreach($tax_terms as $term_single) {      
            $category_list[] = $term_single->slug;
        }
    }        
    $cats = $category_list;    
}

if(!empty($cats)){
    ?>

    <div class="row">
        <?php       foreach($cats as $key=> $location_slug):
            $category =  get_term_by('slug', $location_slug, 'event_location');
            $category_featured_image = fw_get_db_term_option($category->term_id, 'event_location', 'featured_upload_img');

            $args = array(
                'post_type' =>  'etn',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'event_location',
                        'field'    => 'slug',
                        'terms'    => $location_slug,
                    ),
                ),
            );
        
            $tax_query = new WP_Query( $args );    
            $count_events = $tax_query->found_posts;  
            ?>
            <div class="col-lg-<?php echo esc_attr($etn_event_col); ?> col-md-6">
                <div class="location-box">
                    <?php if(!empty($category_featured_image)){ ?>
                    <div class="location-image">
                    <a href="<?php echo esc_url( get_term_link($category->term_id, 'event_location') ); ?>"><img src="<?php echo esc_url($category_featured_image['url']); ?>" alt="<?php echo esc_attr__('location image', 'exhibz'); ?>" /></a>
                    </div>
                    <?php } ?>
                    <div class="location-des">
                        <a href="<?php echo esc_url( get_term_link($category->term_id, 'event_location') ); ?>">
                            <span class="location-name"><?php echo esc_html($category->name); ?></span>
                            <span class="event-number"><?php echo esc_html($count_events); ?> <?php echo esc_html__('Events', 'exhibz'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>   
    </div>
<?php } ?>
