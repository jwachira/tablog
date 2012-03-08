<?php
/**
 * @package Ultimate TinyMCE
 * @version 1.6.9
 */
/*
Plugin Name: Ultimate TinyMCE
Plugin URI: http://www.joshlobe.com/2011/10/ultimate-tinymce/
Description: Beef up your visual tinymce editor with a plethora of advanced options.
Author: Josh Lobe
Version: 1.6.9
Author URI: http://joshlobe.com

*/

/*  Copyright 2011  Josh Lobe  (email : joshlobe@joshlobe.com)

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

// Change our default Tinymce configuration values
function jwl_change_mce_options($initArray) {

	//$initArray['verify_html'] = false;
	//$initArray['cleanup_on_startup'] = false;
	//$initArray['cleanup'] = false;
		// Removes the "Double Line Breaking" in the visual editor.  All line breaks will be a single line space.
	//$initArray['forced_root_block'] = false;
	$initArray['popup_css'] = plugin_dir_url( __FILE__ ) . 'css/popup.css';
	$initArray['theme_advanced_font_sizes'] = '6px=6px,8px=8px,10px=10px,12px=12px,14px=14px,16px=16px,18px=18px,20px=20px,22px=22px,24px=24px,28px=28px,32px=32px,36px=36px,40px=40px,44px=44px,48px=48px,52px=52px,62px=62px,72px=72px';
	//$initArray['valid_elements'] = '*[*]';
	//$initArray['extended_valid_elements'] = '*[*]';
	//$initArray['validate_children'] = false;
	//$initArray['force_p_newlines'] = false;
	//$initArray['force_br_newlines'] = false;
	//$initArray['fix_table_elements'] = false;
	//$initArray['entities'] = '160,nbsp,38,amp,60,lt,62,gt';
	//$initArray['paste_strip_class_attributes'] = 'none';
		// Don't remove line breaks ??
	//$initArray['remove_linebreaks'] = false; 
		// Convert newline characters to BR tags ??
	//$initArray['convert_newlines_to_brs'] = true; 
		// Preserve tab/space whitespace ??
	//$initArray['preformatted'] = true;
	//$initArray['remove_redundant_brs'] = false;
	$initArray['plugin_insertdate_dateFormat'] = '%B %d, %Y';  // added for inserttimedate proper format
	$initArray['plugin_insertdate_timeFormat'] = '%I:%M:%S %p';  // added for inserttimedate proper format

	return $initArray;
}

add_filter('tiny_mce_before_init', 'jwl_change_mce_options');

// Set our language localization folder (used for adding translations)
function jwl_ultimate_tinymce() {
 load_plugin_textdomain('jwl-ultimate-tinymce', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'jwl_ultimate_tinymce' );

// set field names for using custom fields in edit posts/pages admin panel.
function jwl_field_func($atts) {
   global $post;
   $name = $atts['name'];
   		if (empty($name)) return;
   return get_post_meta($post->ID, $name, true);
}
add_shortcode('field', 'jwl_field_func');

//  Add settings link to plugins page menu
//  This can be duplicated to add multiple links
function add_ultimatetinymce_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
 
		if ($file == $this_plugin){
		$settings_link = '<a href="admin.php?page=ultimate-tinymce">'.__("Settings",'jwl-ultimate-tinymce').'</a>';
		$settings_link2 = '<a href="http://forum.joshlobe.com/member.php?action=register&referrer=1">'.__("Support Forum",'jwl-ultimate-tinymce').'</a>';
		//$settings_link2 = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=A9E5VNRBMVBCS" target="_blank">'.__("Donate",'jwl-ultimate-timymce').'</a>';
		array_unshift($links, $settings_link, $settings_link2);
		}
	return $links;
}
add_filter('plugin_action_links', 'add_ultimatetinymce_settings_link', 10, 2 );

// Donate link on manage plugin page
function jwl_execphp_donate_link($links, $file) { if ($file == plugin_basename(__FILE__)) { $donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=A9E5VNRBMVBCS" target="_blank">Donate</a>'; $links[] = $donate_link; } return $links; } add_filter('plugin_row_meta', 'jwl_execphp_donate_link', 10, 2);

// Call our external stylesheet used in the admin panel for customizing the "postbox" and "inside" classes.
function jwl_admin_register_head() {
    $url = plugin_dir_url( __FILE__ ) . 'css/admin_panel.css';  // Added for admin panel css styles
	$url2 = plugin_dir_url( __FILE__ ) . 'js/pop-up.js';  // Added for popup help javascript
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";  // Added for admin panel css styles
	echo "<script language='JavaScript' type='text/javascript' src='$url2'></script>\n";  // Added for popup help javascript
}
add_action('admin_head', 'jwl_admin_register_head');

// Add the admin options page.  This creates the basic admin settings page wrap
function jwl_admin_add_page() {
		add_options_page('Ultimate TinyMCE Plugin Page', __('Ultimate TinyMCE','jwl-ultimate-tinymce'), 'manage_options', 'ultimate-tinymce', 'jwl_options_page');	
}
add_action('admin_menu', 'jwl_admin_add_page');

// Display the admin options page
	function jwl_options_page() {
	?>
	<div class="wrap">
		<h2><?php _e('Ultimate TinyMCE Plugin Menu','jwl-ultimate-tinymce'); ?></h2>

            <div class="metabox-holder" style="width:65%; float:left; margin-right:10px;">
            <form action="options.php" method="post">
                <div class="postbox">
                <!-- <div class="inside" style="padding:0px 0px 0px 0px;"> -->
                	
					<?php do_settings_sections('ultimate-tinymce'); ?>
                    <?php settings_fields('jwl_options_group'); ?><br /><br />  
                   
                   <br /><br />     
                <!-- </div> -->
                </div>
                <center><input class="button-primary" type="submit" name="Save" value="<?php _e('Save your Selection','jwl-ultimate-tinymce'); ?>" id="submitbutton" /></center><br /> <br />
                <div class="postbox">
                <!-- <div class="inside" style="padding:0px 0px 0px 0px;"> -->
                	
                    <?php settings_fields('jwl_options_group'); ?>
                    <?php do_settings_sections('ultimate-tinymce2'); ?><br /> <br />
                       
                    <br /><br />
                <!-- </div> -->
                </div>
                <center><input class="button-primary" type="submit" name="Save" value="<?php _e('Save your Selection','jwl-ultimate-tinymce'); ?>" id="submitbutton" /></center><br /> <br />
                <div class="postbox">
                <!-- <div class="inside" style="padding:0px 0px 0px 0px;"> -->
                	
                    <?php settings_fields('jwl_options_group'); ?>
                    <?php do_settings_sections('ultimate-tinymce4'); ?><br /> <br />
                       
                    <br /><br />
                <!-- </div> -->
                </div>
                <center><input class="button-primary" type="submit" name="Save" value="<?php _e('Save your Selection','jwl-ultimate-tinymce'); ?>" id="submitbutton" /></center><br /> <br />
                <div class="postbox">
                <!-- <div class="inside" style="padding:0px 0px 0px 0px;"> -->
                	
                    <?php settings_fields('jwl_options_group'); ?>
                    <?php do_settings_sections('ultimate-tinymce3'); ?><br /> <br />
                       
                    <br /><br />
                <!-- </div> -->
                </div>
                
                <center><input class="button-primary" type="submit" name="Save" value="<?php _e('Save your Selection','jwl-ultimate-tinymce'); ?>" id="submitbutton" /></center>
                </form>
            </div>
              
            
 
    		<div class="metabox-holder" style="width:30%; float:left;">
 
            
            <div class="postbox2donate">
                <h3 style="cursor:default;"><?php _e('Donations','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2donate" style="padding:12px 12px 12px 12px;">
                <p><strong><?php _e('Even the smallest donations are gratefully accepted.','jwl-ultimate-tinymce'); ?></strong></p>
                        
                <!--  Donate Button -->
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="A9E5VNRBMVBCS">
                <center><input type="image" src="http://www.joshlobe.com/images/donate.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></center>
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
                </div>
            </div>
            
            <div class="postbox2resources">
                <h3 style="cursor:default;"><?php _e('Additional Resources','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2resources" style="padding:12px 12px 12px 12px;">
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/support.png" style="margin-bottom: -8px;" />
                <a href="http://forum.joshlobe.com/member.php?action=register&referrer=1" target="_blank"><?php _e('Visit my Support Forum <strong>NEW</strong>.','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/screencast.png" style="margin-bottom: -8px;" />
                <a href="http://www.youtube.com/watch?v=fM3CUo9MxMc" target="_blank"><?php _e('Screencast part one','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/screencast.png" style="margin-bottom: -8px;" />
                <a href="http://www.youtube.com/watch?v=5raIBxGP17g" target="_blank"><?php _e('Screencast part two','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/help.png" style="margin-bottom: -8px;" />
                <a href="http://www.joshlobe.com/2011/10/ultimate-tinymce/" target="_blank"><?php _e('Get help from my personal blog.','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/thread.png" style="margin-bottom: -8px;" />
                <a href="http://wordpress.org/tags/ultimate-tinymce?forum_id=10#postform" target="_blank"><?php _e('Post a thread in the Wordpress Plugin Page.','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/email.png" style="margin-bottom: -8px;" />
                <a href="http://www.joshlobe.com/contact-me/" target="_blank"><?php _e('Email me directly using my contact form.','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/rss.png" style="margin-bottom: -8px;" />
                <a href="http://www.joshlobe.com/feed/" target="_blank"><?php _e('Subscribe to my RSS Feed.','jwl-ultimate-tinymce'); ?></a><br /><br />
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/follow.png" style="margin-bottom: -8px;" />
                <?php _e('Follow me on ','jwl-ultimate-tinymce'); ?><a target="_blank" href="http://www.facebook.com/joshlobe"><?php _e('Facebook','jwl-ultimate-tinymce'); ?></a><?php _e(' and ','jwl-ultimate-tinymce'); ?><a target="_blank" href="http://twitter.com/#!/joshlobe"><?php _e('Twitter','jwl-ultimate-tinymce'); ?></a>.<br />
                               
                </div>
            </div>
            
            
            <div class="postbox2firefox">
                <h3 style="cursor:default;"><?php _e('TinyMCE + Firefox = Best Experience','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2firefox" style="padding:12px 12px 12px 12px;">
                <?php _e('In all honesty, the tinymce editor works best with the Mozilla Firefox browser.  If you are not a Firefox user, you might want to consider giving it a try when creating your content.  You can download the free browser by clicking the image below.','jwl-ultimate-tinymce'); ?>
                <br /><br /><center><a target="_blank" href="http://affiliates.mozilla.org/link/banner/5958"><img src="http://affiliates.mozilla.org/media/uploads/banners/upgrade-tall-blue-EN.png" alt="Upgrade" /></a></center>
                
                </div>
            </div>
            
            
            <div class="postbox2vote">
                <h3 style="cursor:default;"><?php _e('Please VOTE and click WORKS.','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2vote" style="padding:12px 12px 12px 12px;">
                <img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/vote.png" style="margin-bottom: -8px;" />
                <a href="http://wordpress.org/extend/plugins/ultimate-tinymce/" target="_blank"><?php _e('Click Here to Vote...','jwl-ultimate-tinymce'); ?></a><br /><br /><?php _e('Voting helps my plugin get more exposure and higher rankings on the searches.','jwl-ultimate-tinymce'); ?><br /><br /><?php _e('Please help spread this wonderful plugin by showing your support.  Thank you!','jwl-ultimate-tinymce'); ?>
                
                </div>
            </div>
            
            
            <div class="postbox2blog">
                <h3 style="cursor:default;"><?php _e('Bloggers !!','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2blog" style="padding:12px 12px 12px 12px;">
                <?php _e('Like this plugin?  Blog about it on your website, link to my plugin page on my website <a target="_blank" href="http://www.joshlobe.com/2011/10/ultimate-tinymce/">HERE</a>, and I will add your website link (along with a thanks) to all my plugin pages including this page, the wordpress plugin page, and my website page.<br /><br />  The external links will mutually benefit the two of us in regards to search engine rankings.','jwl-ultimate-tinymce'); _e('<br /><br /><strong>Special Thanks to these bloggers:</strong><br /><ul><li><u>Tam</u> - <a href="http://www.buzzing-t.nl/" target="_blank">Buzzing-t.nl</a></li><li><u>Axel</u> - <a href="http://onewhole.eu/" target="_blank">Onewhole.eu</a></li><li><u>Vanessa</u> - <a href="http://www.vanytastisch.ch/" target="_blank">Vanytastisch.ch</a></li><li><u>Nadav</u> - <a href="http://animereviews.co" target="_blank">Animereviews.co</a></li><li><a href="http://blogigs.com/how-to-make-a-attractive-blog-post/" target="_blank">Blogigs</a></li><li><a href="http://www.untetheredincome.com/articles/wordpress/best-wordpress-plugins-2012/" target="_blank">Untethered Income</a></li></ul>', 'jwl-ultimate-tinymce'); ?>
                
                </div>
            </div>
            
            
            <div class="postbox2feedback">
                <h3 style="cursor:default;"><?php _e('Feedback','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2feedback" style="padding:12px 12px 12px 12px;">
                <?php _e('Please take a moment to complete the short feedback form below.  Your input is greatly appreciated.  All input fields are optional.','jwl-ultimate-tinymce'); ?><br /><br />
                <div style="border:1px solid #999999;"><!-- Begin Freedback Form -->
<!-- DO NOT EDIT YOUR FORM HERE, PLEASE LOG IN AND EDIT AT FREEDBACK.COM -->
<form enctype="multipart/form-data" method="post" action="http://www.freedback.com/mail.php" accept-charset="UTF-8">
	<div>
		<input type="hidden" name="acctid" id="acctid" value="8a44jw4rc6tihuqh" />
		<input type="hidden" name="formid" id="formid" value="1035543" />
	</div>
	<table cellspacing="2" cellpadding="2" border="0">
		<tr><td valign="top"><strong>Name: (Optional)</strong></td></tr>
	    <tr><td valign="top"><input type="text" name="name" id="name" size="40" value="" /></td></tr>
		<tr><td valign="top"><strong>Email Address: (Optional)</strong></td></tr>
        <tr><td valign="top"><input type="text" name="email" id="email" size="40" value="" /></td></tr>
		<tr><td valign="top"><strong>Would you recommend this plugin to a friend?</strong></td></tr>
        <tr><td valign="top">
				<select name="field-45f3fdce1a0bc05" id="field-45f3fdce1a0bc05">
					<option value=""></option>
					<option value="Most Definitely">Most Definitely</option>
					<option value="Probably">Probably</option>
					<option value="Maybe">Maybe</option>
					<option value="Probably Not">Probably Not</option>
					<option value="Definitely Not??">Definitely Not</option>
				</select>
		</td></tr>
		<tr><td valign="top"><strong>How would you rate this plugin?</strong></td></tr>
        <tr><td valign="top">
				<select name="field-d8c8cf7b3175e69" id="field-d8c8cf7b3175e69">
					<option value=""></option>
					<option value="5 Stars">5 Stars</option>
					<option value="4 Stars">4 Stars</option>
					<option value="3 Stars">3 Stars</option>
					<option value="2 Stars">2 Stars</option>
					<option value="1 Star">1 Star</option>
					<option value="0 Stars">0 Stars</option>
				</select>
		</td></tr>
		<tr><td valign="top"><strong>Do you find the new &quot;Help&quot; popups useful?</strong></td></tr>
        <tr><td valign="top">
				<select name="field-dbfb7a0c6afa91c" id="field-dbfb7a0c6afa91c">
					<option value=""></option>
					<option value="Absolutely">Absolutely</option>
					<option value="A Little">A Little</option>
					<option value="Not Really">Not Really</option>
				</select>
		</td></tr>
        <tr><td valign="top"><strong>Have you rated this plugin and clicked &quot;Works&quot; on the wordpress plugin download page?</strong></td></tr>
        <tr><td valign="top">
				<select name="field-05f800de9d39cb5" id="field-05f800de9d39cb5">
					<option value=""></option>
					<option value="I Already have.">I Already have.</option>
					<option value="Doing it now.">Doing it now.</option>
					<option value="No Way.">No Way.</option>
					<option value="What&#39;s That?">What&#39;s That?</option>
				</select>
		</td></tr>
		<tr><td valign="top"><strong>Have you looked at any of these?  (Check all that apply)</strong></td></tr>
        <tr><td valign="top">
				<input type="checkbox" name="field-2a733a58a89d340[]" id="field-2a733a58a89d340_0" value="Support Forum" /> Support Forum<br/>
				<input type="checkbox" name="field-2a733a58a89d340[]" id="field-2a733a58a89d340_1" value="Microsoft Word Help Document" /> Microsoft Word Help Document<br/>
                <input type="checkbox" name="field-2a733a58a89d340[]" id="field-2a733a58a89d340_2" value="&quot;Help&quot; Popups" /> &quot;Help&quot; Popups<br/>
		</td></tr>
		<tr><td valign="top"><strong>Please feel free to leave any additional feedback here...</strong></td></tr>
        <tr><td valign="top"><textarea name="field-b0cb8c2a6a616ee" id="field-b0cb8c2a6a616ee" rows="6" cols="40"></textarea></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" value=" Submit Form " /></td></tr>
	</table>
</form>
<br><center><font face="Arial, Helvetica" size="1"><b>Put a <a href="http://www.freedback.com">website form</a> like this on your site.</b></font><br /><br /><strong>Please click the "Continue" text on the next page after submission to return to this page.</strong></center>
<!-- End Freedback Form --></div>
                
                </div>
             </div>   
            
            <div class="postbox2poll">
                <h3 style="cursor:default;"><?php _e('Plugin Poll','jwl-ultimate-tinymce'); ?></h3>
                <div class="inside2poll" style="padding:12px 12px 12px 12px;">
                
                <?php _e('New Plugin Features...','jwl-ultimate-tinymce'); ?><br /><br /><?php _e('There are a few features I have been wanting to implement; but have found they are going to require more work than I originally anticipated.<br /><br />In the meantime, I\'d like to take a poll of which features you consider to be of a higher priority.  Please vote on your favorite requested feature.  You can vote once per day.<br /><br />','jwl-ultimate-tinymce'); ?>
                
                <!-- // Begin Pollhost.com Poll Code // -->
<div style="border:1px solid black;">
<form method=post action=http://poll.pollhost.com/vote.cgi><table border=0 width=297 bgcolor=#EEEEEE cellspacing=0 cellpadding=2><tr><td colspan=2><font face="Verdana" size=-1 color="#000000"><b>Which feature would you like to see?</b></font></td></tr><tr><td width=5><input type=radio name=answer value=1></td><td><font face="Verdana" size=-1 color="#000000">Better Tables Control and Usage</font></td></tr><tr><td width=5><input type=radio name=answer value=2></td><td><font face="Verdana" size=-1 color="#000000">Better Cross-Browser Compatibility</font></td></tr><tr><td width=5><input type=radio name=answer value=3></td><td><font face="Verdana" size=-1 color="#000000">More examples in the Help Popups</font></td></tr><tr><td width=5><input type=radio name=answer value=4></td><td><font face="Verdana" size=-1 color="#000000">A Shortcodes Manager</font></td></tr><tr><td width=5><input type=radio name=answer value=5></td><td><font face="Verdana" size=-1 color="#000000">A Custom Styles Manager</font></td></tr><tr><td colspan=2><input type=hidden name=config value="am9zaDQwMQkxMzI2NjkxMDQ5CUVFRUVFRQkwMDAwMDAJVmVyZGFuYQlBc3NvcnRlZA"><center><input type=submit value=Vote>&nbsp;&nbsp;<input type=submit name=view value=View></center></td></tr><tr><td bgcolor=#FFFFFF colspan=2 align=right><font face="Verdana" size=-2 color="#000000"><a href=http://www.pollhost.com/><font color=#000099>Free polls from Pollhost.com</font></a></font></td></tr></table></form>
</div>
<!-- // End Pollhost.com Poll Code // -->

                
                </div>
            </div>
            
             
    	</div>            
	</div>
	<?php 
	}


// Add ALL our settings
function jwl_settings_api_init() {
 	// This creates each settings option group.  These are used as headers in our admin panel settings page.	
 	add_settings_section('jwl_setting_section', __('Row 3 Button Settings','jwl-ultimate-tinymce'), 'jwl_setting_section_callback_function', 'ultimate-tinymce');
	add_settings_section('jwl_setting_section2', __('Row 4 Button Settings','jwl-ultimate-tinymce'), 'jwl_setting_section_callback_function2', 'ultimate-tinymce2');
	add_settings_section('jwl_setting_section3', __('Miscellaneous Options and Features','jwl-ultimate-tinymce'), 'jwl_setting_section_callback_function3', 'ultimate-tinymce3');
	add_settings_section('jwl_setting_section4', __('Enable Advanced TinyMCE Features','jwl-ultimate-tinymce'), 'jwl_setting_section_callback_function4', 'ultimate-tinymce4');
 	
 	// This adds our individual settings to each option group defined above.	
	// These are the settings for Row 3
 	add_settings_field('jwl_fontselect_field_id', __('Font Select Box','jwl-ultimate-tinymce'), 'jwl_fontselect_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_fontsizeselect_field_id', __('Font Size Box','jwl-ultimate-tinymce'), 'jwl_fontsizeselect_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_cut_field_id', __('Cut Box','jwl-ultimate-tinymce'), 'jwl_cut_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_copy_field_id', __('Copy Box','jwl-ultimate-tinymce'), 'jwl_copy_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_paste_field_id', __('Paste Box','jwl-ultimate-tinymce'), 'jwl_paste_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_backcolorpicker_field_id', __('Background Color Picker Box','jwl-ultimate-tinymce'), 'jwl_backcolorpicker_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_forecolorpicker_field_id', __('Foreground Color Picker Box','jwl-ultimate-tinymce'), 'jwl_forecolorpicker_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_advhr_field_id', __('Horizontal Rule Box','jwl-ultimate-tinymce'), 'jwl_advhr_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_visualaid_field_id', __('Visual Aid Box','jwl-ultimate-tinymce'), 'jwl_visualaid_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_anchor_field_id', __('Anchor Box','jwl-ultimate-tinymce'), 'jwl_anchor_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_sub_field_id', __('Subscript Box','jwl-ultimate-tinymce'), 'jwl_sub_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_sup_field_id', __('Superscript Box','jwl-ultimate-tinymce'), 'jwl_sup_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_search_field_id', __('Search Box','jwl-ultimate-tinymce'), 'jwl_search_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_replace_field_id', __('Replace Box','jwl-ultimate-tinymce'), 'jwl_replace_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	
	add_settings_field('jwl_moods_field_id', __('Josh\'s Ultimate Moods Box','jwl-ultimate-tinymce'), 'jwl_moods_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	add_settings_field('jwl_datetime_field_id', __('Insert Date/Time Box','jwl-ultimate-tinymce'), 'jwl_datetime_callback_function', 'ultimate-tinymce', 'jwl_setting_section');
	
	// These are the settings for Row 4
	// add_settings_field('jwl_tablecontrols_field_id', __('Table Controls Box','jwl-ultimate-tinymce'), 'jwl_tablecontrols_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_styleselect_field_id', __('Style Select Box','jwl-ultimate-tinymce'), 'jwl_styleselect_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_tableDropdown_field_id', __('Table Controls Dropdown Box','jwl-ultimate-tinymce'), 'jwl_tableDropdown_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_emotions_field_id', __('Emotions Box','jwl-ultimate-tinymce'), 'jwl_emotions_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_image_field_id', __('Advanced Image Box','jwl-ultimate-tinymce'), 'jwl_image_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_preview_field_id', __('Preview Box','jwl-ultimate-tinymce'), 'jwl_preview_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_cite_field_id', __('Citations Box','jwl-ultimate-tinymce'), 'jwl_cite_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_abbr_field_id', __('Abbreviations Box','jwl-ultimate-tinymce'), 'jwl_abbr_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_acronym_field_id', __('Acronym Box','jwl-ultimate-tinymce'), 'jwl_acronym_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_del_field_id', __('Delete Box','jwl-ultimate-tinymce'), 'jwl_del_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_ins_field_id', __('Insert Box','jwl-ultimate-tinymce'), 'jwl_ins_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_attribs_field_id', __('Attributes Box','jwl-ultimate-tinymce'), 'jwl_attribs_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_styleprops_field_id', __('Styleprops Box','jwl-ultimate-tinymce'), 'jwl_styleprops_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_code_field_id', __('HTML Code Box','jwl-ultimate-tinymce'), 'jwl_code_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_codemagic_field_id', __('HTML Code Magic Box','jwl-ultimate-tinymce'), 'jwl_codemagic_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2'); 	
	add_settings_field('jwl_media_field_id', __('Insert Media Box','jwl-ultimate-tinymce'), 'jwl_media_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_youtube_field_id', __('Insert YouTube Video Box','jwl-ultimate-tinymce'), 'jwl_youtube_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_imgmap_field_id', __('Image Map Editor Box','jwl-ultimate-tinymce'), 'jwl_imgmap_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_visualchars_field_id', __('Toggle Visual Characters Box','jwl-ultimate-tinymce'), 'jwl_visualchars_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	add_settings_field('jwl_print_field_id', __('Print Box','jwl-ultimate-tinymce'), 'jwl_print_callback_function', 'ultimate-tinymce2', 'jwl_setting_section2');
	
	// Settings for miscellaneous options and features
	add_settings_field('jwl_tinymce_nextpage_field_id', __('Enable NextPage (PageBreak) Feature.','jwl-ultimate-tinymce'), 'jwl_tinymce_nextpage_callback_function', 'ultimate-tinymce3', 'jwl_setting_section3');
	add_settings_field('jwl_tinymce_excerpt_field_id', __('Add tinymce editor to excerpt area.','jwl-ultimate-tinymce'), 'jwl_tinymce_excerpt_callback_function', 'ultimate-tinymce3', 'jwl_setting_section3');
	add_settings_field('jwl_postid_field_id', __('Add ID Column to page/post admin list.','jwl-ultimate-tinymce'), 'jwl_postid_callback_function', 'ultimate-tinymce3', 'jwl_setting_section3');
	add_settings_field('jwl_shortcode_field_id', __('Allow shortcode usage in widget text areas.','jwl-ultimate-tinymce'), 'jwl_shortcode_callback_function', 'ultimate-tinymce3', 'jwl_setting_section3');
	add_settings_field('jwl_php_widget_field_id', __('Use PHP Text Widget','jwl-ultimate-tinymce'), 'jwl_php_widget_callback_function', 'ultimate-tinymce3', 'jwl_setting_section3');
	add_settings_field('jwl_signoff_field_id', __('Add a Signoff Shortcode','jwl-ultimate-tinymce'), 'jwl_signoff_callback_function', 'ultimate-tinymce3', 'jwl_setting_section3');
	
	// Settings for Advanced TinyMCE Features
	add_settings_field('jwl_defaults_field_id', __('Enable Advanced Insert/Edit Link','jwl-ultimate-tinymce'), 'jwl_defaults_callback_function', 'ultimate-tinymce4', 'jwl_setting_section4');
	add_settings_field('jwl_custom_styles_field_id', __('Enable Advanced Custom Styles','jwl-ultimate-tinymce'), 'jwl_custom_styles_callback_function', 'ultimate-tinymce4', 'jwl_setting_section4');
	add_settings_field('jwl_div_field_id', __('Enable "Div Clear" Ability','jwl-ultimate-tinymce'), 'jwl_div_callback_function', 'ultimate-tinymce4', 'jwl_setting_section4');
 	
	// Register our settings so that $_POST handling is done for us and our callback function just has to echo the <input>.
	// Register settings for Row 3
 	register_setting('jwl_options_group','jwl_fontselect_field_id');
	register_setting('jwl_options_group','jwl_fontsizeselect_field_id');
	register_setting('jwl_options_group','jwl_cut_field_id');
	register_setting('jwl_options_group','jwl_copy_field_id');
	register_setting('jwl_options_group','jwl_paste_field_id');
	register_setting('jwl_options_group','jwl_backcolorpicker_field_id');
	register_setting('jwl_options_group','jwl_forecolorpicker_field_id');
	register_setting('jwl_options_group','jwl_advhr_field_id');
	register_setting('jwl_options_group','jwl_visualaid_field_id');
	register_setting('jwl_options_group','jwl_anchor_field_id');
	register_setting('jwl_options_group','jwl_sub_field_id');
	register_setting('jwl_options_group','jwl_sup_field_id');
	register_setting('jwl_options_group','jwl_search_field_id');
	register_setting('jwl_options_group','jwl_replace_field_id');
	register_setting('jwl_options_group','jwl_moods_field_id');
	register_setting('jwl_options_group','jwl_datetime_field_id');
	
	// Register settings for Row 4
	// register_setting('jwl_options_group','jwl_tablecontrols_field_id');
	register_setting('jwl_options_group','jwl_styleselect_field_id');
	register_setting('jwl_options_group','jwl_tableDropdown_field_id');
	register_setting('jwl_options_group','jwl_emotions_field_id');
	register_setting('jwl_options_group','jwl_image_field_id');
	register_setting('jwl_options_group','jwl_preview_field_id');
	register_setting('jwl_options_group','jwl_cite_field_id');
	register_setting('jwl_options_group','jwl_abbr_field_id');
	register_setting('jwl_options_group','jwl_acronym_field_id');
	register_setting('jwl_options_group','jwl_del_field_id');
	register_setting('jwl_options_group','jwl_ins_field_id');
	register_setting('jwl_options_group','jwl_attribs_field_id');
	register_setting('jwl_options_group','jwl_styleprops_field_id');
	register_setting('jwl_options_group','jwl_code_field_id');
	register_setting('jwl_options_group','jwl_codemagic_field_id');
	register_setting('jwl_options_group','jwl_media_field_id');
	register_setting('jwl_options_group','jwl_youtube_field_id');
	register_setting('jwl_options_group','jwl_imgmap_field_id');
	register_setting('jwl_options_group','jwl_visualchars_field_id');
	register_setting('jwl_options_group','jwl_print_field_id');
	
	// Register Settings for miscellaneous options and features
	register_setting('jwl_options_group','jwl_tinymce_nextpage_field_id');
	register_setting('jwl_options_group','jwl_tinymce_excerpt_field_id');
	register_setting('jwl_options_group','jwl_postid_field_id');
	register_setting('jwl_options_group','jwl_shortcode_field_id');
	register_setting('jwl_options_group','jwl_php_widget_field_id');
	register_setting('jwl_options_group','jwl_signoff_field_id');
	
	// Register Settings for Advanced TinyMCE Features
	register_setting('jwl_options_group','jwl_defaults_field_id');
	register_setting('jwl_options_group','jwl_custom_styles_field_id');
	register_setting('jwl_options_group','jwl_div_field_id');
}
add_action('admin_init', 'jwl_settings_api_init');  
 
  
 // These are our callback functions for each settings option GROUP described above.
 
 function jwl_setting_section_callback_function() {
 	_e('<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;Here you can select which buttons to include in row 3 of the TinyMCE editor.</strong></p><br /><br /><p>&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>Description</u></strong><span style="margin-left:140px;"><strong><u>Enable</u></strong></span><span style="margin-left:20px;"><strong><u>Image</u></strong></span><span style="margin-left:35px;"><strong><u>Help</u></strong></span></p>','jwl-ultimate-tinymce');
 }
 function jwl_setting_section_callback_function2() {
 	_e('<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;Here you can select which buttons to include in row 4 of the TinyMCE editor.</strong></p><br /><br /><p>&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>Description</u></strong><span style="margin-left:140px;"><strong><u>Enable</u></strong></span><span style="margin-left:20px;"><strong><u>Image</u></strong></span><span style="margin-left:35px;"><strong><u>Help</u></strong></span></p>','jwl-ultimate-tinymce');
 }
 function jwl_setting_section_callback_function3() {
 	_e('<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;These are added bonuses and features I have included.</strong></p>','jwl-ultimate-tinymce');
 }
 function jwl_setting_section_callback_function4() {
 	_e('<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;Here you can enable advanced features of the TinyMCE Editor.<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;NOTE:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;Checking the box "enables" the selected advanced feature.<br />&nbsp;&nbsp;&nbsp;&nbsp;De-selecting the box will restore original Wordpress default functionality for that setting.</p>','jwl-ultimate-tinymce');
 }
 
 // Begin Callback functions for each individual setting registered in code above.
 // Callback Functions for Row 3 Buttons
 function jwl_fontselect_callback_function() {
    echo '<input name="jwl_fontselect_field_id" id="fontselect" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_fontselect_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/fontselect.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/fontselect.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_fontsizeselect_callback_function() {
 	echo '<input name="jwl_fontsizeselect_field_id" id="fontsize" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_fontsizeselect_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/fontsizeselect.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/fontsize.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_cut_callback_function() {
 	echo '<input name="jwl_cut_field_id" id="cut" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_cut_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/cut.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/cut.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_copy_callback_function() {
 	echo '<input name="jwl_copy_field_id" id="copy" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_copy_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/copy.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/copy.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_paste_callback_function() {
 	echo '<input name="jwl_paste_field_id" id="paste" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_paste_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/paste.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/paste.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_backcolorpicker_callback_function() {
 	echo '<input name="jwl_backcolorpicker_field_id" id="backcolorpicker" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_backcolorpicker_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/backcolorpicker.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/bg.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_forecolorpicker_callback_function() {
 	echo '<input name="jwl_forecolorpicker_field_id" id="forecolorpicker" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_forecolorpicker_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/forecolorpicker.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/fg.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_advhr_callback_function() {
 	echo '<input name="jwl_advhr_field_id" id="hr" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_advhr_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/hr.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/hr.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_visualaid_callback_function() {
 	echo '<input name="jwl_visualaid_field_id" id="visualaid" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_visualaid_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/visualaid.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/visual.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_anchor_callback_function() {
 	echo '<input name="jwl_anchor_field_id" id="anchor" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_anchor_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/anchor.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/anchor.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_sub_callback_function() {
 	echo '<input name="jwl_sub_field_id" id="sub" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_sub_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/sub.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/sub.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_sup_callback_function() {
 	echo '<input name="jwl_sup_field_id" id="sup" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_sup_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/sup.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/sup.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_search_callback_function() {
 	echo '<input name="jwl_search_field_id" id="search" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_search_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/search.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/search.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_replace_callback_function() {
 	echo '<input name="jwl_replace_field_id" id="replace" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_replace_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/replace.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/replace.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_moods_callback_function() {
 	echo '<input name="jwl_moods_field_id" id="moods" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_moods_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/moods.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/moods.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_datetime_callback_function() {
 	echo '<input name="jwl_datetime_field_id" id="datetime" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_datetime_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/datetime.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/datetime.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:32px;margin-bottom:-5px;" title="Click for Help" /></a><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/new.png" style="margin-left:10px;margin-bottom:-5px;" title="New Feature." /><?php
 }
 
 // Callback Functions for Row 4 Buttons
 /* function jwl_tablecontrols_callback_function() {
 	echo '<input name="jwl_tablecontrols_field_id" id="tablecontrols" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_tablecontrols_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/tablecontrols.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/table.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 } */
 
 function jwl_styleselect_callback_function() {
 	echo '<input name="jwl_styleselect_field_id" id="styleselect" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_styleselect_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/styleselect.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/styleselect.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_tableDropdown_callback_function() {
 	echo '<input name="jwl_tableDropdown_field_id" id="tableDropdown" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_tableDropdown_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/tableDropdown.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/tableDropdown.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:67px;margin-bottom:-5px;" title="Click for Help" /></a><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/new.png" style="margin-left:10px;margin-bottom:-5px;" title="New Feature." /><?php
 }
 
 function jwl_emotions_callback_function() {
 	echo '<input name="jwl_emotions_field_id" id="emotions" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_emotions_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/emotions.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/emotions.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_image_callback_function() {
 	echo '<input name="jwl_image_field_id" id="image" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_image_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/image.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/image.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_preview_callback_function() {
 	echo '<input name="jwl_preview_field_id" id="preview" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_preview_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/preview.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/preview.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_cite_callback_function() {
 	echo '<input name="jwl_cite_field_id" id="cite" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_cite_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/cite.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/cite.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_abbr_callback_function() {
 	echo '<input name="jwl_abbr_field_id" id="abbr" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_abbr_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/abbr.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/abbr.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_acronym_callback_function() {
 	echo '<input name="jwl_acronym_field_id" id="acronym" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_acronym_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/acronym.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/acronym.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_del_callback_function() {
 	echo '<input name="jwl_del_field_id" id="del" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_del_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/del.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/del.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_ins_callback_function() {
 	echo '<input name="jwl_ins_field_id" id="ins" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_ins_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/ins.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/ins.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_attribs_callback_function() {
 	echo '<input name="jwl_attribs_field_id" id="attribs" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_attribs_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/attribs.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/attrib.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_styleprops_callback_function() {
 	echo '<input name="jwl_styleprops_field_id" id="styleprops" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_styleprops_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/styleprops.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/styleprops.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_code_callback_function() {
 	echo '<input name="jwl_code_field_id" id="code" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_code_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/code.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/code.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_codemagic_callback_function() {
 	echo '<input name="jwl_codemagic_field_id" id="codemagic" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_codemagic_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/codemagic.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/codemagic.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_media_callback_function() {
 	echo '<input name="jwl_media_field_id" id="media" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_media_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/media.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/media.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_youtube_callback_function() {
 	echo '<input name="jwl_youtube_field_id" id="youtube" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_youtube_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/youtube.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/youtube.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_imgmap_callback_function() {
 	echo '<input name="jwl_imgmap_field_id" id="imgmap" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_imgmap_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/imgmap.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/imgmap.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_visualchars_callback_function() {
 	echo '<input name="jwl_visualchars_field_id" id="visualchars" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_visualchars_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/visualchars.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/visualchars.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/new.png" style="margin-left:10px;margin-bottom:-5px;" title="New Feature." /><?php
 }
 
 function jwl_print_callback_function() {
 	echo '<input name="jwl_print_field_id" id="print" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_print_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/print.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/print.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:66px;margin-bottom:-5px;" title="Click for Help" /></a><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/new.png" style="margin-left:10px;margin-bottom:-5px;" title="New Feature." /><?php
 }
 
 // Callback functions for miscellaneous options and features
 
 function jwl_tinymce_nextpage_callback_function() {
 	echo '<input name="jwl_tinymce_nextpage_field_id" id="tinymce_nextpage" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_tinymce_nextpage_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/nextpage.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/new.png" style="margin-left:10px;margin-bottom:-5px;" title="New Feature." /><?php
 }
 
 function jwl_tinymce_excerpt_callback_function() {
 	echo '<input name="jwl_tinymce_excerpt_field_id" id="tinymce_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_tinymce_excerpt_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/excerpt.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_postid_callback_function() {
 	echo '<input name="jwl_postid_field_id" id="postid" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_postid_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/postid.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_shortcode_callback_function() {
 	echo '<input name="jwl_shortcode_field_id" id="shortcode" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_shortcode_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/widgetshortcode.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_php_widget_callback_function() {
 	echo '<input name="jwl_php_widget_field_id" id="media" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_php_widget_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/php.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_signoff_callback_function() {
 	echo '<textarea name="jwl_signoff_field_id" value=" rows="15" class="long-text" style="width:400px; height:100px;">';
	echo get_option('jwl_signoff_field_id');
	echo '</textarea>';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/signoff.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
	echo '<br />Insert the above code using the <b>[signoff]</b> shortcode within your post.';
 }
 
 // Callback functions for Advanced TinyMCE Features
 function jwl_defaults_callback_function() {
 	echo '<input name="jwl_defaults_field_id" id="defaults" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_defaults_field_id'), false ) . ' /> ';
	?><img src="<?php echo plugin_dir_url( __FILE__ ) ?>advlink/advlink.png" style="margin-left:10px;margin-bottom:-5px;" /><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/advlink.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/new.png" style="margin-left:10px;margin-bottom:-5px;" title="New Feature." /><?php
 }
 
 function jwl_custom_styles_callback_function() {
 	echo '<input name="jwl_custom_styles_field_id" id="custom_styles" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_custom_styles_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/advstyles.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }
 
 function jwl_div_callback_function() {
 	echo '<input name="jwl_div_field_id" id="div" type="checkbox" value="1" class="code" ' . checked( 1, get_option('jwl_div_field_id'), false ) . ' /> ';
	?><a href="javascript:popcontact('<?php echo plugin_dir_url( __FILE__ ) ?>js/popup-help/divclear.php')"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>img/popup-help.png" style="margin-left:10px;margin-bottom:-5px;" title="Click for Help" /></a><?php
 }

// Finally, our custom functions for how we want the options to work.
// Functions for Row 3
function tinymce_add_button_fontselect($buttons) { $jwl_fontselect = get_option('jwl_fontselect_field_id'); if ($jwl_fontselect == "1") $buttons[] = 'fontselect'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_fontselect");

function tinymce_add_button_fontsizeselect($buttons) { $jwl_fontsizeselect = get_option('jwl_fontsizeselect_field_id'); if ($jwl_fontsizeselect == "1") $buttons[] = 'fontsizeselect'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_fontsizeselect");

function tinymce_add_button_cut($buttons) { $jwl_cut = get_option('jwl_cut_field_id'); if ($jwl_cut == "1") $buttons[] = 'cut'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_cut");

function tinymce_add_button_copy($buttons) { $jwl_copy = get_option('jwl_copy_field_id'); if ($jwl_copy == "1") $buttons[] = 'copy'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_copy");

function tinymce_add_button_paste($buttons) { $jwl_paste = get_option('jwl_paste_field_id'); if ($jwl_paste == "1") $buttons[] = 'paste'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_paste");

function tinymce_add_button_backcolorpicker($buttons) { $jwl_backcolorpicker = get_option('jwl_backcolorpicker_field_id'); if ($jwl_backcolorpicker == "1") $buttons[] = 'backcolorpicker'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_backcolorpicker");

function tinymce_add_button_forecolorpicker($buttons) { $jwl_forecolorpicker = get_option('jwl_forecolorpicker_field_id'); if ($jwl_forecolorpicker == "1") $buttons[] = 'forecolorpicker'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_forecolorpicker");

function tinymce_add_button_advhr($buttons) { $jwl_advhr = get_option('jwl_advhr_field_id'); if ($jwl_advhr == "1") $buttons[] = 'advhr'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_advhr");

function tinymce_add_button_visualaid($buttons) { $jwl_visualaid = get_option('jwl_visualaid_field_id'); if ($jwl_visualaid == "1")
$buttons[] = 'visualaid'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_visualaid");

function tinymce_add_button_anchor($buttons) { $jwl_anchor = get_option('jwl_anchor_field_id'); if ($jwl_anchor == "1")
$buttons[] = 'anchor'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_anchor");

function tinymce_add_button_sub($buttons) { $jwl_sub = get_option('jwl_sub_field_id'); if ($jwl_sub == "1") $buttons[] = 'sub'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_sub");

function tinymce_add_button_sup($buttons) { $jwl_sup = get_option('jwl_sup_field_id'); if ($jwl_sup == "1") $buttons[] = 'sup'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_sup");

function tinymce_add_button_search($buttons) { $jwl_search = get_option('jwl_search_field_id'); if ($jwl_search == "1") $buttons[] = 'search'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_search");

function tinymce_add_button_replace($buttons) { $jwl_replace = get_option('jwl_replace_field_id'); if ($jwl_replace == "1") $buttons[] = 'replace'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_replace");

function tinymce_add_button_moods($buttons) { $jwl_moods = get_option('jwl_moods_field_id'); if ($jwl_moods == "1") $buttons[] = 'moods'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_moods");

function tinymce_add_button_datetime($buttons) { $jwl_datetime = get_option('jwl_datetime_field_id'); if ($jwl_datetime == "1") $buttons[] = 'insertdate,inserttime'; return $buttons; } add_filter("mce_buttons_3", "tinymce_add_button_datetime");

// Functions for Row 4
// function tinymce_add_button_tablecontrols($buttons) { $jwl_tablecontrols = get_option('jwl_tablecontrols_field_id'); if ($jwl_tablecontrols == "1") $buttons[] = 'tablecontrols'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_tablecontrols");

function tinymce_add_button_styleselect($buttons) { $jwl_styleselect = get_option('jwl_styleselect_field_id'); if ($jwl_styleselect == "1") $buttons[] = 'styleselect'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_styleselect");

function tinymce_add_button_tableDropdown($buttons) { $jwl_tableDropdown = get_option('jwl_tableDropdown_field_id'); if ($jwl_tableDropdown == "1") $buttons[] = 'tableDropdown'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_tableDropdown");

function tinymce_add_button_emotions($buttons) { $jwl_emotions = get_option('jwl_emotions_field_id'); if ($jwl_emotions == "1") $buttons[] = 'emotions'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_emotions");

function tinymce_add_button_image($buttons) { $jwl_image = get_option('jwl_image_field_id'); if ($jwl_image == "1") $buttons[] = 'image'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_image");

function tinymce_add_button_preview($buttons) { $jwl_preview = get_option('jwl_preview_field_id'); if ($jwl_preview == "1") $buttons[] = 'preview'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_preview");

function tinymce_add_button_cite($buttons) { $jwl_cite = get_option('jwl_cite_field_id'); if ($jwl_cite == "1") $buttons[] = 'cite'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_cite");

function tinymce_add_button_abbr($buttons) { $jwl_abbr = get_option('jwl_abbr_field_id'); if ($jwl_abbr == "1") $buttons[] = 'abbr'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_abbr");

function tinymce_add_button_acronym($buttons) { $jwl_acronym = get_option('jwl_acronym_field_id'); if ($jwl_acronym == "1") $buttons[] = 'acronym'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_acronym");

function tinymce_add_button_del($buttons) { $jwl_del = get_option('jwl_del_field_id'); if ($jwl_del == "1") $buttons[] = 'del'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_del");

function tinymce_add_button_ins($buttons) { $jwl_ins = get_option('jwl_ins_field_id'); if ($jwl_ins == "1") $buttons[] = 'ins'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_ins");

function tinymce_add_button_attribs($buttons) { $jwl_attribs = get_option('jwl_attribs_field_id'); if ($jwl_attribs == "1") $buttons[] = 'attribs'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_attribs");

function tinymce_add_button_styleprops($buttons) { $jwl_styleprops = get_option('jwl_styleprops_field_id'); if ($jwl_styleprops == "1") $buttons[] = 'styleprops'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_styleprops");

function tinymce_add_button_code($buttons) { $jwl_code = get_option('jwl_code_field_id'); if ($jwl_code == "1") $buttons[] = 'code'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_code");

function tinymce_add_button_codemagic($buttons) { $jwl_codemagic = get_option('jwl_codemagic_field_id'); if ($jwl_codemagic == "1") $buttons[] = 'codemagic'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_codemagic");

function tinymce_add_button_media($buttons) { $jwl_media = get_option('jwl_media_field_id'); if ($jwl_media == "1") $buttons[] = 'media'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_media");

function tinymce_add_button_youtube($buttons) { $jwl_youtube = get_option('jwl_youtube_field_id'); if ($jwl_youtube == "1") $buttons[] = 'youtube'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_youtube");

function tinymce_add_button_imgmap($buttons) { $jwl_imgmap = get_option('jwl_imgmap_field_id'); if ($jwl_imgmap == "1") $buttons[] = 'imgmap'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_imgmap");

function tinymce_add_button_visualchars($buttons) { $jwl_visualchars = get_option('jwl_visualchars_field_id'); if ($jwl_visualchars == "1") $buttons[] = 'visualchars'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_visualchars");

function tinymce_add_button_print($buttons) { $jwl_print = get_option('jwl_print_field_id'); if ($jwl_print == "1") $buttons[] = 'print'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_print");

// Functions for Advanced TinyMCE Features
// User option for restoring default Wordpress Insert/Edit Link functionality.
function disable_advanced_link_array( $plugin_array ) {
$jwl_defaults = get_option('jwl_defaults_field_id');
	if ($jwl_defaults == "1") {
		$plugin_array['advlink'] = plugin_dir_url(__FILE__) . 'advlink/editor_plugin.js';
		return $plugin_array;
	}
}
add_filter( 'mce_external_plugins', 'disable_advanced_link_array' );

function jwl_advlink_button($mce_buttons) {
    $pos = array_search('unlink',$mce_buttons,true);
    if ($pos !== false) {
        $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
        $tmp_buttons[] = 'advlink';
        $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
    }
    return $mce_buttons;
}
add_filter('mce_buttons','jwl_advlink_button');

// User option for Adding in custom styles if selected.
$jwl_custom_styles = get_option('jwl_custom_styles_field_id');
if ($jwl_custom_styles == "1") {
		function josh_mce_before_init( $settings ) {
    	$style_formats = array(
    	//array( 'title' => 'Button', 'selector' => 'a', 'classes' => 'button' ),
        //array( 'title' => 'Callout Box', 'block' => 'div', 'classes' => 'callout', 'wrapper' => true ),
        array( 'title' => __('Bold Red Text','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'color' => '#FF0000', 'fontWeight' => 'bold' )),
		array( 'title' => __('Bold Green Text','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'color' => '#00FF00', 'fontWeight' => 'bold' )),
		array( 'title' => __('Bold Blue Text','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'color' => '#0000FF', 'fontWeight' => 'bold' )),
		array( 'title' => __('Borders','jwl-ultimate-tinymce')),
		array( 'title' => __('Border Black','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'border' => '1px solid #000000', 'padding' => '2px' )),
		array( 'title' => __('Border Red','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'border' => '1px solid #FF0000', 'padding' => '2px' )),
		array( 'title' => __('Border Green','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'border' => '1px solid #00FF00', 'padding' => '2px' )),
		array( 'title' => __('Border Blue','jwl-ultimate-tinymce'), 'inline' => 'span', 'styles' => array( 'border' => '1px solid #0000FF', 'padding' => '2px' )),
		array( 'title' => __('Float','jwl-ultimate-tinymce')),
		array( 'title' => __('Float Left','jwl-ultimate-tinymce'), 'block' => 'span', 'styles' => array( 'float' => 'left' )),
		array( 'title' => __('Float Right','jwl-ultimate-tinymce'), 'block' => 'span', 'styles' => array( 'float' => 'right' )),
		array( 'title' => __('Alerts','jwl-ultimate-tinymce')),
		array( 'title' => __('Normal Alert','jwl-ultimate-tinymce'), 'block' => 'div', 'styles' => array( 'border' => 'solid 1px #DEDEDE', 'background' => '#EFEFEF url('.plugin_dir_url( __FILE__ ).'img/normal.png) 8px 4px no-repeat', 'color' => '#222222' , 'padding' => '4px 4px 4px 30px' , 'text-align' => 'left'  )),
		array( 'title' => __('Green Alert','jwl-ultimate-tinymce'), 'block' => 'div', 'styles' => array( 'border' => 'solid 1px #1EDB0D', 'background' => '#A9FCA2 url('.plugin_dir_url( __FILE__ ).'img/green.png) 8px 4px no-repeat', 'color' => '#222222' , 'padding' => '4px 4px 4px 30px' , 'text-align' => 'left'  )),
		array( 'title' => __('Yellow Alert','jwl-ultimate-tinymce'), 'block' => 'div', 'styles' => array( 'border' => 'solid 1px #F5F531', 'background' => '#FAFAB9 url('.plugin_dir_url( __FILE__ ).'img/yellow.png) 8px 4px no-repeat', 'color' => '#222222' , 'padding' => '4px 4px 4px 30px' , 'text-align' => 'left'  )),
		array( 'title' => __('Red Alert','jwl-ultimate-tinymce'), 'block' => 'div', 'styles' => array( 'border' => 'solid 1px #ED220C', 'background' => '#FABDB6 url('.plugin_dir_url( __FILE__ ).'img/red.png) 8px 4px no-repeat', 'color' => '#222222' , 'padding' => '4px 4px 4px 30px' , 'text-align' => 'left'  ))
   	    );

    	$settings['style_formats'] = json_encode( $style_formats );
    	return $settings;
		}
		add_filter( 'tiny_mce_before_init', 'josh_mce_before_init' );
}

// User option for adding the clear div buttons in the visual editor
function tinymce_add_button_div($buttons) {
$jwl_div = get_option('jwl_div_field_id');
if ($jwl_div == "1")
array_push($buttons, "separator", "clearleft","clearright","clearboth");
   return $buttons;
}
add_filter("mce_buttons", "tinymce_add_button_div");

// Functions for miscellaneous options and features
// Function for NextPage Feature
$jwl_tinymce_nextpage = get_option('jwl_tinymce_nextpage_field_id');
if ($jwl_tinymce_nextpage == "1"){
    add_filter('mce_buttons','jwl_nextpage_button');
    function jwl_nextpage_button($mce_buttons) {
    $pos = array_search('wp_more',$mce_buttons,true);
    if ($pos !== false) {
        $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
        $tmp_buttons[] = 'wp_page';
        $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
    }
    return $mce_buttons;
    }
}


// Function for excerpt editor
$jwl_tinymce_excerpt = get_option('jwl_tinymce_excerpt_field_id');
if ($jwl_tinymce_excerpt == "1"){
	function jwl_tinymce_excerpt_js(){ ?>
		<script type="text/javascript">
            jQuery(document).ready( tinymce_excerpt );
                    function tinymce_excerpt() {
                jQuery("#excerpt").addClass("mceEditor");
                tinyMCE.execCommand("mceAddControl", false, "excerpt");
                }
        </script>
    <?php }
    add_action( 'admin_head-post.php', 'jwl_tinymce_excerpt_js');
    add_action( 'admin_head-post-new.php', 'jwl_tinymce_excerpt_js');
    function jwl_tinymce_css(){ ?>
		<style type='text/css'>
                #postexcerpt .inside{margin:0;padding:0;background:#fff;}
                #postexcerpt .inside p{padding:0px 0px 5px 10px;}
                #postexcerpt #excerpteditorcontainer { border-style: solid; padding: 0; }
        </style>
    <?php }
    add_action( 'admin_head-post.php', 'jwl_tinymce_css');
    add_action( 'admin_head-post-new.php', 'jwl_tinymce_css');
}

// Function to show post/page id in admin column area
$jwl_postid = get_option('jwl_postid_field_id');
if ($jwl_postid == "1"){
   		function jwl_posts_columns_id($defaults){
			$defaults['wps_post_id'] = __('ID');
			return $defaults;
		}
		add_filter('manage_posts_columns', 'jwl_posts_columns_id', 5);
		add_filter('manage_pages_columns', 'jwl_posts_columns_id', 5);
		function jwl_posts_custom_id_columns($column_name, $id){
			if($column_name === 'wps_post_id'){
					echo $id;
			}
		}
		add_action('manage_posts_custom_column', 'jwl_posts_custom_id_columns', 5, 2);
    	add_action('manage_pages_custom_column', 'jwl_posts_custom_id_columns', 5, 2);
}

// Function to show shortcodes in widget area
$jwl_shortcode = get_option('jwl_shortcode_field_id');
if ($jwl_shortcode == "1"){
   	add_filter( 'widget_text', 'shortcode_unautop');
	add_filter( 'widget_text', 'do_shortcode');
}

// Adding PHP text widgets
$jwl_php_widget = get_option('jwl_php_widget_field_id');
if ($jwl_php_widget == "1"){

class jwl_PHP_Code_Widget extends WP_Widget {

	function jwl_PHP_Code_Widget() {
		$widget_ops = array('classname' => 'widget_execphp', 'description' => __('Arbitrary text, HTML, or PHP Code'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('execphp', __('PHP Code'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_execphp', $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
			ob_start();
			eval('?>'.$text);
			$text = ob_get_contents();
			ob_end_clean();
			?>			
			<div class="execphpwidget"><?php echo $instance['filter'] ? wpautop($text) : $text; ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs.'); ?></label></p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("jwl_PHP_Code_Widget");'));
}


// User option for adding a signoff shortcode for tinymce visual editor (Goes with custom message box below)
function jwl_sign_off_text() {  
	$jwl_signoff = get_option('jwl_signoff_field_id');
    return $jwl_signoff;  
} 
add_shortcode('signoff', 'jwl_sign_off_text');
// User option for adding a custom message box on login page
$jwl_loginbox = get_option('jwl_loginbox_field_id');

// Wrapping it up.... and new test features.
// Attempting to solve removal of <p> and <br /> tags
//add_filter('tiny_mce_before_init', 'jwl_tinymce_clear_buttons_before_init');
//function jwl_tinymce_clear_buttons_before_init( $init ) {
	//$init['extended_valid_elements'] .= ',*[*],div[*],iframe[*],object[*],param[*],embed[*],p[*],pre[*],br[*]';
	//$init['valid_elements'] .= ',*[*],br[*],p[*]';
	//$init['force_p_newlines'] .= false;
	// More Possibilities following example above
	// article[*],aside[*],audio[*],canvas[*],command[*],datalist[*],details[*],figcaption[*],figure[*],footer[*],header[*],hgroup[*],keygen[*],mark[*],meter[*],nav[*],output[*],progress[*],section[*],source[*],summary[*],time[*],video[*],wbr[*]
    //return $init;
//}

// Add the plugin array for extra features
function jwl_mce_external_plugins( $plugin_array ) {
		$plugin_array['table'] = plugin_dir_url( __FILE__ ) . 'table/editor_plugin.js';
		$plugin_array['emotions'] = plugin_dir_url(__FILE__) . 'emotions/editor_plugin.js';
		$plugin_array['advlist'] = plugin_dir_url(__FILE__) . 'advlist/editor_plugin.js';
		$plugin_array['advimage'] = plugin_dir_url(__FILE__) . 'advimage/editor_plugin.js';
		$plugin_array['searchreplace'] = plugin_dir_url(__FILE__) . 'searchreplace/editor_plugin.js';
		$plugin_array['preview'] = plugin_dir_url(__FILE__) . 'preview/editor_plugin.js';
		$plugin_array['xhtmlxtras'] = plugin_dir_url(__FILE__) . 'xhtmlxtras/editor_plugin.js';
		$plugin_array['style'] = plugin_dir_url(__FILE__) . 'style/editor_plugin.js';
		$plugin_array['moods'] = plugin_dir_url(__FILE__) . 'moods/editor_plugin.js';
		$plugin_array['media'] = plugin_dir_url(__FILE__) . 'media/editor_plugin.js';
		$plugin_array['advhr'] = plugin_dir_url(__FILE__) . 'advhr/editor_plugin.js';
		$plugin_array['clear'] = plugin_dir_url( __FILE__ ) . 'clear/editor_plugin.js';
		$plugin_array['tableDropdown'] = plugin_dir_url( __FILE__ ) . 'tableDropdown/editor_plugin.js';
		$plugin_array['codemagic'] = plugin_dir_url( __FILE__ ) . 'codemagic/editor_plugin.js';
		$plugin_array['youtube'] = plugin_dir_url( __FILE__ ) . 'youtube/editor_plugin.js';
		$plugin_array['imgmap'] = plugin_dir_url( __FILE__ ) . 'imgmap/editor_plugin.js';
		$plugin_array['visualchars'] = plugin_dir_url( __FILE__ ) . 'visualchars/editor_plugin.js';
		$plugin_array['print'] = plugin_dir_url( __FILE__ ) . 'print/editor_plugin.js';
		$plugin_array['insertdatetime'] = plugin_dir_url( __FILE__ ) . 'insertdatetime/editor_plugin.js';
		   
		return $plugin_array;
}
add_filter( 'mce_external_plugins', 'jwl_mce_external_plugins' );

//function tinymce_add_button_keywordextractor($buttons) { $buttons[] = 'keywordextractor'; return $buttons; } add_filter("mce_buttons_4", "tinymce_add_button_keywordextractor");

?>