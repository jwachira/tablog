<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if (!have_posts()) { ?>
  <div class="alert alert-block fade in">
    <a class="close" data-dismiss="alert">×</a>
    <p><?php _e('Sorry, no results were found.', 'roots'); ?></p>
  </div>
  <?php get_search_form(); ?>
<?php } ?>

<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
  <?php roots_post_before(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php roots_post_inside_before(); ?>
      <header>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php roots_entry_meta(); ?>
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
      <div class="entry-content">
        <?php if (is_archive() || is_search()) { ?>
          <?php the_excerpt(); ?>
        <?php } else {
        		if ( has_post_thumbnail($thumbnail->ID)) {
      echo '<a href="' . get_permalink( $thumbnail->ID ) . '" title="' . esc_attr( $thumbnail->post_title ) . '">';
      echo get_the_post_thumbnail($thumbnail->ID, 'medium');
      echo '</a>';
    }
 the_content('',TRUE,''); ?>
        <?php } ?>
      </div>
      <footer>

      </footer>
    <?php roots_post_inside_after(); ?>
    </article>
  <?php roots_post_after(); ?>
<?php endwhile; /* End loop */ ?>