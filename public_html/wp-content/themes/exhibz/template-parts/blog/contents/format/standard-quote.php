<div class="post-quote-wrapper">
   <div class="post-quote-content text-center">
      <div class="entry-header">

           
            <i class="quote icon icon-quote1"></i>

            <h2 class="entry-title">
               <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
      <?php if ( is_sticky() ) {
            echo '<sup class="meta-featured-post"> <i class="icon icon-thumbtack"></i> ' . esc_html__( 'Sticky', 'exhibz' ) . ' </sup>';
      } ?>
      </div>

   </div>
</div>