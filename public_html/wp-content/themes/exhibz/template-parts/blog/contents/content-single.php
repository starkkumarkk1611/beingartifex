<article id="post-<?php the_ID(); ?>" <?php post_class( ' post-details' ); ?>>

	<!-- Article header -->
	<header class="entry-header text-center clearfix">
		<h1 class="entry-title">
			<?php  the_title(); ?>
		</h1>
		<?php exhibz_post_meta(); ?>	
	</header><!-- header end -->

	

	<?php if ( has_post_thumbnail() && !post_password_required() ) : ?>
		<div class="entry-thumbnail post-media post-image text-center">
            <?php if(get_post_format()=='video'): ?>
                  <?php get_template_part( 'template-parts/blog/post-parts/part-single', 'video' ); ?> 
            <?php else: ?>
		     <img class="img-fluid" src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt=" <?php the_title_attribute(); ?>">
            <?php 
               $caption = get_the_post_thumbnail_caption();
               if($caption !=''):
                  ?>
                  <p class="img-caption-text"><?php the_post_thumbnail_caption(); ?></p>

             <?php 
                  endif;
               endif;
             ?>
 
      </div>
    
	<?php endif; ?>



	<div class="post-body clearfix">
		<!-- Article content -->
		<div class="entry-content clearfix">
			<?php
			if ( is_search() ) {
				the_excerpt();
			} else {
				the_content( esc_html__( 'Continue reading &rarr;', 'exhibz' ) );
				exhibz_link_pages();
			}
			?>
		</div> <!-- end entry-content -->
    </div> <!-- end post-body -->
</article>