<?php
/**
 *
"Login Redirect for WordPress" is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

"Login Redirect for WordPress" is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with "Login Redirect for WordPress". If not, see https://www.gnu.org/licenses/gpl-3.0.html.
 *
 * Plugin Name: Login Redirect for WordPress
 * Description: A simple plugin for setting up redirection after the log in.
 * Version: 1.0
 * Author: Ivan Hanák <kontakt@hanakivan.sk>
 * Author URI: https://hanakivan.sk
 * Text Domain: tutor
 * Requires at least: 3.0
 * Requires PHP: 5.6
 */

const LRFW_PLUGIN_NAME = "Login Redirect For WordPress";
const LRFW_SLUG = "login-redirect-for-wordpress";

const LRFW_OPTIONS_NAME = "lrfw_plugin_options";

if(is_admin()) {
	require_once dirname(__FILE__)."/settings-page.php";
}

/**
 * Special thanks to: https://developer.wordpress.org/reference/hooks/login_redirect/#comment-2074
 */
function lrfw_callback( $redirect_to, $request, $user ) {
	$options = get_option( LRFW_OPTIONS_NAME );

	if(!is_array($options)) {
		$options = [];
	}

	if(!empty($options["login_redirect_uri"])) {
		return $options["login_redirect_uri"];
	}

	return $redirect_to;
}

add_filter( 'login_redirect', 'lrfw_callback', 10, 3 );