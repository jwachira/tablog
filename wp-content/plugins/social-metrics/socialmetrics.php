<?php
/*
Plugin Name: Social Metrics
Plugin URI: http://www.riyaz.net/social-metrics/
Description: Track how your blog is doing across the leading social networking websites and services like Twitter, Facebook, Google +1, StumbleUpon, Digg and LinkedIn.
Author: Riyaz
Version: 2.1
Author URI: http://www.riyaz.net
License: GPL2
*/

/*  Copyright 2010  Riyaz Sayyad  (email : riyaz@riyaz.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
function socialmetrics_init() { ?>
<?php }
add_action('init', 'socialmetrics_init');
?>
<?php
function add_socialmetrics_scripts(){ ?>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
	<script type="text/javascript">
		(function() {
		  var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
		  s.type = 'text/javascript';
		  s.async = true;
		  s.src = 'http://widgets.digg.com/buttons.js';
		  s1.parentNode.insertBefore(s, s1);
		})();
	</script>
	<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
<?php
}
?>
<?php
function add_socialmetrics_settings_scripts(){ 
if ((is_admin() && $_GET['page'] == 'socialmetrics_settings') || (is_admin() && $_GET['page'] == 'socialmetrics_dashboard') || (is_admin() && substr($_SERVER['REQUEST_URI'], strlen($_SERVER['REQUEST_URI'])-9, strlen($_SERVER['REQUEST_URI']))== 'index.php')) { ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo plugins_url() . '/social-metrics/lib/jquery.qtip.pack.js'; ?>"></script>
<?php
	}
}
add_action('wp_print_scripts','add_socialmetrics_settings_scripts');
?>
<?php
function add_socialmetrics_styles(){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url() . '/social-metrics/style.css'; ?>" />
<?php
}
?>
<?php
// create custom plugin settings menu
add_action('admin_menu', 'socialmetrics_create_menu');
function socialmetrics_create_menu() {
	//create new top-level menu
	add_menu_page( 'Social Metrics', 'Social Metrics', 'administrator', 'socialmetrics_dashboard', 'socialmetrics_dashboard_page', plugins_url() . '/social-metrics/images/sm-logo-20.png',3 );
	//add_submenu_page( 'index.php', 'Social Metrics', 'Social Metrics', 'administrator', 'socialmetrics_dashboard', 'socialmetrics_dashboard_page' );

	add_submenu_page('socialmetrics_dashboard', 'Social Metrics Settings', 'Settings', 'administrator', 'socialmetrics_settings', 'socialmetrics_settings_page' );
	//add_submenu_page('plugins.php', 'Social Metrics Settings', 'Settings', 'administrator', 'socialmetrics_settings', 'socialmetrics_settings_page' );
	//call register settings function
	add_action( 'admin_init', 'register_socialmetrics_settings' );
}

function socialmetrics_adminbar() {
	global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }
	$href = add_query_arg( 'page', 'socialmetrics_dashboard', admin_url() );
    $wp_admin_bar->add_menu( array(
    'id' => 'socialmetrics_dashboard',
    'title' => __( 'Social Metrics', 'socialmetrics_dashboard' ),
    'href' => $href ) );
}
add_action( 'admin_bar_menu', 'socialmetrics_adminbar', 100 );

function register_socialmetrics_settings() {
	//register the settings
	register_setting( 'socialmetrics-settings-group', 'socialmetrics_per_page' );
}

function socialmetrics_dashboard_page() {
add_socialmetrics_styles();
if ( !isset($_GET['p_type']) ) { $post_type = 'post'; }
elseif ( in_array( $_GET['p_type'], get_post_types( array('show_ui' => true ) ) ) ) {
	$post_type = $_GET['p_type']; }
else {
	wp_die( __('Invalid post type') ); }

$_GET['p_type'] = $post_type;

/*$post_type_object = get_post_type_object($post_type);*/
?>
<script>
$(document).ready(function() {
	var shared = {
		position: {
			my: 'bottom center', 
			at: 'top center'
		},
		style: {
			classes: 'ui-tooltip-smblue ui-tooltip-shadow ui-tooltip-rounded'
		}
	};
	
	$( ".smwrap .tablenav *" ).qtip( $.extend({}, shared, {
	content: {
		attr: 'title'
	}
	
	}));
});
</script>
<div class="wrap">
<div class="smwrap">
	<h2 class="sm-branding">Social Metrics Dashboard: <?php bloginfo('name'); ?></h2>
	<div class="tablenav"><div style="float:left;margin:5px 5px 5px 0px;vertical-align: middle;">Metrics That Count | By <a style="text-decoration:none;"href="http://www.riyaz.net" target="_blank">riyaz.net</a></div>
	<div class="tablenav-pages"><a href="http://twitter.com/share?url=http://www.riyaz.net/social-metrics/&text=I am using the Social Metrics plugin to track how's my blog doing across Social Media Networks&via=riyaznet&related=riyaznet" target="_blank">Like what you see? Tweet about it!</a></div>
	</div>
<?php
	$per_page = get_option('socialmetrics_per_page', 15);
	if ( $per_page == 0 ) { $per_page = 15; }

	$paged = $_GET['paged'];
	$s_cat = $_GET['s_cat'];

	if (isset( $_GET['s_mon'] )) {
		$s_mon = $_GET['s_mon'];
		if (strlen($s_mon) == 6) {
		$s_month = substr($s_mon,4,6);
		$s_year = substr($s_mon,0,4);
		}
	}

	$pagenum = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 0;
	if ( empty($pagenum) ){ $pagenum = 1; }
	
    $recentPosts = new WP_Query();

	if ( 'post' != $post_type ) {
		$current_ptype = 'Pages';
		$recentPosts->query('showposts='.$per_page.'&post_status=publish'.'&paged='.$paged.'&post_type=page'.'&year='. $s_year . '&monthnum='.$s_month );
	}else {
		$current_ptype = 'Posts';
		$recentPosts->query('showposts='.$per_page.'&post_status=publish'.'&paged='.$paged.'&cat='.$s_cat.'&year='. $s_year . '&monthnum='.$s_month );
	}
?>
	<div class="tablenav">
<?php
		$num_pages = $recentPosts->max_num_pages;	
?>
<?php
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'prev_text' => __('&laquo;'),
			'next_text' => __('&raquo;'),
			'total' => $num_pages,
			'current' => $pagenum
		));
?>
		<div class="tablenav-pages" style="float: left;">
<?php 
			$s_uri = $_SERVER['REQUEST_URI']; 
			$s_uri = esc_url(remove_query_arg(array('paged','p_type','s_cat','s_mon'), $s_uri ));
?>
			<a href="<?php echo esc_url(add_query_arg('p_type', 'post', $s_uri )) ?>"><span class="page-numbers">Show All Posts</span></a>
			<a href="<?php echo esc_url(add_query_arg('p_type', 'page', $s_uri )) ?>"><span class="page-numbers">Show All Pages</span></a>	
<?php 
			$s_uri = $_SERVER['REQUEST_URI']; 
			$s_uri = remove_query_arg(array('paged','p_type','s_cat'), $s_uri );
			$s_uri = add_query_arg('page', 'socialmetrics_dashboard', $s_uri );

			if ( is_object_in_taxonomy($post_type, 'category') && ( 'post' == $post_type ) ) {
				$dropdown_options = array('show_option_none' => __('Filter by category'), 'hide_empty' => 0, 'hierarchical' => 1,'show_count' => 0, 'orderby' => 'name', 'selected' => $s_cat);
				wp_dropdown_categories($dropdown_options); ?>
				<script type="text/javascript"><!--
				var dropdown = document.getElementById("cat");
				function onCatChange() {
					if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
						location.href = "<?php echo $s_uri ?>&s_cat="+dropdown.options[dropdown.selectedIndex].value;
					}
				}
				dropdown.onchange = onCatChange;
				--></script>
<?php		} ?>
<?php 
			global $wpdb;
			global $wp_locale;

			if ( !is_singular() ) {
				$s_uri = $_SERVER['REQUEST_URI']; 
				$s_uri = remove_query_arg(array('paged','s_mon'), $s_uri );
				$s_uri = add_query_arg('page', 'socialmetrics_dashboard', $s_uri );

				$arc_query = $wpdb->prepare("SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM $wpdb->posts WHERE post_type = %s ORDER BY post_date DESC", $post_type);
				$arc_result = $wpdb->get_results( $arc_query );
				$month_count = count($arc_result);

				if ( $month_count && !( 1 == $month_count && 0 == $arc_result[0]->mmonth ) ) {
					$m = isset($_GET['s_mon']) ? (int)$_GET['s_mon'] : 0;
?>
					<select name='m' id='m'>
						<option<?php selected( $m, 0 ); ?> value='0'><?php _e('Filter by date'); ?></option>
<?php
						foreach ($arc_result as $arc_row) {
							if ( $arc_row->yyear == 0 ) { continue; }
							$arc_row->mmonth = zeroise( $arc_row->mmonth, 2 );

							if ( $arc_row->yyear . $arc_row->mmonth == $m ) {
								$default = ' selected="selected"'; }
							else {
								$default = ''; }

							echo "<option$default value='" . esc_attr("$arc_row->yyear$arc_row->mmonth") . "'>";
							echo $wp_locale->get_month($arc_row->mmonth) . " $arc_row->yyear";
							echo "</option>\n";
						}
?>					</select>
					<script type="text/javascript"><!--
					var dropdown_m = document.getElementById("m");
					function onMonthChange() {
						if ( dropdown_m.options[dropdown_m.selectedIndex].value > 0 ) {
							location.href = "<?php echo $s_uri ?>&s_mon="+dropdown_m.options[dropdown_m.selectedIndex].value;
						}
					}
					dropdown_m.onchange = onMonthChange;
					--></script>
<?php 			} ?>
<?php 		} ?>
			<a title="Switch to Social Metrics Pro" class="sm-export" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a>
			<a title="Change Settings" class="th-sort-t sm-export" href="<?php echo admin_url(); ?>admin.php?page=socialmetrics_settings"><img src="<?php echo plugins_url() . '/social-metrics/images/options.png';?>"></a>
		</div>
		<div class="tablenav-pages">
<?php 		if ( $page_links ) { ?>
<?php
				$count_posts = $recentPosts->found_posts;
				$page_links_text = sprintf( '<span class="displaying-num">' . __( '%s %s&#8211;%s of %s' ) . '</span>%s',
									$current_ptype,
									number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
									number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
									number_format_i18n( $count_posts ),
									$page_links
									);
				echo $page_links_text;
			}
?>
		</div>
	</div>	
	<div class="clear"></div>
	<table class="widefat post fixed smtable" cellspacing="0">
		<thead> 
			<tr>
				<th scope="col" id="title0" class="manage-column column-title" >Title</th>
				<th scope="col" id="title1" class="manage-column column-title" >Twitter</th>
				<th scope="col" id="title2" class="manage-column column-title" >Facebook</th>
				<th scope="col" id="title3" class="manage-column column-title" >Google +1</th>
				<th scope="col" id="title5" class="manage-column column-title" >StumbleUpon</th>
				<th scope="col" id="title6" class="manage-column column-title" >Digg</th>
				<th scope="col" id="title7" class="manage-column column-title" >LinkedIn</th>
			</tr>
		</thead>
		<tbody>
<?php 		while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
			<tr>
				<td ><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></td>
				<td ><a href="http://twitter.com/share" class="twitter-share-button" data-text="<?php the_title(); ?>" data-count="horizontal" data-url="<?php the_permalink() ?>">Tweet</a></td>
				<td ><iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&send=false&layout=button_count&width=100&show_faces=false&action=like&colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></td>
				<td ><g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone></td>
				<td ><script src="http://www.stumbleupon.com/hostedbadge.php?s=1&r=<?php the_permalink(); ?>"></script></td>
				<td ><a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"></a></td>
				<td ><script type="in/share" data-url="<?php the_permalink(); ?>" data-counter="right"></script></td>
			</tr>
<?php		endwhile; ?>
		</tbody>
		<tfoot>
			<tr> 
				<th scope="col"  class="manage-column column-title" >Title</th>
				<th scope="col"  class="manage-column column-title" >Twitter</th>
				<th scope="col"  class="manage-column column-title" >Facebook</th>
				<th scope="col"  class="manage-column column-title" >Google +1</th>
				<th scope="col"  class="manage-column column-title" >StumbleUpon</th>
				<th scope="col"  class="manage-column column-title" >Digg</th>
				<th scope="col"  class="manage-column column-title" >LinkedIn</th>
			</tr>
		</tfoot>

	</table>
	<div class="tablenav">
		<div class="tablenav-pages" style="float:left">
			<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Friyaznet&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:30px;" allowTransparency="true"></iframe>
			<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=riyaznet&show_count=true" style="width:300px; height:30px;"></iframe>
		</div>
		<div class="tablenav-pages">
<?php 		if ( $page_links ) { 
				$count_posts = $recentPosts->found_posts;
				$page_links_text = sprintf( '<span class="displaying-num">' . __( '%s %s&#8211;%s of %s' ) . '</span>%s',
									$current_ptype,
									number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
									number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
									number_format_i18n( $count_posts ),
									$page_links
									);
				echo $page_links_text;
			} ?>
		</div>
	</div>
</div>
</div>
<?php
add_socialmetrics_scripts();
}

function socialmetrics_settings_page() {
add_socialmetrics_styles();
?>
<div class="wrap">
<div class="smwrap">
	<h2 class="sm-branding">Social Metrics Settings</h2>
	<?php
	global $wp_query;
	$adm_url = admin_url();
	
	if( $_GET['updated'] ) { ?>
		<div id="message" class="updated">You are all set! Go to your <a href="<?php echo $adm_url . 'admin.php?page=socialmetrics_dashboard' ; ?>">Social Metrics Dashboard</a>.</div>
	<?php } ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'socialmetrics-settings-group' ); ?>
		<div style="min-width:940px;">
			
			<div style="float:left;min-width:600px;margin:10px 5px 10px 0px; padding:5px;">
			
	<script>
	$(document).ready(function() {
	
		var shared = {
			position: {
				my: 'top left', 
				at: 'bottom right'
			},
			show: {
				event: 'mouseenter',
				solo: true
			},
			hide: 'unfocus',
			style: {
				classes: 'ui-tooltip-smblue ui-tooltip-shadow ui-tooltip-rounded'
			}
		};
		
		$( "#check-services" ).buttonset();
		$( "#radio-cf" ).buttonset();
		$( "#radio-exp" ).buttonset();
		$( "#check-exp" ).buttonset();
		$( "#radio-sort" ).buttonset();
		$( "#radio-search" ).buttonset();
		$( "#radio-dashboard" ).buttonset();
		$( "input:submit, a, button", ".sm-button-element" ).button();
		 
		$( ".drlft" ).qtip( $.extend({}, shared, {
		content: '<a class="sm-export" title="Get Social Metrics Pro Now!" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img style="float:left;margin:0px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a><strong><span style="vertical-align:middle;line-height: 20px;">Available with <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Social Metrics Pro</a></strong></span><br><br><strong>Download/Export as File:</strong><br><br>This feature allows you to download/export the displayed Social Metrics report to your desktop.<br><br><strong>Enabled: </strong>Activates the functionality.<br><br><strong>Disabled: </strong>Deactivates the functionality.<br><br>Further you can choose the file formats you wish to allow exporting to:<br><br><strong>Excel: </strong><img style="float:left;margin:5px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/xls.png';?>">Enables exporting to an Excel spreadsheet in a tab-delimited format.<br><br><strong>CSV: </strong><img style="float:left;margin:5px 5px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/csv.png';?>">Enables exporting to a comma-separated (.csv) file.'
		}));
		
		$( ".cft" ).qtip( $.extend({}, shared, {
		content: '<a class="sm-export" title="Get Social Metrics Pro Now!" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img style="float:left;margin:0px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a><strong><span style="vertical-align:middle;line-height: 20px;">Available with <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Social Metrics Pro</a></strong></span><br><br><strong>Conditional Formatting:</strong><br><br><img style="float:left;margin:5px 5px 0px 0px;" src="<?php echo plugins_url(); ?>/social-metrics/images/color-scale.png">Formats the Social Metrics report with a Red-Yellow-Green Color Scale, thus helping you <em>visually identify the popular posts</em>. The background color shade represents the value in the cell.<br><br><strong>Compare by Columns:</strong> The background color shade is arrived at by comparing the values displayed in the particular column.<br><br><strong>Compare Entire Table</strong>: The background color shade is arrived at by comparing the values displayed in the entire table.<br><br><strong>Disable</strong>: Disables the conditional formatting altogether.'
		}));
        
		$( ".sft" ).qtip( $.extend({}, shared, {
		content: '<a class="sm-export" title="Get Social Metrics Pro Now!" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img style="float:left;margin:0px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a><strong><span style="vertical-align:middle;line-height: 20px;">Available with <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Social Metrics Pro</a></strong></span><br><br><strong>Sort Functionality:</strong><br><br>Allows you to sort the values displayed in columns descending or ascending.<br><br><strong>Enabled: </strong>Allows sorting.<br><br><strong>Disabled: </strong>Disallows sorting.'
		}));
		
		$( ".sbt" ).qtip( $.extend({}, shared, {
		content: '<a class="sm-export" title="Get Social Metrics Pro Now!" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img style="float:left;margin:0px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a><strong><span style="vertical-align:middle;line-height: 20px;">Available with <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Social Metrics Pro</a></strong></span><br><br><strong>Search Box:</strong><br><br>Allows you to search posts by entering keywords.<br><br><strong>Show: </strong>Displays the Search Box.<br><br><strong>Hide: </strong>Hides the Search Box.'
		}));	
		
		$( ".nopt" ).qtip( $.extend({}, shared, {
		content: '<strong>Number of Posts to Display at a time:</strong><br><br> Here you can set the maximum number of posts to be displayed at a time. If no value is specified, default value 15 will be used.<br/><br/>Keep this number less than 100 as high values may cause the Social Metrics Dashboard page to load at a slower pace. The <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Pro</a> version does not have this restriction.'
		}));
		
		$( ".doabt" ).qtip( $.extend({}, shared, {
		content: '<a class="sm-export" title="Get Social Metrics Pro Now!" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img style="float:left;margin:0px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a><strong><span style="vertical-align:middle;line-height: 20px;">Available with <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Social Metrics Pro</a></strong></span><br><br><strong>Display on Admin Dashboard:</strong><br><br>Displays Social Metrics for your latest 5 posts on the WordPress Admin Dashboard.<br><br><strong>Show: </strong>Displays the Social Metrics on the WordPress Admin Dashboard.<br><br><strong>Hide: </strong>Disables the functionality.'
		}));
		
		$( ".cserv" ).qtip( $.extend({}, shared, {
		content: '<a class="sm-export" title="Get Social Metrics Pro Now!" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img style="float:left;margin:0px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"></a><strong><span style="vertical-align:middle;line-height: 20px;">Available with <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Social Metrics Pro</a></strong></span><br><br><strong>Choose Services to Track:</strong> All services are selected by default. Choosing Services is possible with Social Metrics Pro.'
		}));
		
	});
	</script>
				<p class="sm-button-element">
				<button><?php _e('Save Changes') ?></button>
				</p>
				<h3>Choose Display Options</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230px;">Number of Posts to Display at a time<span class="nopt sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>
							<td><input type="text" name="socialmetrics_per_page" value="<?php echo get_option('socialmetrics_per_page', 15); ?>" style="width: 50px;" /></td>							
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Display on Admin Dashboard<span class="doabt sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>						
							<td><div id="radio-dashboard">
							<input type="radio" id="sm-dashboard-enabled" name="socialmetrics_show_on_dashboard" value="enabled" disabled /><label for="sm-dashboard-enabled">Show</label>
							<input type="radio" id="sm-dashboard-disabled" name="socialmetrics_show_on_dashboard" value="disabled" checked /><label for="sm-dashboard-disabled">Hide</label></td>
							</div>							
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Choose Services<span class="cserv sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>
						</tr>						
						<tr valign="middle">
							<td colspan="2">
							<div id="check-services">
							<input type="checkbox" name="socialmetrics_show_twitter" id="socialmetrics_show_twitter" value="true" checked="checked" disabled /><label for="socialmetrics_show_twitter">Twitter</label>
							<input type="checkbox" name="socialmetrics_show_facebook" id="socialmetrics_show_facebook" value="true" checked="checked" disabled /><label for="socialmetrics_show_facebook">Facebook</label>
							<input type="checkbox" name="socialmetrics_show_plusone" id="socialmetrics_show_plusone" value="true" checked="checked" disabled /><label for="socialmetrics_show_plusone">Google +1</label>
							<input type="checkbox" name="socialmetrics_show_su" id="socialmetrics_show_su" value="true" checked="checked" disabled /><label for="socialmetrics_show_su">StumbleUpon</label>
							<input type="checkbox" name="socialmetrics_show_digg" id="socialmetrics_show_digg" value="true" checked="checked" disabled /><label for="socialmetrics_show_digg">Digg</label>
							<input type="checkbox" name="socialmetrics_show_linkedin" id="socialmetrics_show_linkedin" value="true" checked="checked" disabled /><label for="socialmetrics_show_linkedin">LinkedIn</label>
							</div>
							</td>
						</tr>
					</table>
				<h3>Choose Features</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230 px;">Download Report to a Local File<span class="drlft sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>
							<td>
								<div id="radio-exp" style="float:left;">
									<input type="radio" name="socialmetrics_export" id="sm-exp-enabled" value="enabled" disabled /><label for="sm-exp-enabled">Enabled</label>
									<input type="radio" name="socialmetrics_export" id="sm-exp-disabled" value="disabled" checked /><label for="sm-exp-disabled">Disabled</label>
								</div>
								<div id="check-exp" style="float:left;margin-left:10px;">
									<input type="checkbox" name="socialmetrics_xls" id="socialmetrics_xls" value="true" /><label for="socialmetrics_xls">Excel</label>
									<input type="checkbox" name="socialmetrics_csv" id="socialmetrics_csv" value="true" /><label for="socialmetrics_csv">CSV</label>
								</div>
							</td>
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Conditional Formatting<span class="cft sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>
							<td><div id="radio-cf">
								<input type="radio" name="socialmetrics_conditional_formatting" id="sm-cf-bycolumns" value="bycolumns" disabled /><label for="sm-cf-bycolumns">Compare by Columns</label>
								<input type="radio" name="socialmetrics_conditional_formatting" id="sm-cf-bytable" value="bytable" disabled /><label for="sm-cf-bytable">Compare Entire Table</label>
								<input type="radio" name="socialmetrics_conditional_formatting" id="sm-cf-disabled" value="disabled" checked /><label for="sm-cf-disabled">Disable</label>
								</div>
							</td>
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Sort Functionality<span class="sft sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>
							<td><div id="radio-sort">
							<input type="radio" id="sm-sort-enabled" name="socialmetrics_sort" value="enabled" disabled /><label for="sm-sort-enabled">Enabled</label>
							<input type="radio" id="sm-sort-disabled" name="socialmetrics_sort" value="disabled" checked /><label for="sm-sort-disabled">Disabled</label>
							</div>
							</td>
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Search Box<span class="sbt sm-help"><img src="<?php echo plugins_url();?>/social-metrics/images/help.png"></span></td>
							<td><div id="radio-search">
							<input type="radio" id="sm-search-enabled" name="socialmetrics_searchbox" value="enabled" disabled /><label for="sm-search-enabled">Show</label>
							<input type="radio" id="sm-search-disabled" name="socialmetrics_searchbox" value="disabled" checked /><label for="sm-search-disabled">Hide</label></td>
							</div>
						</tr>
					</table>					
				<p class="sm-button-element">
					<button><?php _e('Save Changes') ?></button>
				</p>
			</div>

			<div style="border: 1px solid #c9dbec;border-radius: 5px 5px 5px 5px;
-moz-border-radius: 5px 5px 5px 5px;
-webkit-border-top-left-radius: 5px;
-webkit-border-bottom-left-radius: 5px;
-webkit-border-top-right-radius: 5px;
-webkit-border-bottom-right-radius: 5px;
border-top-left-radius: 5px 5px;
border-bottom-left-radius: 5px 5px;
border-top-right-radius: 5px 5px;
border-bottom-right-radius: 5px 5px;
background: #e3edf4;color: #1e598e;float:right; margin:10px 0px 10px 5px; padding:5px;max-width:320px; ?>">
			<div style="margin-left:10px;">
				<h3>Who Created the	Social Metrics?</h3>
					<div>The <a href="http://www.riyaz.net/social-metrics/" target="_blank" style="text-decoration:none;font-weight:bold;">Social Metrics</a> plugin for WordPress is created by <a href="http://www.riyaz.net/about/" target="_blank" style="text-decoration:none;">Riyaz</a>. Riyaz blogs at <a href="http://www.riyaz.net" target="_blank" style="text-decoration:none;font-weight:bold;">riyaz.net</a>.<br></br></div>
					<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=riyaznet&show_count=true" style="width:300px; height:20px;"></iframe><br></br>
					<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Friyaznet&amp;send=false&amp;layout=standard&amp;width=600&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=120" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:120px;" allowTransparency="true"></iframe>
					<br><script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
					<g:plusone size="medium" href="http://www.riyaz.net/"></g:plusone>
				<h3>Need Help?</h3>
					For Help, Support, Bugs, Feedback, Suggestions, Feature requests, please visit <a href="http://www.riyaz.net/social-metrics/" style="text-decoration:none;" target="_blank">Social Metrics Homepage</a> or reach me through <a href="http://www.riyaz.net/contact/" target="_blank" style="text-decoration:none;">contact options</a>.
				<h3>Our Social Media Plugins You May Like</h3>
					<ul><li><a href="http://www.riyaz.net/getsocial/" target="_blank" style="text-decoration:none;font-weight:bold;">GetSocial</a> - Make your blog more social. Add a lightweight and intelligent <em><u>floating social media sharing box</u></em> on your blog posts.</li>
					<li><a href="http://www.riyaz.net/wp-tweetbox/" target="_blank" style="text-decoration:none;font-weight:bold;">WP Tweetbox</a> - Add Twitter Power to your blog. Add a highly customizable Tweetbox to your blog posts and pages. <em><u>Brand your tweets</u></em> with your own website URL.</li>
					</ul>
			</div>	
		</div>
		</div>
	</form>
</div>
</div>
<?php } ?>