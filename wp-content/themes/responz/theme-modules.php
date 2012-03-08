<?php

/* 	Custom Modules
/***************************************************************************/	
		
	///////////////////////////////////////////
	// Footer Text Left Function
	///////////////////////////////////////////
	function themify_footer_text_left($data=array()){
		$data = get_data();
		return '	<p><textarea class="widthfull" rows="4" name="setting-footer_text_left">'.$data['setting-footer_text_left'].'</textarea></p>';	
	}
	
	///////////////////////////////////////////
	// Footer Text Right Function
	///////////////////////////////////////////
	function themify_footer_text_right($data=array()){
		$data = get_data();
		return '	<p><textarea class="widthfull" rows="4" name="setting-footer_text_right">'.$data['setting-footer_text_right'].'</textarea></p>';	
	}
	
	///////////////////////////////////////////
	// Header Slider Function
	///////////////////////////////////////////
	function themify_header_slider($data=array()){
		$data = get_data();
		
		if($data['setting-header_slider_enabled']){
			$enabled_checked = "checked='checked'";	
		} else {
			$enabled_display = "style='display:none;'";	
		}
		if($data['setting-header_slider_visible'] == "" ||!isset($data['setting-header_slider_visible'])){
			$data['setting-header_slider_visible'] = "4";	
		}
		
		if($data['setting-header_slider_display'] == 'images'){
			$display_images = "checked='checked'";
			$display_posts_display = "style='display:none;'";
		} else {
			$display_posts = "checked='checked'";	
			$display_images_display = "style='display:none;'";
		}
		$title_options = array('','yes','no');
		$auto_options = array(0,1,2,3,4,5,6,7);
		$scroll_options = array(1,2,3,4,5,6,7);
		$display_options = array('none','excerpt','content');
		$speed_options = array("Fast"=>300,"Normal"=>1000,"Slow"=>2000);
		$wrap_options = array("no","yes");
		$image_options = array("one","two","three","four","five","six","seven","eight","nine","ten");
		
		$output .= '<p><span class="label">Slider</span> <input type="checkbox" name="setting-header_slider_enabled" class="feature_box_enabled_check" '.$enabled_checked.' />  Enable<br />
					<small>Check to enable slider</small>
					</p>
					<div class="feature_box_enabled_display" '.$enabled_display.'>
					
					<p><span class="label">Display</span> <input type="radio" class="feature-box-display" name="setting-header_slider_display" value="posts" '.$display_posts.' /> Posts <input type="radio" class="feature-box-display" name="setting-header_slider_display" value="images" '.$display_images.' /> Images</p>
					
					<p class="pushlabel feature_box_posts" '.$display_posts_display.'>';
							$output .= wp_dropdown_categories(array("show_option_all"=>"All Categories","show_option_all"=>"All Categories","hide_empty"=>0,"echo"=>0,"name"=>"setting-header_slider_posts_category","selected"=>$data['setting-header_slider_posts_category']));
		$output .=	'	<input type="text" name="setting-header_slider_posts_slides" value="'.$data['setting-header_slider_posts_slides'].'" class="width2" /> number of posts to be queried 
					</p>
					
					<p class="feature_box_posts" '.$display_posts_display.'>
						<span class="label">Content Display </span>
								<select name="setting-header_slider_default_display">
								';
								
								foreach($display_options as $option){
									if($option == $data['setting-header_slider_default_display']){
										$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
									} else {
										$output .= '<option value="'.$option.'">'.$option.'</option>';
									}
								}
								
			$output .= '
						</select>
					</p>';
					
			$output .= '<p class="feature_box_posts" '.$display_posts_display.'>
						<span class="label">Hide Title</span>
						<select name="setting-header_slider_hide_title">
						';
						foreach($title_options as $option){
								if($option == $data['setting-header_slider_hide_title']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}			
		$output .= '
						</select>
					</p>';
					
			$output .= '<div class="feature_box_images" '.$display_images_display.'>';
					
					$x = 0;
					foreach($image_options as $option){
						$x++;
						$output .= '
						<p>
							<span class="label">Title '.$x.'</span>
							<input type="text" class="width10" name="setting-header_slider_images_'.$option.'_title" value="'.$data['setting-header_slider_images_'.$option.'_title'].'" />
							<span class="label">Link '.$x.'</span>
							<input type="text" class="width10" name="setting-header_slider_images_'.$option.'_link" value="'.$data['setting-header_slider_images_'.$option.'_link'].'" />
							<span class="label">Image '.$x.'</span>
							<input type="text" class="width10 feature_box_img" name="setting-header_slider_images_'.$option.'_image" value="'.$data['setting-header_slider_images_'.$option.'_image'].'" /> 
							<span class="pushlabel" style="display:block;"><a href="#" class="upload-btn upload-image simple" id="slider_image_'.$option.'">+ Upload</a></span>
						</p>';
					}
		
		$output .= '</div>
					<hr />
					<p>
						<span class="label">Visible</span> 
						<select name="setting-header_slider_visible">';
						for($x=1;$x<=7;$x++){
							if($data['setting-header_slider_visible'] == $x){
								$output .= '<option value="'.$x.'" selected="selected">'.$x.'</option>';	
							} else {
								$output .= '<option value="'.$x.'">'.$x.'</option>';	
							}
						}
			$output .=	'</select> <small>(# of slides visible at the same time)</small>
					</p>
					<p>
					<span class="label">Auto Play</span>
								<select name="setting-header_slider_auto">
								';
							foreach($auto_options as $option){
								if($option == $data['setting-header_slider_auto']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}		
			$output .= '
						</select> <small>(auto advance slider, 0 = off)</small>
					</p>
					<p>
					<span class="label">Scroll</span>
								<select name="setting-header_slider_scroll">
								';
							foreach($scroll_options as $option){
								if($option == $data['setting-header_slider_scroll']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}		
			$output .= '
						</select>
					</p>
					<p>
						<span class="label">Speed</span> 
						<select name="setting-header_slider_speed">';
						foreach($speed_options as $name => $val){
							if($data['setting-header_slider_speed'] == $val){
								$output .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$val.'">'.$name.'</option>';	
							}	
						}
			$output .= '</select>
					</p>
					<p>
						<span class="label">Wrap Slides</span> 
						<select name="setting-header_slider_wrap">';
						foreach($wrap_options as $name){
							if($data['setting-header_slider_wrap'] == $name){
								$output .= '<option value="'.$name.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$name.'">'.$name.'</option>';	
							}
						}
			$output .=	'</select>
					</p>
					<hr />
					<p>
						<span class="label">Feature Image Size</span>
						<input type="text" name="setting-header_slider_width" class="width2" value="'.$data['setting-header_slider_width'].'" /> width <small>(in px)</small>
						<input type="text" name="setting-header_slider_height" class="width2" value="'.$data['setting-header_slider_height'].'" /> height <small>(in px)</small>
					</p>
					</div>';		
		return $output;
	}
	
	///////////////////////////////////////////
	// Header Slider Function - Action
	///////////////////////////////////////////
	function themify_header_slider_action($data=array()){
		$data = get_data();
		if($data['setting-header_slider_wrap'] == 'yes'){
			$wrap = "wrap: 'circular',";	
		}
		if($data['setting-header_slider_visible'] == ""){
			$visible = "1";	
		} else {
			$visible = $data['setting-header_slider_visible'];	
		}
		if($data['setting-header_slider_speed'] == ""){
			$speed = "normal";	
		} else {
			$speed = $data['setting-header_slider_speed'];	
		}
		if($data['setting-header_slider_scroll'] == ""){
			$scroll = 1;	
		} else {
			$scroll = $data['setting-header_slider_scroll'];	
		}
		if($data['setting-header_slider_auto'] == ""){
			$auto = 0;	
		} else {
			$auto = $data['setting-header_slider_auto'];	
		}
		?>
		<script type='text/javascript'>
		/////////////////////////////////////////////
		// Slider	 							
		/////////////////////////////////////////////
		jQuery(document).ready(function($){
			jQuery('#header-slider .slides').jcarousel({
				<?php echo $wrap; ?>
				visible: <?php echo $visible; ?>,
				auto: <?php echo $auto; ?>,
				scroll: <?php echo $scroll; ?>,
				animation: <?php echo $speed; ?>,
				initCallback: carousel_callback
			});
		});
		</script>
        <?php
	}
	add_action('wp_footer', 'themify_header_slider_action');
	
	///////////////////////////////////////////
	// Footer Slider Function
	///////////////////////////////////////////
	function themify_footer_slider($data=array()){
		$data = get_data();
		
		if($data['setting-footer_slider_enabled']){
			$enabled_checked = "checked='checked'";	
		} else {
			$enabled_display = "style='display:none;'";	
		}
		if($data['setting-footer_slider_visible'] == "" ||!isset($data['setting-footer_slider_visible'])){
			$data['setting-footer_slider_visible'] = "4";	
		}
		
		if($data['setting-footer_slider_display'] == 'images'){
			$display_images = "checked='checked'";
			$display_posts_display = "style='display:none;'";
		} else {
			$display_posts = "checked='checked'";	
			$display_images_display = "style='display:none;'";
		}
		$title_options = array('','yes','no');
		$auto_options = array(0,1,2,3,4,5,6,7);
		$scroll_options = array(1,2,3,4,5,6,7);
		$display_options = array('none','excerpt','content');
		$speed_options = array("Fast"=>300,"Normal"=>1000,"Slow"=>2000);
		$wrap_options = array("no","yes");
		$image_options = array("one","two","three","four","five","six","seven","eight","nine","ten");
		
		$output .= '<p><span class="label">Slider</span> <input type="checkbox" name="setting-footer_slider_enabled" class="feature_box_enabled_check" '.$enabled_checked.' />  Enable<br />
					<small>Check to enable slider</small>
					</p>
					<div class="feature_box_enabled_display" '.$enabled_display.'>
					
					<p><span class="label">Display</span> <input type="radio" class="feature-box-display" name="setting-footer_slider_display" value="posts" '.$display_posts.' /> Posts <input type="radio" class="feature-box-display" name="setting-footer_slider_display" value="images" '.$display_images.' /> Images</p>
					
					<p class="pushlabel feature_box_posts" '.$display_posts_display.'>';
							$output .= wp_dropdown_categories(array("show_option_all"=>"All Categories","show_option_all"=>"All Categories","hide_empty"=>0,"echo"=>0,"name"=>"setting-footer_slider_posts_category","selected"=>$data['setting-footer_slider_posts_category']));
		$output .=	'	<input type="text" name="setting-footer_slider_posts_slides" value="'.$data['setting-footer_slider_posts_slides'].'" class="width2" /> number of posts to be queried 
					</p>
					
					<p class="feature_box_posts" '.$display_posts_display.'>
						<span class="label">Content Display </span>
								<select name="setting-footer_slider_default_display">
								';
								
								foreach($display_options as $option){
									if($option == $data['setting-footer_slider_default_display']){
										$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
									} else {
										$output .= '<option value="'.$option.'">'.$option.'</option>';
									}
								}
								
			$output .= '
						</select>
					</p>';
					
			$output .= '<p class="feature_box_posts" '.$display_posts_display.'>
						<span class="label">Hide Title</span>
						<select name="setting-footer_slider_hide_title">
						';
						foreach($title_options as $option){
								if($option == $data['setting-footer_slider_hide_title']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}			
		$output .= '
						</select>
					</p>';
					
			$output .= '<div class="feature_box_images" '.$display_images_display.'>';
					
					$x = 0;
					foreach($image_options as $option){
						$x++;
						$output .= '
						<p>
							<span class="label">Title '.$x.'</span>
							<input type="text" class="width10" name="setting-footer_slider_images_'.$option.'_title" value="'.$data['setting-footer_slider_images_'.$option.'_title'].'" />
							<span class="label">Link '.$x.'</span>
							<input type="text" class="width10" name="setting-footer_slider_images_'.$option.'_link" value="'.$data['setting-footer_slider_images_'.$option.'_link'].'" />
							<span class="label">Image '.$x.'</span>
							<input type="text" class="width10 feature_box_img" name="setting-footer_slider_images_'.$option.'_image" value="'.$data['setting-footer_slider_images_'.$option.'_image'].'" /> 
							<span class="pushlabel" style="display:block;"><a href="#" class="upload-btn upload-image simple" id="slider_image_'.$option.'">+ Upload</a></span>
						</p>';
					}
		
		$output .= '</div>
					<hr />
					<p>
						<span class="label">Visible</span> 
						<select name="setting-footer_slider_visible">';
						for($x=1;$x<=7;$x++){
							if($data['setting-footer_slider_visible'] == $x){
								$output .= '<option value="'.$x.'" selected="selected">'.$x.'</option>';	
							} else {
								$output .= '<option value="'.$x.'">'.$x.'</option>';	
							}
						}
			$output .=	'</select> <small>(# of slides visible at the same time)</small>
					</p>
					<p>
					<span class="label">Auto Play</span>
								<select name="setting-footer_slider_auto">
								';
							foreach($auto_options as $option){
								if($option == $data['setting-footer_slider_auto']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}		
			$output .= '
						</select> <small>(auto advance slider, 0 = off)</small>
					</p>
					<p>
					<span class="label">Scroll</span>
								<select name="setting-footer_slider_scroll">
								';
							foreach($scroll_options as $option){
								if($option == $data['setting-footer_slider_scroll']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}		
			$output .= '
						</select>
					</p>
					<p>
						<span class="label">Speed</span> 
						<select name="setting-footer_slider_speed">';
						foreach($speed_options as $name => $val){
							if($data['setting-footer_slider_speed'] == $val){
								$output .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$val.'">'.$name.'</option>';	
							}	
						}
			$output .= '</select>
					</p>
					<p>
						<span class="label">Wrap Slides</span> 
						<select name="setting-footer_slider_wrap">';
						foreach($wrap_options as $name){
							if($data['setting-footer_slider_wrap'] == $name){
								$output .= '<option value="'.$name.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$name.'">'.$name.'</option>';	
							}
						}
			$output .=	'</select>
					</p>
					<hr />
					<p>
						<span class="label">Feature Image Size</span>
						<input type="text" name="setting-footer_slider_width" class="width2" value="'.$data['setting-footer_slider_width'].'" /> width <small>(in px)</small>
						<input type="text" name="setting-footer_slider_height" class="width2" value="'.$data['setting-footer_slider_height'].'" /> height <small>(in px)</small>
					</p>
					</div>';		
		return $output;
	}
	
	///////////////////////////////////////////
	// Footer Slider Function - Action
	///////////////////////////////////////////
	function themify_footer_slider_action($data=array()){
		$data = get_data();
		if($data['setting-footer_slider_wrap'] == 'yes'){
			$wrap = "wrap: 'circular',";	
		}
		if($data['setting-footer_slider_visible'] == ""){
			$visible = "1";	
		} else {
			$visible = $data['setting-footer_slider_visible'];	
		}
		if($data['setting-footer_slider_speed'] == ""){
			$speed = "normal";	
		} else {
			$speed = $data['setting-footer_slider_speed'];	
		}
		if($data['setting-footer_slider_scroll'] == ""){
			$scroll = 1;	
		} else {
			$scroll = $data['setting-footer_slider_scroll'];	
		}
		if($data['setting-footer_slider_auto'] == ""){
			$auto = 0;	
		} else {
			$auto = $data['setting-footer_slider_auto'];	
		}
		?>
		<script type='text/javascript'>
		/////////////////////////////////////////////
		// Slider	 							
		/////////////////////////////////////////////
		jQuery(document).ready(function($){
			jQuery('#footer-slider .slides').jcarousel({
				<?php echo $wrap; ?>
				visible: <?php echo $visible; ?>,
				auto: <?php echo $auto; ?>,
				scroll: <?php echo $scroll; ?>,
				animation: <?php echo $speed; ?>,
				initCallback: carousel_callback
			});
		});
		</script>
        <?php
	}
	add_action('wp_footer', 'themify_footer_slider_action');
	
	///////////////////////////////////////////
	// Footer Widgets Function
	///////////////////////////////////////////
	function themify_footer_widgets($data=array()){
		$data = get_data();
		$options = array(
						 array("value" => "footerwidget-4col", 			"img" => "images/layout-icons/widget-4col.png"),
						 array("value" => "footerwidget-3col", 			"img" => "images/layout-icons/widget-3col.png", "selected" => true),
						 array("value" => "footerwidget-2col", 			"img" => "images/layout-icons/widget-2col.png"),
						 array("value" => "footerwidget-1col",			"img" => "images/layout-icons/widget-1col.png"),
						 array("value" => "none",					"img" => "images/layout-icons/none.png")
						 );
		$val = $data['setting-footer_widgets'];
		$output = "<p>
					<span class='label'>Layout</span>
					";
		foreach($options as $option){
			if(($val == "" || !$val || !isset($val)) && $option['selected']){ 
				$val = $option['value'];
			}
			if($val == $option['value']){ 
				$class = "selected";
			} else {
				$class = "";	
			}
			$output .= '
					<a href="#" class="preview-icon '.$class.'"><img src="'.get_bloginfo('template_directory').'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';	
		}
		
		$output .= '<input type="hidden" name="setting-footer_widgets" class="val" value="'.$val.'" /></p>';
		
		return $output;
	}

	///////////////////////////////////////////
	// Exclude RSS
	///////////////////////////////////////////
	function themify_exclude_rss($data=array()){
		$data = get_data();
		if($data['setting-exclude_rss']){
			$pages_checked = "checked='checked'";	
		}
		return '<p><input type="checkbox" name="setting-exclude_rss" '.$pages_checked.'/> Check here to exclude RSS icon/button</p>';	
	}

	///////////////////////////////////////////
	// Exclude Search Form
	///////////////////////////////////////////
	function themify_exclude_search_form($data=array()){
		$data = get_data();
		if($data['setting-exclude_search_form']){
			$pages_checked = "checked='checked'";	
		}
		return '<p><input type="checkbox" name="setting-exclude_search_form" '.$pages_checked.'/> Check here to exclude search form</p>';	
	}
	
	///////////////////////////////////////////
	// Default Page Layout Module - Action
	///////////////////////////////////////////
	function themify_default_page_layout($data=array()){
		$data = get_data();
		
		$options = array(
								array("value" => "sidebar2", 	"img" => "images/layout-icons/sidebar2.png", "selected" => true),
								array("value" => "sidebar2 content-left", 	"img" => "images/layout-icons/sidebar2-content-left.png"),
								array("value" => "sidebar2 content-right", 	"img" => "images/layout-icons/sidebar2-content-right.png"),
								array("value" => "sidebar1", 	"img" => "images/layout-icons/sidebar1.png"),
								array("value" => "sidebar1 sidebar-left", 	"img" => "images/layout-icons/sidebar1-left.png"),
								array("value" => "sidebar-none",	 	"img" => "images/layout-icons/sidebar-none.png")
								);
		
		$default_options = array(
								array('name'=>'','value'=>''),
								array('name'=>'Yes','value'=>'yes'),
								array('name'=>'No','value'=>'no')
								);
							 
		$val = $data['setting-default_page_layout'];
		
		$output .= '<p>
						<span class="label">Page Sidebar Option</span>';
		foreach($options as $option){
			if(($val == "" || !$val || !isset($val)) && $option['selected']){ 
				$val = $option['value'];
			}
			if($val == $option['value']){ 
				$class = "selected";
			} else {
				$class = "";	
			}
			$output .= '<a href="#" class="preview-icon '.$class.'"><img src="'.get_bloginfo('template_directory').'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';	
		}
		$output .= '<input type="hidden" name="setting-default_page_layout" class="val" value="'.$val.'" /></p>';
		$output .= '<p>
						<span class="label">Hide Title in All Pages</span>
						
						<select name="setting-hide_page_title">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-hide_page_title']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
						
						
		$output .=	'</select>
					</p>';
		if($data['setting-comments_pages']){
			$pages_checked = "checked='checked'";	
		}
		$output .= '<p><span class="label">Page Comments</span><input type="checkbox" name="setting-comments_pages" '.$pages_checked.' /> Disable comments in all Pages</p>';	
		
		return $output;													 
	}
	
	///////////////////////////////////////////
	// Default Index Layout Module - Action
	///////////////////////////////////////////
	function themify_default_layout($data=array()){
		$data = get_data();
		
		if($data['setting-default_more_text'] == ""){
			$more_text = "More";
		} else {
			$more_text = $data['setting-default_more_text'];
		}
		
		$default_options = array(
								array('name'=>'','value'=>''),
								array('name'=>'Yes','value'=>'yes'),
								array('name'=>'No','value'=>'no')
								);
		$default_layout_options = array(
								array('name'=>'Content','value'=>'content'),
								array('name'=>'Excerpt','value'=>'excerpt'),
								array('name'=>'None','value'=>'none')
								);	
		$default_post_layout_options = array(
												 array("value" => "list-post", "img" => "images/layout-icons/list-post.png", "selected" => true),
												 array("value" => "grid4", "img" => "images/layout-icons/grid4.png"),
												 array("value" => "grid3", "img" => "images/layout-icons/grid3.png"),
												 array("value" => "grid2", "img" => "images/layout-icons/grid2.png"),
												 array("value" => "list-large-image", "img" => "images/layout-icons/list-large-image.png"),
												 array("value" => "list-thumb-image", "img" => "images/layout-icons/list-thumb-image.png"),
												 array("value" => "grid2-thumb", "img" => "images/layout-icons/grid2-thumb.png")
												 );
																 	 
		$options = array(
							array("value" => "sidebar2", 	"img" => "images/layout-icons/sidebar2.png", "selected" => true),
							array("value" => "sidebar2 content-left", 	"img" => "images/layout-icons/sidebar2-content-left.png"),
							array("value" => "sidebar2 content-right", 	"img" => "images/layout-icons/sidebar2-content-right.png"),
							array("value" => "sidebar1", 	"img" => "images/layout-icons/sidebar1.png"),
							array("value" => "sidebar1 sidebar-left", 	"img" => "images/layout-icons/sidebar1-left.png"),
							array("value" => "sidebar-none",	 	"img" => "images/layout-icons/sidebar-none.png")
							);
						 
		$val = $data['setting-default_layout'];
		
		$output = "";
		
		$output .= '<p>
						<span class="label">Index Sidebar Option</span>';
		foreach($options as $option){
			if(($val == "" || !$val || !isset($val)) && $option['selected']){ 
				$val = $option['value'];
			}
			if($val == $option['value']){ 
				$class = "selected";
			} else {
				$class = "";	
			}
			$output .= '<a href="#" class="preview-icon '.$class.'"><img src="'.get_bloginfo('template_directory').'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';	
		}
		
		$output .= '<input type="hidden" name="setting-default_layout" class="val" value="'.$val.'" />';
		$output .= '</p>';
		$output .= '<p>
						<span class="label">Post Layout</span>';
						
		$val = $data['setting-default_post_layout'];
		
		foreach($default_post_layout_options as $option){
			if(($val == "" || !$val || !isset($val)) && $option['selected']){ 
				$val = $option['value'];
			}
			if($val == $option['value']){ 
				$class = "selected";
			} else {
				$class = "";	
			}
			$output .= '<a href="#" class="preview-icon '.$class.'"><img src="'.get_bloginfo('template_directory').'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';	
		}
		
		$output .= '<input type="hidden" name="setting-default_post_layout" class="val" value="'.$val.'" />
					</p>
					<p>
						<span class="label">Content Display</span>  
						<select name="setting-default_layout_display">';
						foreach($default_layout_options as $layout_option){
							if($layout_option['value'] == $data['setting-default_layout_display']){
								$output .= '<option selected="selected" value="'.$layout_option['value'].'">'.$layout_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$layout_option['value'].'">'.$layout_option['name'].'</option>';
							}
						}
		$output .=	'	</select>
					</p>
					<p>
						<span class="label">Query Categories</span>  
						<input type="text" name="setting-default_query_cats" value="'.$data['setting-default_query_cats'].'"><br />
						<span class="pushlabel"><small>Use minus sign (-) to exclude categories.</small></span><br />
						<span class="pushlabel"><small>Example: "1,4,-7" = only include Category 1, 4, and exclude Category 7.</small></span>
					</p>
					<p>
						<span class="label">More Text</span>
						<input type="text" name="setting-default_more_text" value="'.$more_text.'"><br />
						<span class="pushlabel"><small>Note: more text is only available if display=content and the post has the <a href="http://themify.me/docs/more-tag" target="_blank">more tag</a></small></span>
					</p>
					<p>
						<span class="label">Hide Post Title</span>
						
						<select name="setting-default_post_title">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_post_title']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Unlink Post Title</span>
						
						<select name="setting-default_unlink_post_title">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_unlink_post_title']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Hide Post Meta</span>
						
						<select name="setting-default_post_meta">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_post_meta']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Hide Post Date</span>
						
						<select name="setting-default_post_date">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_post_date']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Hide Post Image</span>
						
						<select name="setting-default_post_image">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_post_image']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Unlink Post Image</span>
						
						<select name="setting-default_unlink_post_image">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_unlink_post_image']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>';
		
		$data = get_data();
		$options = array("left","right");
		
		if($data['setting-post_image_single_disabled']){
			$checked = 'checked="checked"';
		}
		
		$output .= '<p>
						<span class="label">Image size</span>  
						<input type="text" class="width2" name="setting-image_post_width" value="'.$data['setting-image_post_width'].'" /> width <small>(px)</small>  
						<input type="text" class="width2" name="setting-image_post_height" value="'.$data['setting-image_post_height'].'" /> height <small>(px)</small>
					</p>
					<p>
						<span class="label">Image alignment</span>
						<select name="setting-image_post_align">
							<option></option>';
		foreach($options as $option){
			if($option == $data['setting-image_post_align']){
				$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
			} else {
				$output .= '<option value="'.$option.'">'.$option.'</option>';
			}
		}
		$output .=	'</select>
					</p>
					';
		return $output;
	}
	
	///////////////////////////////////////////
	// Default Post Layout
	///////////////////////////////////////////
	function themify_default_post_layout($data=array()){
		
		$data = get_data();
		
		$default_options = array(
								array('name'=>'','value'=>''),
								array('name'=>'Yes','value'=>'yes'),
								array('name'=>'No','value'=>'no')
								);
		
		$val = $data['setting-default_page_post_layout'];

		$output .= '<p>
						<span class="label">Post Sidebar Option</span>';
						
		$options = array(
						array("value" => "sidebar2", 	"img" => "images/layout-icons/sidebar2.png", "selected" => true),
						array("value" => "sidebar2 content-left", 	"img" => "images/layout-icons/sidebar2-content-left.png"),
						array("value" => "sidebar2 content-right", 	"img" => "images/layout-icons/sidebar2-content-right.png"),
						array("value" => "sidebar1", 	"img" => "images/layout-icons/sidebar1.png"),
						array("value" => "sidebar1 sidebar-left", 	"img" => "images/layout-icons/sidebar1-left.png"),
						array("value" => "sidebar-none",	 	"img" => "images/layout-icons/sidebar-none.png")
						);
										
		foreach($options as $option){
			if(($val == "" || !$val || !isset($val)) && $option['selected']){ 
				$val = $option['value'];
			}
			if($val == $option['value']){ 
				$class = "selected";
			} else {
				$class = "";	
			}
			$output .= '<a href="#" class="preview-icon '.$class.'"><img src="'.get_bloginfo('template_directory').'/'.$option['img'].'" alt="'.$option['value'].'"  /></a>';	
		}
		
		$output .= '<input type="hidden" name="setting-default_page_post_layout" class="val" value="'.$val.'" />';
		$output .= '</p>
					<p>
						<span class="label">Hide Post Title</span>
						
						<select name="setting-default_page_post_title">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_page_post_title']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Unlink Post Title</span>
						
						<select name="setting-default_page_unlink_post_title">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_page_unlink_post_title']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Hide Post Meta</span>
						
						<select name="setting-default_page_post_meta">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_page_post_meta']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Hide Post Date</span>
						
						<select name="setting-default_page_post_date">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_page_post_date']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p>
					<p>
						<span class="label">Hide Post Image</span>
						
						<select name="setting-default_page_post_image">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_page_post_image']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p><p>
						<span class="label">Unlink Post Image</span>
						
						<select name="setting-default_page_unlink_post_image">';
						foreach($default_options as $title_option){
							if($title_option['value'] == $data['setting-default_page_unlink_post_image']){
								$output .= '<option selected="selected" value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							} else {
								$output .= '<option value="'.$title_option['value'].'">'.$title_option['name'].'</option>';
							}
						}
		$output .=	'</select>
					</p><p>
						<span class="label">Image size</span>  
						<input type="text" class="width2" name="setting-image_post_single_width" value="'.$data['setting-image_post_single_width'].'" /> width <small>(px)</small>  
						<input type="text" class="width2" name="setting-image_post_single_height" value="'.$data['setting-image_post_single_height'].'" /> height <small>(px)</small>
					</p>
					<p>
						<span class="label">Image alignment</span>
						<select name="setting-image_post_single_align">
							<option></option>';
		$options = array("left","right");
		foreach($options as $option){
			if($option == $data['setting-image_post_single_align']){
				$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
			} else {
				$output .= '<option value="'.$option.'">'.$option.'</option>';
			}
		}
		$output .=	'</select>
					</p>';
		if($data['setting-comments_posts']){
			$comments_posts_checked = "checked='checked'";	
		}
		$output .= '<p><span class="label">Post Comments</span><input type="checkbox" name="setting-comments_posts" '.$comments_posts_checked.' /> Disable comments in all Posts</p>';	
		
		if($data['setting-post_author_box']){
			$author_box_checked = "checked='checked'";	
		}
		$output .= '<p><span class="label">Show Author Box</span><input type="checkbox" name="setting-post_author_box" '.$author_box_checked.' /> Show author box in all Posts</p>';	

		return $output;
	}


?>