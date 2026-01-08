<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    if ( ! class_exists( 'VS_Slider_Shortcode' ) ) {
        class VS_Slider_Shortcode {

            public function __construct()
            {
                add_shortcode( 'vs_slider', array( $this, 'add_shortcode' ) );
            }

            public function add_shortcode( $atts = array(), $content = null, $tag = '' ) {

                $atts = array_change_key_case( (array) $atts, CASE_LOWER );

                extract(shortcode_atts(
                    array(
                        'id' => '',
                        'orderby' => 'date'
                    ),
                    $atts,
                    $tag
                ));

                if ( !empty( $id)) {

                    $id = array_map( 'absint', explode( ',', $id ) );
                    
                }

            }

        }
    }