<?php
/**
 * the template for displaying all posts.
 */

get_header(); 
get_template_part( 'template-parts/banner/content', 'banner-blog' );

$blog_single_sidebar = exhibz_option('blog_single_sidebar',1); 

$column = ($blog_single_sidebar == 1 || !is_active_sidebar('sidebar-1')) ? 'col-lg-10' : 'col-lg-8 col-md-12';

?>
<div id="main-content" class="main-container blog-single"  role="main">
    <div class="container">
        <div class="row">
			<?php if($blog_single_sidebar == 2){
				get_sidebar();
			}  ?>
			
            <div class="<?php echo esc_attr($column);?> mx-auto">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="content-single">

						<div class="entry-content">
							<?php get_template_part( 'template-parts/blog/contents/content', 'single' ); ?>
	
						</div> <!-- .entry-content -->

						<footer class="entry-footer clearfix">
							<?php get_template_part( 'template-parts/blog/post-parts/part', 'tags' ); ?>

							<?php
							if ( is_user_logged_in() ) {
                     ?>

                     <p>
                     <?php
								edit_post_link( 
									esc_html__( 'Edit', 'exhibz' ), 
									'<span class="meta-edit">', 
									'</span>'
                        );
                     ?>   
								</p>
						  <?php                 	}
							?>
						</footer> <!-- .entry-footer -->

						<?php 
							// post navigation, to next post or prev post
							// location:helpers/functions/template.php
							exhibz_post_nav(); 
						?>
					</div>

					<?php get_template_part( 'template-parts/blog/post-parts/part', 'author' ); ?>

					<?php comments_template(); ?>
				<?php endwhile; ?>
            </div> <!-- .col-md-8 -->

			<?php if($blog_single_sidebar == 3){
				get_sidebar();
			}  ?>
          
        </div> <!-- .row -->
    </div> <!-- .container -->
</div> <!--#main-content -->
<?php get_footer(); ?>