<?php

   $blog_author = exhibz_option('blog_author');

?>
<?php if($blog_author=="yes"): ?>
<div class="author-box solid-bg">
    <div class="author-img">
       <?php echo get_avatar(get_the_author_meta( 'ID' ));  ?>
    </div>
    <div class="author-info">
        <h5 class="post_author_title">
            <?php echo get_the_author(); ?>
            <?php if (get_the_author_meta('user_url') != "") { ?>
            <a class="author-url" href="<?php echo get_the_author_meta('user_url'); ?>">(<?php echo esc_html__( 'Website', 'exhibz' ); ?>)</a>
            <?php } ?>
        </h5>
        <p class="post_author_role">
        <?php           //gets the ID of the post
            $post_id = get_queried_object_id();

            //gets the ID of the author using the ID of the post
            $author_ID = get_post_field( 'post_author', $post_id );

            //Gets all the data of the author, using the ID
            $authorData = get_userdata( $author_ID );

            //checks if the author has the role of 'subscriber', 'editor', 'administrator', 'author', 'contributor' and 'Super admin'
            if ($authorData) {
               if (in_array( 'administrator', $authorData->roles) || in_array( 'editor', $authorData->roles) || in_array( 'author', $authorData->roles) || in_array( 'contributor', $authorData->roles) || in_array( 'subscriber', $authorData->roles)) {
                  echo esc_html($authorData->roles[0]);
               } else {
                  echo esc_html__( 'Super Admin', 'exhibz' );
               }
            }
        ?>
        </p>
        <?php if (get_the_author_meta('user_description') !== "") { ?>
         <p class="user_description">
            <?php echo get_the_author_meta('user_description'); ?>
         </p>
        <?php }?>
     </div>
</div> <!-- Author box end -->
<?php endif; ?>