<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

  <meta name="viewport" content="width=device-width">

  <?php roots_stylesheets(); ?>

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">

  <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.5.0.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <?php roots_head(); ?>
  <?php wp_head(); ?>

</head>

<body <?php body_class(roots_body_class()); ?>>
<!-- FACEBOOK -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="fb-root"></div>
<!-- END FACEBOOK -->
<!-- G + -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<!-- END G + -->
  <!--[if lt IE 7]><p class="chromeframe">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

  <?php roots_header_before(); ?>
    <header id="banner" class="navbar navbar-fixed-top" role="banner">
      <?php roots_header_inside(); ?>
      <div class="navbar-inner">
        <div class="<?php echo WRAP_CLASSES; ?>">
         <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <nav id="nav-main" class="nav-collapse" role="navigation">
            <?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'walker' => new Roots_Navbar_Nav_Walker())); ?>
          </nav>
          <div class="pull-right">
          	<?php get_search_form(); ?>
          </div>
        </div>
      </div>
    </header>
  <?php roots_header_after(); ?>

  <?php roots_wrap_before(); ?>
  <div id="wrap-bg">
  <div id="wrap" class="<?php echo WRAP_CLASSES; ?>" role="document">
  	<div class="hero-unit">
  		<a id="logo" href="<?php echo home_url(); ?>/">
          	<img src="<?php echo home_url(); ?>/wp-content/themes/roots/img/logo.png" width="356" height="71" alt="<?php bloginfo('name'); ?>"/>
        </a>
        <div class="social-buttons pull-right">
    		<div class="pull-right">
    			<div class="g-plusone" data-size="medium" data-href="https://plus.google.com/106589126611587747954"></div>
    		</div>
    		<div class="pull-right">
    			<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
    			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    		</div>
    		<div class="pull-right">
    			<div class="fb-like" data-href="http://www.facebook.com/tattoos1" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="segoe ui"></div>
    		</div>
    	</div>
    	<img src="<?php echo home_url(); ?>/wp-content/themes/roots/img/sep.png" alt=""/>
   