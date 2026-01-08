<?php 

    /** 
    *  Plugin Name: VS Slider
    *  Plugin URI: https://example.com/vs-slider
    *  Description: A simple slider plugin for WordPress.
    *  Version: 1.0.0
    *  Requires at least: 5.6
    *  Author: Vasily Shatalkin 
    *  Author URI: https://example.com
    *  License: GPL2 of later
    *  License URI: https://www.gnu.org/licenses/gpl-2.0.html
    *  Text Domain: vs-slider
    *  Domain Path: /languages
    */

    /*
        VS Slider is free software: you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation, either version 2 of the License, or
        any later version.

        VS Slider is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with VS Slider. If not, see {URI to Plugin License}.
    */

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    if ( ! class_exists( 'VS_Slider' ) ) {
        class VS_Slider {

            public function __construct() {

                $this->define_constants();

                add_action('admin_menu', array( $this, 'add_menu'));

                require_once( VS_SLIDER_PATH . 'post-types/class.vs-slider-cpt.php' );
                $VS_Slider_Post_Type = new VS_Slider_Post_Type();

                require_once( VS_SLIDER_PATH . 'class.vs-slider-settings.php' );
                $VS_Slider_Settings = new VS_Slider_Settings();

                require_once( VS_SLIDER_PATH . 'shortcodes/class.vs-slider-shortcode.php' );
                $VS_Slider_Shortcode = new VS_Slider_Shortcode();

            }

            public function define_constants() {

                define( 'VS_SLIDER_PATH', plugin_dir_path( __FILE__ ));
                define( 'VS_SLIDER_URL', plugin_dir_url( __FILE__ ));
                define( 'VS_SLIDER_VERSION', '1.0.0' );

            }

            public static function activate() {
                
                //flush_rewrite_rules();
                update_option('rewrite_rules', ''); // This method is similar to the function above, but the course author (Marcelo Xavier Vieira) claims that it works better.

            }

            public static function deactivate() {
                flush_rewrite_rules();
                unregister_post_type( 'vs-slider' );
            }    

            public static function uninstall() {
                // Uninstallation code here...
            }

            public function add_menu() {
                add_menu_page( // add_theme_page // add_options_page
                    'VS Slider Options',
                    'VS Slider',
                    'manage_options',
                    'vs-slider-admin',
                    array( $this, 'vs_slider_settings_page' ),
                    'dashicons-images-alt2',
                    10
                );

                add_submenu_page(
                    'vs-slider-admin', // 'edit-comments.php' Example of existing parent slug
                    'Manage Slides',
                    'Manage Slides',
                    'manage_options',
                    'edit.php?post_type=vs-slider',
                    null,
                    null
                );

                add_submenu_page(
                    'vs-slider-admin',
                    'Add New Slide',
                    'Add New Slide',
                    'manage_options',
                    'post-new.php?post_type=vs-slider',
                    null,
                    null
                );
            }

            public function vs_slider_settings_page() {

                    if ( ! current_user_can( 'manage_options' ) ) {
                        return;
                    }
                    if ( isset( $_GET['settings-updated'] ) ) {
                        add_settings_error( 'vs_slider_options', 'vs_slider_message', 'Settings Saved', 'updated' );
                    }
                    settings_errors( 'vs_slider_options' );
                    require_once( VS_SLIDER_PATH . 'views/settings-page.php' );

            }

        }
    }

    if ( class_exists( 'VS_Slider' ) ) {

        register_activation_hook( __FILE__, array( 'VS_Slider', 'activate' ) );
        register_deactivation_hook( __FILE__, array( 'VS_Slider', 'deactivate' ) );
        register_uninstall_hook( __FILE__, array( 'VS_Slider', 'uninstall' ) );

        $vs_slider = new VS_Slider();

    }
    