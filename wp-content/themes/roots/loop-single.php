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
        <?php the_content(); ?>
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