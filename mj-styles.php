<?php
/*
* Plugin Name: MJ Custom Styles
* Plugin URI: #
* Description: This plugin allows you to add your own styles to a wordpress website. You can also use it to override themes and plugins styles.
* Author: John Olawale
* Author URI: http://mobb.com.ng
* Version: 1.0
* Text Domain: mj-s

MJ Custom Styles is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

MJ Custom Styles is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with MJ Custom Styles. If not, see http://www.mobb.com.ng
*/

// Block direct file access
if( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'MJS_FILE', __FILE__ );

if( ! is_admin() ) {
	require_once dirname( MJS_FILE ) . '/inc/frontend.php';
} elseif( ! defined( 'DOING_AJAX' ) ) {
	require_once dirname( MJS_FILE ) . '/inc/admin.php';
}
