<?php   $category_limit = $exhibz_event_category_settings['category-options']['category_limit'];
    $categories_id  = $exhibz_event_category_settings['category-options']['categories_id'];
    $post_sort_by  = $exhibz_event_category_settings['category-options']['post_sort_by'];
    $hide_empty     = $exhibz_event_category_settings['hide_empty']=='yes'?'1':'0';
    $taxonomy       = 'etn_category';
    $term_link      = '';
   
    if(is_array($categories_id) && !empty($categories_id)){
        $cats = $categories_id;
    }else{
        $args_cat = array(
            'taxonomy'     => $taxonomy,
            'number' => $category_limit,
            'hide_empty' => $hide_empty,
            'orderby'    => 'post_date',
            'order'    => $post_sort_by,
        );
        $cats = get_categories( $args_cat );
    }
  
   
    ?>
    <div class="ts-event-category-slider" data-count="<?php echo esc_attr($category_limit); ?>">
        <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php  foreach($cats as $value){ 
                $term = get_term($value,$taxonomy); 
            
                if ( defined( 'FW' ) ) {
                    $img_id = fw_get_db_term_option($term->term_id, $taxonomy, 'event_category_featured_img');
        
                    ?>
                    <div class="swiper-slide">  
                        <div class="event-slider-item">
                            
                            <div class="cat-content">
                                
                                <h3 class="ts-title"> <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a>  </h3>
                            </div>

                            <?php 
                            if(!empty($img_id)){
                                $img_url = $img_id['url'];
                                $term_link = get_term_link($term->slug, $taxonomy);
                                if($img_url !=''):  ?>
                                    <div class="cat-bg">
                                        <a class="cat-link" href="<?php echo esc_url($term_link); ?>">
                                            <img src="<?php echo esc_url($img_url); ?>" alt="category-image">
                                        </a>
                                    </div>
                                <?php endif; 
                            } ?>
                        </div> 
                    </div>
                <?php 
                }
            } ?>
            </div>
        </div>
        <?php if ("yes" == $arrow_nav_show ):
            ?>
            <div class="slider-nav">
                <div class="swiper-button-prev swiper-prev-item">
                    <i class="icon icon-arrow-left"></i>
                </div>
                <div class="swiper-button-next swiper-next-item">
                    <i class="icon icon-arrow-right"></i>
                </div>
            </div>
        <?php endif; ?>
    </div>
   <?php 
