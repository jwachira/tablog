<aside id="sidebar">

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_Wide') ) : ?>

		<div class="widget">
			<h4 class="widgettitle"><?php _e('Pages','themify'); ?></h4>
			<ul>
			<?php wp_list_pages('title_li=' ); ?>
			</ul>
		</div>

		<div class="widget">
			<h4 class="widgettitle"><?php _e('Category','themify'); ?></h4>
			<ul>
			<?php wp_list_categories('show_count=1&title_li='); ?>
			</ul>
		</div>

	<?php endif; ?>

	<div class="clearfix">
		<div class="secondary">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_Wide_2A') ); ?>
		</div>
		<div class="secondary last">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_Wide_2B') ); ?>
		</div>
	</div>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar_Wide_3') ); ?>

</aside>
<!-- /#sidebar -->
