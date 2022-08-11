
  
  
      <?php if( defined( 'FW' ) && exhibz_meta_option(get_the_ID(),'featured_video')!=''): ?>
      
            <?php 
               $video_url = exhibz_meta_option(get_the_ID(), 'featured_video', '');
               $video_url = exhibz_video_embed($video_url);
            ?>
            <div class="embed-responsive embed-responsive-16by9">
               <iframe class="embed-responsive-item" src="<?php echo esc_url($video_url); ?>" allowfullscreen>
               </iframe>
            </div>

      <?php endif; ?> 
