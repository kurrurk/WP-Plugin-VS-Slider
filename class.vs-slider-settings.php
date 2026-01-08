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
                    'vs_slider_options',
                    array($this, 'vs_slider_validate')
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
                    'vs_slider_second_section',
                    array(
                        'label_for' => 'vs_slider_title'
                    )
                );

                add_settings_field(
                    'vs_slider_bullets',
                    'Display Bullets',
                    array( $this, 'vs_slider_bullets_callBack' ),
                    'vs-slider-page2',
                    'vs_slider_second_section',
                    array(
                        'label_for' => 'vs_slider_bullets'
                    )
                );

                add_settings_field(
                    'vs_slider_style',
                    'Slider Style',
                    array( $this, 'vs_slider_style_callBack' ),
                    'vs-slider-page2',
                    'vs_slider_second_section',
                    array(
                        'items' => array(
                            'style-1' => 'Style 1',
                            'style-2' => 'Style 2'
                        ),
                        'label_for' => 'vs_slider_style'
                    )
                );

            }

            public function vs_slider_shortcode_callBack()
            { ?>

                <span>Use the shortcode <strong>[vs_slider]</strong> to display the slider in any page/post/widget</span>

            <?php
            }

            public function vs_slider_title_callBack( $args )
            {?>
                <input 
                    type="text" 
                    name="vs_slider_options[vs_slider_title]" 
                    id="vs_slider_title"
                    value="<?= isset(self::$options['vs_slider_title']) ? esc_attr(self::$options['vs_slider_title']) : ''; ?>"
                >
            <?php
            }

            public function vs_slider_bullets_callBack( $args )
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

            public function vs_slider_style_callBack( $args )
            {?>

                <select
                    name="vs_slider_options[vs_slider_style]" 
                    id="vs_slider_style"
                >
                    <?php foreach( $args['items'] as $style => $label ) : ?>
                        <option value="<?= esc_attr( $style ); ?>"
                            <?php isset(self::$options['vs_slider_style']) ? selected($style, self::$options['vs_slider_style'],true) : ''; ?>
                        ><?= esc_html( $label ); ?></option>
                    <?php endforeach; ?>
                </select>                    

            <?php
            }

            public function vs_slider_validate( $input )  
            {

                $new_input = array();

                foreach ( $input as $key => $value) {

                    $new_input[$key] = sanitize_text_field( $value );

                    switch ($key) {
                        case 'vs_slider_title':
                            if ( empty( $value ) ) {
                                $value = 'Please, type some text.';
                            }
                            $new_input[$key] = sanitize_text_field( $value );
                            break;
                        // case 'vs_slider_url':
                        //     $new_input[$key] = esc_url_raw( $value );
                        //     break;
                        // case 'vs_slider_int':
                        //     $new_input[$key] = absint( $value );
                        //     break;
                        default:
                            $new_input[$key] = sanitize_text_field( $value );
                            break;
                    }

                }

                return $new_input;

            }
        }
    }   