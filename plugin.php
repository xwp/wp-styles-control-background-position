<?php
/**
 * Plugin Name: Styles Control: background-position
 * Plugin URI: https://github.com/xwp/wp-styles-control-background-position
 * Description: Extension for Styles plugin to add a background-position control type
 * Version: 0.1
 * Author: XWP
 * Author URI: https://xwp.co
 */

/**
 * Copyright (c) 2013 XWP. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

/**
 * Example JSON usage:
 *     { "type": "background-position", "label": "Wallpaper orientation" },
 */
class Styles_Control_Background_Position_Plugin {

	/**
	 * Version of the plugin. Used to cache-bust enqueued scripts and styles.
	 */
	const VERSION = '0.1';

	static public function setup() {
		if ( ! class_exists( 'Styles_Plugin' ) ) {
			error_log( 'Aborting setup. Styles is not loaded?' );
			return;
		}
		add_action( 'customize_register', array( __CLASS__, 'customize_register' ), 5 );
		add_action( 'customize_controls_enqueue_scripts',  array( __CLASS__, 'customize_controls_enqueue_scripts' ) );
	}

	/**
	 * Include the class to make available to Styles.
	 * Styles looks for class "Styles_Control_Foo_Bar"
	 * when presented with { type: "foo-bar" } in customize.json
	 */
	static public function customize_register(){
		include dirname( __FILE__ ) . '/inc/styles-control-background-position.php';
	}

	/**
	 * Supporting CSS or Javascript for use in WordPress Customizer
	 */
	static function customize_controls_enqueue_scripts() {
		wp_enqueue_style( 'styles-control-background-position', plugins_url( '/inc/styles-control-background-position.css', __FILE__ ), array(), self::VERSION );
		wp_enqueue_script( 'styles-control-background-position', plugins_url( '/inc/styles-control-background-position.js', __FILE__ ), array( 'jquery', 'customize-base' ), self::VERSION );
	}
}
add_action( 'plugins_loaded', array( 'Styles_Control_Background_Position_Plugin', 'setup' ), 100 );
