<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php roots_post_before(); ?>
    <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <?php roots_post_inside_before(); ?>
      <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="single-meta"><?php roots_entry_meta(); ?></div>
        <div class="social-buttons clearfix">
         	<div class="pull-left">
    			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="true" data-layout="button_count" data-width="90" data-show-faces="false" data-font="segoe ui"></div>
    		</div>
    		<div class="pull-left smallwidth">
    			<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
    		</div>
    		<div class="pull-left">
    			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>">Tweet</a>
    			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    		</div>
    		<div class="pull-left smallwidth">
    		<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a>
    		</div>
    	</div>
      </header>
      <div class="entry-content-single">
       <?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 image attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image attachment, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
						<p class="attachment"><a href="<?php echo $next_attachment_url; ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
							$attachment_width  = apply_filters( 'twentyten_attachment_size', 900 );
							$attachment_height = apply_filters( 'twentyten_attachment_height', 900 );
							echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) ); // filterable image width with, essentially, no limit for image height.
						?></a></p>

						<div id="nav-below" class="navigation">
							<div class="nav-previous"><?php previous_image_link( false ); ?></div>
							<div class="nav-next"><?php next_image_link( false ); ?></div>
						</div><!-- #nav-below -->
<?php else : ?>
						<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
<?php endif; ?>
						</div><!-- .entry-attachment -->
						<div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>
      </div>
      <footer>
        <?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
        <!--<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(); ?></p><?php } ?>-->
      </footer>
      <?php comments_template(); ?>
      <?php roots_post_inside_after(); ?>
    </article>
  <?php roots_post_after(); ?>
<?php endwhile; /* End loop */ ?>
