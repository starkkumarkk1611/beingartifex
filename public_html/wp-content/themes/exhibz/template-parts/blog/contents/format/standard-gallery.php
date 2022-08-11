   <?php if (has_post_thumbnail()) : ?>
      <div class="post-media post-video">
         <img class="img-fluid" alt="<?php the_title_attribute(); ?>" src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
         <?php        if (is_sticky()) {
            echo '<sup class="meta-featured-post"> <i class="icon icon-thumbtack"></i> ' . esc_html__('Sticky', 'exhibz') . ' </sup>';
         }
         ?>

         <?php if (defined('FW') && exhibz_meta_option(get_the_ID(), 'featured_video') != '') :  ?>
            <div class="video-link-btn">
               <a href="<?php echo exhibz_meta_option(get_the_ID(), 'featured_video'); ?>" class="play-btn popup-btn"><i class="icon icon-play"></i></a>
            </div>
         <?php endif; ?>
      </div>
   <?php endif; ?>

   <div class="post-body">
      <div class="entry-header">
         <?php exhibz_post_meta(); ?>
         <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <?php if (is_sticky()) {
               echo '<sup class="meta-featured-post"> <i class="icon icon-thumbtack"></i> ' . esc_html__('Sticky', 'exhibz') . ' </sup>';
            } ?>
         </h2>

         <div class="entry-content">
            <?php exhibz_excerpt(40, null); ?>
         </div>

         <div class="post-footer">
            <a class="btn-readmore" href="<?php the_permalink(); ?>">
               <?php esc_html_e('Read More', 'exhibz') ?>
               <i class="icon icon-arrow-right"></i>
            </a>
         </div>

      </div><!-- Entry header end -->
   </div><!-- Post body end -->