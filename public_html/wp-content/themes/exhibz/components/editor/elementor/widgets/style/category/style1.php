<?php   $category_limit = $exhibz_event_category_settings['category-options']['category_limit'];
    $categories_id  = $exhibz_event_category_settings['category-options']['categories_id'];
    $post_sort_by  = $exhibz_event_category_settings['category-options']['post_sort_by'];
    $hide_empty     = $exhibz_event_category_settings['hide_empty']=='yes'?'1':'0';
    $taxonomy       = 'etn_category';

   
    if(count($categories_id)){
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
  <div class="ts-event-category">
        <?php  foreach($cats as $value){ 
            $term = get_term($value,$taxonomy); 
           
            if ( defined( 'FW' ) ) {
            $img_id = fw_get_db_term_option($term->term_id, $taxonomy, 'event_category_featured_img');
            $img_url = $img_id['url'];
            $term_link = get_term_link($term->slug, $taxonomy);
    
        ?>
            <div class="event-cat-item">
                <?php if($img_url !=''):  ?>
                    <div class="cat-bg" style="background-image: url('<?php echo  esc_url($img_url) ?>');">
                        <a class="cat-link" href="<?php echo esc_url($term_link); ?>"></a>
                    </div>
                <?php endif; ?>

                <div class="cat-content">
                    
                    <h3 class="ts-title"> <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a>  </h3>
                    <p class="cat-count"> 
                        <?php                           printf( _nx( '%s Event', '%s Events', $term->count, 'Events', 'exhibz' ), number_format_i18n( $term->count ) );
                        ?> 
                    </p>
                </div>
            </div> 
            <?php 
            }
        } ?>
    </div>
   <?php 
