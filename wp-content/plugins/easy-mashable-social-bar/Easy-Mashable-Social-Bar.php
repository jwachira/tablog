<?php
/*
Plugin Name: Easy Mashable Social Box 
Plugin URI: http://www.incrediblogger.net/wordpress/plugins/easy-mashable-social-bar-plugin-recoded-cleaned/
Description: This beautiful <a href="http://www.incrediblogger.net/wordpress/plugins/easy-mashable-social-bar-plugin-recoded-cleaned/" target="_blank"><strong>Easy Mashable Social Box</strong></a> wordpress plugin is inspired by Mashable.com, coded by <a href="http://www.incrediblogger.net/" target="_blank"><strong>IncrediBlogger</strong></a>. Original plugin coded by InspiredMagz. This version is free from any hidden links. Every setting of this plugin can be set on the widget page section. Just drag-and-drop the widget to the sidebar. If you are facing any problem with this widget or bug, please drop me a comment at this link, <a href="http://www.incrediblogger.net/wordpress/plugins/easy-mashable-social-bar-plugin-recoded-cleaned/" target="_blank"><strong>Easy Mashable Social Box plugin</strong></a>.
Version: 1.1.4
Author: Prasenjit
Author URI: http://www.incrediblogger.net/
License: GPLv2
*/
 
class incredibloggermashable extends WP_Widget {

	function incredibloggermashable() {
		$widget_ops = array('classname' => 'incredibloggermashable', 'description' => __('Display your social profiles on sidebar. This is Easy Mashable Social Box plugin by IncrediBlogger'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('incredibloggermashable', __('Easy Mashable Social Box'), $widget_ops, $control_ops);
	}

	function head() {
		$siteurl = get_option('siteurl');
		$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/styles.css';
		echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
	}
					
	function widget( $args, $instance ) {
		extract($args);	
		$feedburner_id = $instance['feedburner_id'];
		$twitter_id = $instance['twitter_id'];
		$facebook_id = $instance['facebook_id'];
		$feedburner_email_id = $instance['feedburner_email_id'];
		$googleplus_id = $instance['googleplus_id'];
		$widgetwidth_id = $instance['widgetwidth_id'];
		$fbwidth_id = $instance['fbwidth_id'];
		$fbheight_id = $instance['fbheight_id'];
		$recommend_id = $instance['recommend_id'];
		$emailwidth_id = $instance['emailwidth_id'];
		$emailtext_id = $instance['emailtext_id'];
		$footerurl_id = $instance['footerurl_id'];
		$footertext_id = $instance['footertext_id'];
		$fbboxcolor_id = $instance['fbboxcolor_id'];
		$gpluscolor_id = $instance['gpluscolor_id'];
		$twitcolor_id = $instance['twitcolor_id'];
		$emailcolor_id = $instance['emailcolor_id'];
		$othercolor_id = $instance['othercolor_id'];
		$show_add_to_circles = $instance['show_add_to_circles'];
		$show_google_small_badge = $instance['show_google_small_badge'];
		$gplus_theme = $instance['gplus_theme'];
		$show_fb_faces = $instance['show_fb_faces'];
		$show_author_credit = $instance['show_author_credit'];
		?>
		
<!--begin of social widget--> 
<div style="margin-bottom:10px;">
<div id="inspiredmagz-mashable-bar" style="width:<?php echo $widgetwidth_id; ?>px;"> <!-- Begin Widget -->
	<!-- Place this tag where you want the badge to render -->
	<h3>Subscribe to True Artists</h3>
	<?php if($show_add_to_circles == 1) { ?>
		<div class="fb-subscribe" style="background-color: white; padding:10px; border: 1px solid #dcdcdc; width: 278px; margin-bottom: 18px;" data-href="http://www.facebook.com/trueartistscontacts" data-show-faces="true" data-width="280"></div>
		<div class="g-plus" data-href="https://plus.google.com/<?php echo $googleplus_id; ?>" data-height="<?php if ($show_google_small_badge == 1) { ?>69<?php } else { ?>131<?php } ?>" data-theme="<?php if($gplus_theme == 1) {echo 'light';} else {echo 'dark';} ?>"></div>
	<?php } ?>
	
	<div class="fb-likebox" style="background: <?php echo $fbboxcolor_id; ?>;"> <!-- Facebook -->
		<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $facebook_id; ?>&amp;send=false&amp;layout=standard&amp;width=<?php echo $fbwidth_id; ?>&amp;show_faces=<?php if($show_fb_faces == 1) { echo 'true'; } else { echo 'false'; } ?>&amp;action=like&amp;colorscheme=light&amp;font&amp;height=<?php echo $fbheight_id; ?>&amp;appId=234513819928295" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $fbwidth_id; ?>px; height:<?php echo $fbheight_id; ?>px;"></iframe>
	</div>
	
	<div class="googleplus" style="background: <?php echo $gpluscolor_id; ?>;"> <!-- Google -->
		<span><?php echo $recommend_id; ?></span><div class="g-plusone" data-size="medium"></div>  
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script> 
	</div>

	<div class="twitter" style="background: <?php echo $twitcolor_id; ?>;"> <!-- Twitter -->
        	<iframe title="" style="width: 300px; height: 20px;" class="twitter-follow-button" src="http://platform.twitter.com/widgets/follow_button.html#_=1319978796351&amp;align=&amp;button=blue&amp;id=twitter_tweet_button_0&amp;lang=en&amp;link_color=&amp;screen_name=<?php echo $twitter_id; ?>&amp;show_count=&amp;show_screen_name=&amp;text_color=" frameborder="0" scrolling="no"></iframe>
	</div>

	<div id="email-news-subscribe" style="background: <?php echo $emailcolor_id; ?>;"> <!-- Email Subscribe -->
		<div class="email-box">
			<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">	
				<input class="email" type="text" style="width: <?php echo $emailwidth_id; ?>px; font-size: 12px;" id="email" name="email" value="<?php echo $emailtext_id; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">		
				<input type="hidden" value="<?php echo $feedburner_id; ?>" name="uri">
				<input type="hidden" name="loc" value="en_US">
				<input class="subscribe" name="commit" type="submit" value="Subscribe">	
			</form>
		</div>
	</div>

<div id="other-social-bar" style="background: <?php echo $othercolor_id; ?>;"> <!-- Other Social Bar -->
	<ul class="other-follow">
		<li class="my-rss">
			<a rel="nofollow" title="RSS" href="http://feeds.feedburner.com/<?php echo $feedburner_id; ?>" target="_blank">RSS Feed</a>
		</li>
		<?php if($feedburner_email_id != null && $feedburner_email_id != "") { ?>
		<li class="my-email">
			<a rel="nofollow external" title="Email Updates" href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner_email_id; ?>&loc=en_US" target="_blank">Email Updates</a>
		</li>
		<?php } ?>
		<li class="my-gplus">
			<a rel="nofollow" title="Google Plus" rel="author" href="http://plus.google.com/<?php echo $googleplus_id; ?>" target="_blank">Google Plus</a>
		</li>
	</ul>
</div>

<div id="get-inspiredmagz" style="background: #EBEBEB;border: 1px solid #CCC;border-top: 1px solid white;padding: 1px 8px 1px 3px;text-align: right;border-image: initial;font-size:10px;font-family: "Arial","Helvetica",sans-serif;">
      <?php if($show_author_credit == 1) { ?><span class="author-credit" style="font-family: Arial, Helvetica, sans-serif;"><a href="<?php echo $footerurl_id; ?>" target="_blank" title="<?php echo $footertext_id; ?>"><?php echo $footertext_id; ?> »</a></span><?php } ?></div></div> <!-- End Widget -->
</div>
<!--end of social widget--> 

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		
		$instance['feedburner_id'] = $new_instance['feedburner_id'];
		$instance['twitter_id'] =  $new_instance['twitter_id'];
		$instance['facebook_id'] =  $new_instance['facebook_id'];
		$instance['feedburner_email_id'] =  $new_instance['feedburner_email_id'];
		$instance['googleplus_id'] =  $new_instance['googleplus_id'];
		$instance['widgetwidth_id'] =  $new_instance['widgetwidth_id'];
		$instance['fbwidth_id'] =  $new_instance['fbwidth_id'];
		$instance['fbheight_id'] =  $new_instance['fbheight_id'];
		$instance['recommend_id'] =  $new_instance['recommend_id'];
		$instance['emailwidth_id'] =  $new_instance['emailwidth_id'];
		$instance['emailtext_id'] =  $new_instance['emailtext_id'];
		$instance['fbboxcolor_id'] =  $new_instance['fbboxcolor_id'];
		$instance['gpluscolor_id'] =  $new_instance['gpluscolor_id'];
		$instance['twitcolor_id'] =  $new_instance['twitcolor_id'];
		$instance['emailcolor_id'] =  $new_instance['emailcolor_id'];
		$instance['othercolor_id'] =  $new_instance['othercolor_id'];
		$instance['show_add_to_circles'] =  $new_instance['show_add_to_circles'];
		$instance['show_google_small_badge'] =  $new_instance['show_google_small_badge'];
		$instance['gplus_theme'] =  $new_instance['gplus_theme'];
		$instance['show_fb_faces'] =  $new_instance['show_fb_faces'];
		$instance['show_author_credit'] =  $new_instance['show_author_credit'];
		return $instance;
	}

	function form( $instance ) { 
		$instance = wp_parse_args( (array) $instance, array( 'feedburner_id' => 'Incrediblogger', 'twitter_id' => 'Incrediblogger', 'facebook_id' => 'http://www.facebook.com/pages/IncrediBlogger/187134431340419', 'fbwidth_id' => '270', 'fbheight_id' => '80', 'recommend_id' => 'Recommend on Google', 'emailwidth_id' => '140', 'emailtext_id' => 'Enter your email', 'footerurl_id' => 'http://www.incrediblogger.net/wordpress/plugins/easy-mashable-social-bar-plugin-recoded-cleaned/', 'footertext_id' => 'Get this plugin', 'fbboxcolor_id' => '#FFF', 'gpluscolor_id' => '#F5FCFE', 'twitcolor_id' => '#EEF9FD', 'emailcolor_id' => '#E3EDF4', 'othercolor_id' => '#D8E6EB', 'feedburner_email_id' => 'Incrediblogger', 'googleplus_id' => '100470876568345536294', 'widgetwidth_id' => '280', 'show_add_to_circles' => '1', 'show_fb_faces' => '1', 'show_google_small_badge' => '1', 'gplus_theme' => '1', 'show_author_credit' => '1' ) );
		$feedburner_id = $instance['feedburner_id'];
		$twitter_id = format_to_edit($instance['twitter_id']);
		$facebook_id = format_to_edit($instance['facebook_id']);
		$feedburner_email_id = format_to_edit($instance['feedburner_email_id']);
		$googleplus_id = format_to_edit($instance['googleplus_id']);
		$widgetwidth_id = format_to_edit($instance['widgetwidth_id']);
		$fbwidth_id = format_to_edit($instance['fbwidth_id']);
		$fbheight_id = format_to_edit($instance['fbheight_id']);
		$recommend_id = format_to_edit($instance['recommend_id']);
		$emailwidth_id = format_to_edit($instance['emailwidth_id']);
		$emailtext_id = format_to_edit($instance['emailtext_id']);
		$fbboxcolor_id = format_to_edit($instance['fbboxcolor_id']);
		$gpluscolor_id = format_to_edit($instance['gpluscolor_id']);
		$twitcolor_id = format_to_edit($instance['twitcolor_id']);
		$emailcolor_id = format_to_edit($instance['emailcolor_id']);
		$othercolor_id = format_to_edit($instance['othercolor_id']);
		$show_add_to_circles = format_to_edit($instance['show_add_to_circles']);
		$show_google_small_badge = format_to_edit($instance['show_google_small_badge']);
		$gplus_theme = format_to_edit($instance['gplus_theme']);
		$show_fb_faces = format_to_edit($instance['show_fb_faces']);
		$show_author_credit = format_to_edit($instance['show_author_credit']);
	?>			
		<center><strong><u>Social Profiles Setting</u></strong></center><br />
		<p><label for="<?php echo $this->get_field_id('feedburner_id'); ?>"><?php _e('Enter your Feedburner ID:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('feedburner_id'); ?>" name="<?php echo $this->get_field_name('feedburner_id'); ?>" type="text" value="<?php echo $feedburner_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Enter your Twitter ID:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $twitter_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('facebook_id'); ?>"><?php _e('Enter your Facebook URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('facebook_id'); ?>" value="<?php echo $facebook_id; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('feedburner_email_id'); ?>"><?php _e('Enter your Feedburner Email ID:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('feedburner_email_id'); ?>" value="<?php echo $feedburner_email_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('googleplus_id'); ?>"><?php _e('Enter your Google+ ID:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('googleplus_id'); ?>" value="<?php echo $googleplus_id; ?>" /></p>

		<center><strong><u>Other Settings</u></strong></center><br />
		<p><label for="<?php echo $this->get_field_id('widgetwidth_id'); ?>"><?php _e('Widget width(px):'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('widgetwidth_id'); ?>" value="<?php echo $widgetwidth_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('fbwidth_id'); ?>"><?php _e('Facebook width(px):'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('fbwidth_id'); ?>" value="<?php echo $fbwidth_id; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('fbheight_id'); ?>"><?php _e('Facebook height(px): If Show FB faces is set to true, then please set the height to a minimum of 80'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('fbheight_id'); ?>" value="<?php echo $fbheight_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('recommend_id'); ?>"><?php _e('Google recommend text:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('recommend_id'); ?>" value="<?php echo $recommend_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('emailwidth_id'); ?>"><?php _e('Subscription box width(px):'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('emailwidth_id'); ?>" value="<?php echo $emailwidth_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('emailtext_id'); ?>"><?php _e('Subscription box text:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('emailtext_id'); ?>" value="<?php echo $emailtext_id; ?>" /></p>
		
		<center><strong><u>Background Color Settings</u></strong><br />[Get color code list  <a href="http://html-color-codes.info/" rel="nofollow" title="Get color code list here" target="_blank"><strong>HERE</strong></a>]</center><br />
		<p><label for="<?php echo $this->get_field_id('fbboxcolor_id'); ?>"><?php _e('Facebook: Default: #FFFFFF'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('fbboxcolor_id'); ?>" value="<?php echo $fbboxcolor_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('gpluscolor_id'); ?>"><?php _e('Google: Default: #F5FCFE'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('gpluscolor_id'); ?>" value="<?php echo $gpluscolor_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('twitcolor_id'); ?>"><?php _e('Twitter: Default: #EEF9FD'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('twitcolor_id'); ?>" value="<?php echo $twitcolor_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('emailcolor_id'); ?>"><?php _e('Subscription: Default: #E3EDF4'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('emailcolor_id'); ?>" value="<?php echo $emailcolor_id; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('othercolor_id'); ?>"><?php _e('RSS, LinkedIn, Google+: Default: #D8E6EB'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('othercolor_id'); ?>" value="<?php echo $othercolor_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'show_add_to_circles' ); ?>">Show Add to G+ Circle Badge: Default: Yes</label> 
		<select id="<?php echo $this->get_field_id( 'show_add_to_circles' ); ?>" name="<?php echo $this->get_field_name( 'show_add_to_circles' ); ?>">
		<option value="0"<?php if ( '0' == $instance['show_add_to_circles'] ) echo 'selected="selected"'; ?>>No</option>
		<option value="1"<?php if ( '1' == $instance['show_add_to_circles'] ) echo 'selected="selected"'; ?>>Yes</option>
		</select></p>
		
		<p><label for="<?php echo $this->get_field_id( 'show_fb_faces' ); ?>">Show Facebook Faces: Default: Yes</label> 
		<select id="<?php echo $this->get_field_id( 'show_fb_faces' ); ?>" name="<?php echo $this->get_field_name( 'show_fb_faces' ); ?>">
		<option value="0"<?php if ( '0' == $instance['show_fb_faces'] ) echo 'selected="selected"'; ?>>No</option>
		<option value="1"<?php if ( '1' == $instance['show_fb_faces'] ) echo 'selected="selected"'; ?>>Yes</option>
		</select></p>
		
		<p><label for="<?php echo $this->get_field_id( 'show_google_small_badge' ); ?>">G+ Badge Style: Default: Small</label> 
		<select id="<?php echo $this->get_field_id( 'show_google_small_badge' ); ?>" name="<?php echo $this->get_field_name( 'show_google_small_badge' ); ?>">
		<option value="0"<?php if ( '0' == $instance['show_google_small_badge'] ) echo 'selected="selected"'; ?>>Standard</option>
		<option value="1"<?php if ( '1' == $instance['show_google_small_badge'] ) echo 'selected="selected"'; ?>>Small</option>
		</select></p>
		
		<p><label for="<?php echo $this->get_field_id( 'gplus_theme' ); ?>">G+ Small Badge Theme(Light/Dark) Default: Light</label> 
		<select id="<?php echo $this->get_field_id( 'gplus_theme' ); ?>" name="<?php echo $this->get_field_name( 'gplus_theme' ); ?>">
		<option value="0"<?php if ( '0' == $instance['gplus_theme'] ) echo 'selected="selected"'; ?>>Dark</option>
		<option value="1"<?php if ( '1' == $instance['gplus_theme'] ) echo 'selected="selected"'; ?>>Light</option>
		</select></p>
		
		<p><label for="<?php echo $this->get_field_id( 'show_author_credit' ); ?>">Show Author Credit: Default: Yes</label> 
		<select id="<?php echo $this->get_field_id( 'show_author_credit' ); ?>" name="<?php echo $this->get_field_name( 'show_author_credit' ); ?>">
		<option value="0"<?php if ( '0' == $instance['show_author_credit'] ) echo 'selected="selected"'; ?>>No</option>
		<option value="1"<?php if ( '1' == $instance['show_author_credit'] ) echo 'selected="selected"'; ?>>Yes</option>
		</select></p>
		
		<?php }
}

add_action('widgets_init', create_function('', 'return register_widget(\'incredibloggermashable\');'));
add_action('wp_head', array('incredibloggermashable', 'head'));