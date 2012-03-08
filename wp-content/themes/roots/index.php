<?php get_header(); ?>
 	<img class="hero-main" src="<?php echo home_url(); ?>/wp-content/themes/roots/img/hero-unit.jpg"/>
    	<h2>Get Certified, an interview and a featured gallery shared with 4 million fans here!</h2>
    	<img src="<?php echo home_url(); ?>/wp-content/themes/roots/img/sep.png" alt="separator"/>
    	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
  	</div>
  <?php roots_content_before(); ?>
    <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
    <?php roots_main_before(); ?>
      <div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
      	
        <?php get_template_part('loop', 'index'); ?>
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