<?php // https://github.com/retlehs/roots/wiki

if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }

require_once locate_template('/inc/roots-config.php');      // config
require_once locate_template('/inc/roots-activation.php');  // activation
require_once locate_template('/inc/roots-cleanup.php');     // cleanup
require_once locate_template('/inc/roots-scripts.php');     // modified scripts output
require_once locate_template('/inc/roots-htaccess.php');    // rewrites for assets, h5bp htaccess
require_once locate_template('/inc/roots-hooks.php');       // hooks
require_once locate_template('/inc/roots-actions.php');     // actions
require_once locate_template('/inc/roots-widgets.php');     // widgets
require_once locate_template('/inc/roots-custom.php');      // custom functions

// set the maximum 'Large' image width to the maximum grid width
// http://wordpress.stackexchange.com/q/11766
if (!isset($content_width)) { $content_width = 940; }

function roots_setup() {
  load_theme_textdomain('roots', get_template_directory() . '/lang');

  // tell the TinyMCE editor to use editor-style.css
  // if you have issues with getting the editor to show your changes then
  // use this instead: add_editor_style('editor-style.css?' . time());
  add_editor_style('editor-style.css');

  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support('post-thumbnails');
  add_image_size( 'sidebar-thumb', 48, 48, true );
  add_image_size( 'home-thumb', 226, 137, true );
  add_image_size( 'main-thumb', 226, 137, true );
  // set_post_thumbnail_size(150, 150, false);


  // http://codex.wordpress.org/Post_Formats
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots')
  ));
}

add_action('after_setup_theme', 'roots_setup');

// http://codex.wordpress.org/Function_Reference/register_sidebar
function roots_register_sidebars() {
  $sidebars = array('Sidebar', 'Footer');

  foreach($sidebars as $sidebar) {
    register_sidebar(
      array(
        'id'            => 'roots-' . sanitize_title($sidebar),
        'name'          => __($sidebar, 'roots'),
        'description'   => __($sidebar, 'roots'),
        'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></article>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
      )
    );
  }
}

add_action('widgets_init', 'roots_register_sidebars');

// return post entry meta information
function roots_entry_meta() {
	$the_cat = get_the_category();
	$category_name = $the_cat[0]->cat_name;
	$category_description = $the_cat[0]->category_description;
	$category_link = get_category_link( $the_cat[0]->cat_ID );
	$num_comments = get_comments_number(); // for some reason get_comments_number only returns a numeric value displaying the number of comments
 if ( comments_open() ){
 	  if($num_comments == 0){
 	  	  $comments = __('0 Comments');
 	  }
 	  elseif($num_comments > 1){
 	  	  $comments = $num_comments. __('Comments');
 	  }
 	  else{
 	  	   $comments ="1 Comment";
 }}
  echo '<time class="updated" datetime="'. get_the_time('c') .'" pubdate>'. sprintf(__('%s', 'roots'), get_the_date()) .'</time>';
  echo '<p class="byline author vcard">'. __('by', 'roots') .' <a href="'. get_author_posts_url(get_the_author_meta('id')) .'" rel="author" class="fn">'. get_the_author() .'</a></p><span class="divider">/</span>';
  echo '<p class="byline author vcard hcat"><a href="'.$category_link.'">'.$category_name.'</a></p><span class="divider">/</span>';
  echo '<p class="byline author vcard hcomment"><a href="'.get_comments_link( $post->ID ).'">'.$comments.'</a></p>';
                                                                         
}

// breadcrumbs
function dimox_breadcrumbs() {
 
  $delimiter = '<span class="divider">>></span></li>';
  $home = 'Home'; // text for the 'Home' link
  $before = '<li class="active">'; // tag before the current crumb
  $after = '</li>'; // tag after the current crumb
 
  if ( is_home() || is_front_page() || is_paged() || is_single() ) {
 
  	echo '<ul class="breadcrumb">You are here: ';
 
    global $post;
    $homeLink = get_bloginfo('url');
    if (is_home()) {
    	echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
    }
 
    elseif ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
    echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
    echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
    		echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
         echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
        echo '<li>'.get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo '<li style="margin-left:3px;"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</ul>';
 
  }
} // end dimox_breadcrumbs()




class FadeIn_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(false, $name = 'FadeIn Content', array( 'description' => 'Contains the Popular, Recent, Comments, Tags tabs.' ) );
	}

	function widget( $args, $instance ) { ?>
			<div id="specialwidget">
		    <ul class="nav nav-pills">
		    	<li class="specialwidgetpopular">
		    		<a href="#">Popular</a>
		    	</li>
		    	    
		    	<li class="specialwidgetrecent">
		    		<a href="#">Recent</a>
		    	</li>
		    	<li class="specialwidgetcomments">
		    		<a href="#">Comments</a>
		    	</li>
		    	<li class="specialwidgettags">
		    		<a href="#">Tags</a>
		    	</li>
		    </ul>
		    <div class="well popular">
		    	    	<ul id="popular-posts">
 
		    	    	<?php
						$popular_posts = new WP_Query('orderby=comment_count&posts_per_page=4'); ?>
 
						<?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
						<li>
				 
						<?php
						if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						?>
						<a class="thumb-href" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('sidebar-thumb', array('alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?></a>
						<a class="popular-post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						<?php } else {?> 
								<a class="thumb-href" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/aside_default_thumb.png" alt="<?php the_title(); ?>"/></a>
								<a class="popular-post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
 
						<?php } ?>
 
						<p class="popular-footer">
							<span class="entry-date"><?php echo get_the_date('F j Y'); ?>,</span>
							<span class="footer-comments"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php comments_number( '0 comments', '1 comment', '% comments' ); ?></a></span>
						</p>
						
						</li>
 
						<?php endwhile; ?>
						</ul>
   			</div>
   			<div class="well recent">
   						<ul id="popular-posts">
   						<?php
						$recent_posts = new WP_Query('orderby=date_count&posts_per_page=4'); ?>
 
						<?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
		    	    	<li>
				 
						<?php
						if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						?>
						<a class="thumb-href" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('sidebar-thumb', array('alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?></a>
						<a class="popular-post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						<?php } else {?> 
								<a class="thumb-href" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/aside_default_thumb.png" alt="<?php the_title(); ?>"/></a>
								<a class="popular-post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
 
						<?php } ?>
 
						<p class="popular-footer">
							<span class="entry-date"><?php echo get_the_date('F j Y'); ?>,</span>
							<span class="footer-comments"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php comments_number( '0 comments', '1 comment', '% comments' ); ?></a></span>
						</p>
						
						</li>
						<?php endwhile; ?>
						</ul>
   			</div>
   			<div class="well comments">
		    	    	<?php 
						$comments = get_comments('post_id=15');
						foreach($comments as $comment) :
							echo($comment->comment_author);
						endforeach;
						?>
   			</div>
   			<div class="well tags">
		    	    	<?php $tags = get_tags();
$html = '<div class="post_tags">';
wp_tag_cloud('smallest=8&largest=15&number=50&separator=, &orderby=count&order=DESC');
$html .= '</div>';
echo $html; ?>
   			</div>
   			</div>
	<?php }

}
// Register the new widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "FadeIn_Widget" );' ) );



// Start class recent_tweets_widget //

	class recent_tweets_widget extends WP_Widget {

// Constructor //

	function recent_tweets_widget() {
		$widget_ops = array( 'classname' => 'recent_tweets_widget', 'description' => 'Displays your recent tweets using the Twitter profile tool' ); // Widget Settings
		$control_ops = array( 'id_base' => 'recent_tweets_widget' ); // Widget Control Settings
		$this->WP_Widget( 'recent_tweets_widget', 'Recent Tweets', $widget_ops, $control_ops ); // Create the widget
	}

// Extract Args //

		function widget($args, $instance) {
			extract( $args );
			$title 		= 'Latest Tweets'; // the widget title
			$tweetnumber 	= $instance['tweet_number']; // the number of tweets to show
			$twitterusername 	= $instance['twitter_username']; // the type of posts to show
			$shellbg	= 'transparent'; // Shell background color
			$shellcolor 	= '#000'; // Shell text color
			$tweetsbg 	= 'transparent'; // Tweets background color
			$tweetscolor 	= '#9d9d9d'; // Tweets text color
			$tweetslinks 	= '#df0001'; // Tweets links color
			$hashtags   = isset($instance['hashtags']) ? $instance['hashtags'] : false ; // whether or not to show hashtags
			$timestamp   = isset($instance['timestamp']) ? $instance['timestamp'] : false ; // whether or not to show timestamp
			$avatars   = isset($instance['avatars']) ? $instance['avatars'] : false ; // whether or not to show avatars

// Before widget //

		echo $before_widget;

// Title of widget //

		if ( $title ) { echo $before_title . $title . $after_title; }

// Widget output //

		?>
		<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
				version: 2,
				type: 'profile',
				rpp: <?php echo $tweetnumber; ?>,
				interval: 6000,
				width: 250,
				height: 300,
				theme: {
					shell: {
						background: '<?php echo $shellbg; ?>',
						color: '<?php echo $shellcolor; ?>'
					},
					tweets: {
						background: '<?php echo $tweetsbg; ?>',
						color: '<?php echo $tweetscolor; ?>',
						links: '<?php echo $tweetslinks; ?>'
					}
				},
				features: {
					scrollbar: false,
					loop: false,
					live: true,
					<?php if ($hashtags) {
						echo 'hashtags: true,';
					}
					else {
						echo 'hashtags: false,';
					}
					if ($timestamp) {
						echo 'timestamp: true,';
					}
					else {
						echo 'timestamp: false,';
					}
					if ($avatars) {
						echo 'avatars: true,';
					}
					else {
						echo 'avatars: false,';
					} ?>
					behavior: 'all'
  				}
			}).render().setUser('<?php echo $twitterusername; ?>').start();
			</script>
			<?php

// After widget //

		echo $after_widget;
		}

// Update Settings //

 		function update($new_instance, $old_instance) {
 			$instance['tweet_number'] = ($new_instance['tweet_number']);
 			$instance['twitter_username'] = ($new_instance['twitter_username']);
 			$instance['hashtags'] = ($new_instance['hashtags']);
 			$instance['timestamp'] = ($new_instance['timestamp']);
 			$instance['avatars'] = ($new_instance['avatars']);
 			return $instance;
 		}

// Widget Control Panel //

 		function form($instance) {

 		$defaults = array( 'title' => 'Recent Tweets', 'tweet_number' => 3, 'twitter_username' => '', 'shell_bg' => '#AAE3FF', 'shell_color' => '#333', 'tweets_bg' => '#EFFFFF', 'tweets_color' => '#333', 'tweets_links' => '#716B68', 'hashtags' => 'on', 'timestamp' => 'on', 'avatars' => false );
 		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

 		<p>
 			<label for="<?php echo $this->get_field_id('tweet_number'); ?>"><?php _e('Number of tweets to display'); ?></label>
 			<input class="widefat" id="<?php echo $this->get_field_id('tweet_number'); ?>" name="<?php echo $this->get_field_name('tweet_number'); ?>" type="text" value="<?php echo $instance['tweet_number']; ?>" />
 		</p>
 		<p>
 			<label for="<?php echo $this->get_field_id('twitter_username'); ?>"><?php _e('Twitter username'); ?></label>
 			<input class="widefat" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" type="text" value="<?php echo $instance['twitter_username']; ?>" />
 		</p>
 				<p>
			<label for="<?php echo $this->get_field_id('hashtags'); ?>"><?php _e('Show hashtags?'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked( $instance['hashtags'], 'on' ); ?> id="<?php echo $this->get_field_id('hashtags'); ?>" name="<?php echo $this->get_field_name('hashtags'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('timestamp'); ?>"><?php _e('Show timestamp?'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked( $instance['timestamp'], 'on' ); ?> id="<?php echo $this->get_field_id('timestamp'); ?>" name="<?php echo $this->get_field_name('timestamp'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('avatars'); ?>"><?php _e('Show avatars?'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked( $instance['avatars'], 'on' ); ?> id="<?php echo $this->get_field_id('avatar'); ?>" name="<?php echo $this->get_field_name('avatars'); ?>" />
		</p>
        <?php }

}

// End class recent_tweets_widget

add_action('widgets_init', create_function('', 'return register_widget("recent_tweets_widget");'));



/*******************************************************************
* @Author: Boutros AbiChedid
* @Date:   March 20, 2011
* @Websites: http://bacsoftwareconsulting.com/
* http://blueoliveonline.com/
* @Description: Numbered Page Navigation (Pagination) Code.
* @Tested: Up to WordPress version 3.1.2 (also works on WP 3.3.1)
********************************************************************/
 
/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}
 
/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['prev_text'] = '&laquo; Previous';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 4; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
 
    //If NOT a single Post is being displayed
    /*http://codex.wordpress.org/Function_Reference/is_single)*/
    if (!is_single()) {
        $request = $wp_query->request;
        //intval — Get the integer value of a variable
        /*http://php.net/manual/en/function.intval.php*/
        $posts_per_page = intval(get_query_var('posts_per_page'));
        //Retrieve variable in the WP_Query class.
        /*http://codex.wordpress.org/Function_Reference/get_query_var*/
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
 
        //empty — Determine whether a variable is empty
        /*http://php.net/manual/en/function.empty.php*/
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
 
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        //ceil — Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
 
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
 
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            /*http://php.net/manual/en/function.str-replace.php */
            /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
           echo $before.'<div class="pagination"><ul>'."\n";

            //Displays a link to the previous post which exists in chronological order from the current post.
            /*http://codex.wordpress.org/Function_Reference/previous_post_link*/
            previous_posts_link($pagenavi_options['prev_text']);
 
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                /*http://codex.wordpress.org/Data_Validation*/
                //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                echo '<li><a href="'.esc_url(get_pagenum_link()).'" title="'.$first_page_text.'">1</a></li>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<li class="disabled"><a href="#" title="">'.$pagenavi_options['dotleft_text'].'</a></li>';
                }
            }
 
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<li><a href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
                }
            }
 
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<li class="active"><a href="'.esc_url(get_pagenum_link($i)).'" title="'.$current_page_text.'">'.$current_page_text.'</a></li>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<li><a href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
                }
            }
 
            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<li class="disabled"><a href="#" title="">'.$pagenavi_options['dotright_text'].'</a></li>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<li><a href="'.esc_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">'.$max_page.'</a></li>';
            }
 
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<li><a href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
                }
            }
            echo '</ul></div>'.$after."\n";
        }
    }
}

?>