<?php if(themify_check('setting-header_slider_enabled')){ ?>
	<div id="header-slider" class="pagewidth slider">
			
		<ul class="slides clearfix">

    		<?php 
			if(themify_check('setting-header_slider_posts_category')){
				$cat = "&cat=".themify_get('setting-header_slider_posts_category');	
			} else {
				$cat = "";
			}
			if(themify_check('setting-header_slider_posts_slides')){
				$num_posts = "showposts=".themify_get('setting-header_slider_posts_slides')."&";
			} else {
				$num_posts = "showposts=5&";	
			}
			if(themify_check('setting-header_slider_display') && themify_get('setting-header_slider_display') == "images"){ 
        		
				$options = array("one","two","three","four","five","six","seven","eight","nine","ten");
				foreach($options as $option){
					if(themify_check('setting-header_slider_images_'.$option.'_image')){
						echo '<li>';
							if(themify_check('setting-header_slider_images_'.$option.'_link')){ 
								
								$title = (themify_check('setting-header_slider_images_'.$option.'_title')) ? '<div class="slide-content-wrap"><h3 class="slide-post-title">'.themify_get('setting-header_slider_images_'.$option.'_title').'</h3></div>' : '';
								$link = themify_get('setting-header_slider_images_'.$option.'_link');
								$image = themify_get('setting-header_slider_images_'.$option.'_image');
								echo $title;
								themify_image("src=".$image."&setting=slider&w=990&h=420&before=<a href='".urlencode($link)."' title='".urlencode($link)."'>&after=</a>&alt=".urlencode($link)."&class=feature-img");
								
							} else {
								
								$image = themify_get('setting-header_slider_images_'.$option.'_image');
								themify_image("src=".$image."&setting=slider&w=990&h=420&alt=".$image."&class=feature-img");
							}
						echo '</li>';
					}
				}
			} else { 

				
				query_posts($num_posts.$cat); 
				
				if( have_posts() ) {
					
					while ( have_posts() ) : the_post();
						?>                

					<?php if ( themify_get('external_link') != ''): ?>
						<?php $link = themify_get("external_link"); ?>
					<?php elseif ( themify_get('lightbox_link') != ''): ?>
						<?php $link = themify_get("lightbox_link")."' class='lightbox' rel='prettyPhoto[slider]"; ?>
					<?php else: ?>
						<?php $link = get_permalink(); ?>
					<?php endif; ?>

                    	<li>

							<div class="slide-feature-image">
								<a href='<?php echo $link; ?>'>
									<?php themify_image("field_name=feature_image, post_image, image, wp_thumb&ignore=true&setting=slider&w=990&h=420"); ?>
								</a>	
							</div>
							<!-- /.slide-feature-image -->

							<div class="slide-content-wrap">
								<?php if(themify_get('setting-header_slider_hide_title') != 'yes'): ?>
									<h3 class="slide-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php endif; ?>
								
									<?php if(themify_get('setting-header_slider_default_display') == 'content'): ?>
										<div class="slide-excerpt">
										<?php the_content(); ?>
										</div>
									<?php elseif(themify_get('setting-header_slider_default_display') == 'none'): ?>
											<?php //none ?>
									<?php else: ?>
										<div class="slide-excerpt">
										<?php the_excerpt(); ?>
										</div>
									<?php endif; ?>
									
							</div>
							<!-- /.slide-content-wrap -->
                        	
                 		</li>
               			<?php 
					endwhile; 
				}
				
				wp_reset_query();
				
			} 
			?>
		</ul>
	  
	</div>
	<!-- /#slider -->
<?php } ?>