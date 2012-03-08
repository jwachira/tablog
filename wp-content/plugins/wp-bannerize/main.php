<?php
/**
 * Plugin Name: WP Bannerize
 * Plugin URI: http://www.saidmade.com/prodotti/wordpress/wp-bannerize/
 * Description: WP Bannerize is an Amazing Banner Manager. For more info and plugins visit <a href="http://www.saidmade.com">Saidmade</a>.
 * Version: 3.0.50
 * Author: Giovambattista Fazioli
 * Author URI: http://www.undolog.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   WP Bannerize
 * @version   3.0.50
 * @author    =undo= <g.fazioli@undolog.com>
 * @copyright Copyright (c) 2008-2012, Saidmade, srl
 * @link      http://www.saidmade.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 */

require_once( 'main.h.php' );
require_once( 'Classes/wpBannerizeClass.php' );

if ( @isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
	require_once( 'Classes/wpBannerizeAdmin.php' );
	$wpBannerizeAdmin = new WPBannerizeAdmin( __FILE__ );
	require_once( 'Classes/wpBannerizeAjax.php' );
} else {
	if ( is_admin() ) {
		require_once( 'Classes/wpBannerizeAdmin.php' );
		//
		$wpBannerizeAdmin = new WPBannerizeAdmin( __FILE__ );
		$wpBannerizeAdmin->register_plugin_settings( __FILE__ );
		register_activation_hook( __FILE__, array ( &$wpBannerizeAdmin, 'pluginDidActive' ) );
		register_activation_hook( __FILE__, array ( &$wpBannerizeAdmin, 'pluginDidDeactive' ) );
	} else {
		require_once( 'Classes/wpBannerizeFrontend.php' );
		$wpBannerizeFrontend = new WPBannerizeFrontend( __FILE__ );
		require_once( 'Classes/wpBannerizeFunctions.php' );
	}
}