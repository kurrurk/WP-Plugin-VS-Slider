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

            }

            public function define_constants() {

                define( 'VS_SLIDER_PATH', plugin_dir_path( __FILE__ ));
                define( 'VS_SLIDER_URL', plugin_dir_url( __FILE__ ));
                define( 'VS_SLIDER_VERSION', '1.0.0' );

            }

        }
    }

    if ( class_exists( 'VS_Slider' ) ) {
        $vs_slider = new VS_Slider();
    }
    