<?php

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

    if ( ! class_exists( 'VS_Slider_Settings' ) ) {
        class VS_Slider_Settings {

            public static $options;

            public function __construct() 
            {
                self::$options = get_option('vs_slider_options');
                add_action('admin_init', array( $this, 'admin_init' ));
            }

            public function admin_init() 
            {

                register_setting(
                    'vs_slider_group',
                    'vs_slider_options'
                );

                add_settings_section(
                    'vs_slider_main_section',
                    'How does it work?',
                    null,
                    'vs-slider-page1'
                );

                add_settings_section(
                    'vs_slider_second_section',
                    'Other Plugin Options',
                    null,
                    'vs-slider-page2'
                );

                add_settings_field(
                    'vs_slider_shortcode',
                    'Shortcode',
                    array( $this, 'vs_slider_shortcode_callBack' ),
                    'vs-slider-page1',
                    'vs_slider_main_section'
                );

                add_settings_field(
                    'vs_slider_title',
                    'Slider Title',
                    array( $this, 'vs_slider_title_callBack' ),
                    'vs-slider-page2',
                    'vs_slider_second_section'
                );

                add_settings_field(
                    'vs_slider_bullets',
                    'Display Bullets',
                    array( $this, 'vs_slider_bullets_callBack' ),
                    'vs-slider-page2',
                    'vs_slider_second_section'
                );

                add_settings_field(
                    'vs_slider_style',
                    'Slider Style',
                    array( $this, 'vs_slider_style_callBack' ),
                    'vs-slider-page2',
                    'vs_slider_second_section'
                );

            }

            public function vs_slider_shortcode_callBack()
            { ?>

                <span>Use the shortcode <strong>[vs_slider]</strong> to display the slider in any page/post/widget</span>

            <?php
            }

            public function vs_slider_title_callBack()
            {?>
                <input 
                    type="text" 
                    name="vs_slider_options[vs_slider_title]" 
                    id="vs_slider_title"
                    value="<?= isset(self::$options['vs_slider_title']) ? esc_attr(self::$options['vs_slider_title']) : ''; ?>"
                >
            <?php
            }

            public function vs_slider_bullets_callBack()
            {?>
                <input 
                    type="checkbox" 
                    name="vs_slider_options[vs_slider_bullets]" 
                    id="vs_slider_bullets"
                    value="1"
                    <?php 
                        if (isset(self::$options['vs_slider_bullets'])) {
                            checked(1, self::$options['vs_slider_bullets'], true);
                        }
                    ?>
                >
            <?php
            }

            public function vs_slider_style_callBack()
            {?>

                <select
                    name="vs_slider_options[vs_slider_style]" 
                    id="vs_slider_style"
                >
                    <option value="style-1"
                        <?php isset(self::$options['vs_slider_style']) ? selected('style-1', self::$options['vs_slider_style'],true) : ''; ?>
                    >Style 1</option>
                    <option value="style-2"
                        <?php isset(self::$options['vs_slider_style']) ? selected('style-2', self::$options['vs_slider_style'],true) : ''; ?>
                    >Style 2</option>
                </select>                    

            <?php
            }
        }
    }   