<?php if ( function_exists( 'bp_get_simple_blog_post_form' ) ): ?>
<?php 
    $form = bp_get_simple_blog_post_form( 'buddyblogmusic-user-posts' );
                            
    $form->show();
?>

<?php else: ?>
	<?php _e( 'Please Install <a href="http://buddydev.com/plugins/bp-simple-front-end-post/"> BP Simple Front End Post Plugin to make the editing functionality work.', 'buddyblogmusic' );?>
<?php endif; ?>
