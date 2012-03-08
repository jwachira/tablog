<?php get_header(); ?>
<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
</div>
  <?php roots_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php roots_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <?php roots_post_inside_before(); ?>
      <header>
        <h1 class="entry-title">
        	<?php _e('File Not Found', 'roots'); ?>
        </h1>
      </header>
      <div class="entry-content-single">
         <div class="alert alert-block fade in">
          <a class="close" data-dismiss="alert">×</a>
          <p><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'roots'); ?></p>
        </div>
        <p><?php _e('Please try the following:', 'roots'); ?></p>
        <ul>
          <li><?php _e('Check your spelling', 'roots'); ?></li>
          <li><?php printf(__('Return to the <a href="%s">home page</a>', 'roots'), home_url()); ?></li>
          <li><?php _e('Click the <a href="javascript:history.back()">Back</a> button', 'roots'); ?></li>
        </ul>
      </div>
      <footer>
        <?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
        <!--<?php $tags = get_the_tags(); if ($tags) { ?><p><?php the_tags(); ?></p><?php } ?>-->
      </footer>
      <?php roots_post_inside_after(); ?>
    </article>
      </div><!-- /#main -->
    <?php roots_main_after(); ?>
    <?php roots_sidebar_before(); ?>
      <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
      <?php roots_sidebar_inside_before(); ?>
        <?php get_sidebar(); ?>
      <?php roots_sidebar_inside_after(); ?>
      </aside><!-- /#sidebar -->
    <?php roots_sidebar_after(); ?>
    </div><!-- /#content -->
  <?php roots_content_after(); ?>
<?php get_footer(); ?>

