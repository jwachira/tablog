<?php
/**
 * Bootstrap file for getting the ABSPATH constant to wp-load.php
 * This is requried when a plugin requires access not via the admin screen.
 *
 * If the wp-load.php file is not found, then an error will be displayed
 *
 * @package themify
 * @since 1.1.1.0
 * @author Elio Rivero
 */

if ( !defined('WP_LOAD_PATH') ) {

	$fullpath = explode( 'wp-content', __FILE__ );
	
	$wploadpath = $fullpath[0];
	
	//$wploadpath = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/' ;
	if (file_exists( $wploadpath . 'wp-load.php') )
		define( 'WP_LOAD_PATH', $wploadpath);
}

// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');

global $wpdb;

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
	wp_die(__('You are not allowed to be here', 'themify'));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $_GET['title'] . ' ' . __('Shortcode Options', 'themify'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<link href="<?php echo admin_url( '/css/colors-fresh.css'); ?>"  rel="stylesheet" />
		<script src="<?php	echo includes_url( '/js/jquery/jquery.js'); ?>"	language="javascript" type="text/javascript" ></script>
		<script src="<?php	echo includes_url( '/js/tinymce/tiny_mce_popup.js');   ?>"	language="javascript" type="text/javascript" ></script>
		<script src="<?php	echo includes_url( '/js/tinymce/utils/form_utils.js'); ?>"	language="javascript" type="text/javascript" ></script>
		<script language="javascript" type="text/javascript">
		function init() {
			tinyMCEPopup.resizeToInnerSize();
		}
		jQuery(document).ready(function(){
			jQuery("#videosrc").val("video url");
		});
		</script>
		<base target="_self" />
	</head>
	<body id="wp-link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('videosrc').focus();" style="display: none">
		
		<?php
		switch( $_GET['shortcode'] ){
			case 'video':
		?>
		
		<script language="javascript" type="text/javascript">
		function themify_insert_shortcode() {
			var sc_content;
			var videosrc = document.getElementById('videosrc').value;
			var videowidth = document.getElementById('videowidth').value;
			var videoheight = document.getElementById('videoheight').value;
			
			if( videosrc != '' || videowidth != '' || videoheight != '' ){
				sc_content = '<p>[video ';
				if (videosrc != '')		sc_content += "src=\"" + videosrc + "\" ";
				if (videowidth != '')	sc_content += "width=\"" + videowidth + "\" ";
				if (videoheight != '')	sc_content += "height=\"" + videoheight + "\"";
				sc_content += ']</p>';
			}
			else tinyMCEPopup.close();
	
			if(window.tinyMCE) {
				window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, sc_content);
				tinyMCEPopup.editor.execCommand('mceRepaint');
				tinyMCEPopup.close();
			}
			return;
		}
		</script>
		
	
		<form name="video-options" action="#">
	
			<div class="panel current" style="margin-bottom: 20px;">
		    	<p>
		    		<label for="videosrc"><?php _e("Enter video URL:", 'themify'); ?><br/>
						<input type="text" style="padding: 5px; width:200px;" id="videosrc" name="videosrc" value="" />
					</label></p>
		    	<p>
		    		<label for="videowidth"><?php _e("Video width:", 'themify'); ?><br/>
						<input type="text" style="padding: 5px; width:200px;" id="videowidth" name="videowidth" value="" />
					</label>
					<small>Append the unit, px or %.</small>
				</p>
		    	<p>
		    		<label for="videoheight"><?php _e("Video height:", 'themify'); ?><br/>
						<input type="text" style="padding: 5px; width:200px;" id="videoheight" name="videoheight" value="" />
					</label>
					<small>Append the unit, px or %.</small>
				</p>
		    </div>
	        
			<div class="mceActionPanel submitbox" style="border-top: 1px solid #CCC;padding-top: 5px;">
				<div id="delete-action" style="float: left;">
					<a class="submitdelete deletion" onclick="tinyMCEPopup.close();" style="text-decoration: underline;cursor:pointer;padding: 0 2px;">Cancel</a>
				</div>
		
				<div id="wp-link-update" style="float: right;">
					<input class="button-primary" type="submit" id="wp-link-submit" name="insert" value="<?php _e('Insert', 'ilc'); ?>" onclick="themify_insert_shortcode();" style="padding: 4px 8px;border-radius: 10px;cursor:pointer;" />
				</div>
			</div>
		</form>
			
		<?php
			break;
		}
		?>
	</body>
</html>	
<?php
//finish box
?>