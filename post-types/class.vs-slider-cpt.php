<?

    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }

    if ( ! class_exists( 'VS_Slider_Post_Type' ) ) {
        class VS_Slider_Post_Type {

            public function __construct() {

                add_action( 'init', array( $this, 'create_post_type' ) );
                add_action( 'add_meta_boxes', array($this, 'add_meta_boxes' ) );
                add_action( 'save_post', array( $this, 'save_post'), 10, 2 );

            }

            public function create_post_type () {

                register_post_type(
                    'vs-slider',
                    array(
                        'label' => 'Slider',
                        'description' => 'Custom Post Type for Sliders',
                        'labels' => array(
                            'name' => 'Sliders',
                            'singular_name' => 'Slider'
                        ),
                        'public' => true,
                        'supports' => array( 'title', 'editor', 'thumbnail' ),   
                        'herearchial' => false,   
                        'show_ui' => true,
                        'show_in_menu' => true,
                        'menu_position' => 5,
                        'show_in_admin_bar' => true,
                        'show_in_nav_menus' => true,
                        'can_export' => true,
                        'has_archive' => false,
                        'exclude_from_search' => false,
                        'publicly_queryable' => true,
                        'show_in_rest' => true,
                        'menu_icon' => 'dashicons-images-alt2',
                        //'register_meta_box_cd' => array( $this, 'add_meta_boxes' ),
                    )
                );

            }
            
            public function add_meta_boxes() {
                add_meta_box (
                    'vs_slider_meta_box',
                    'Link Options',
                    array( $this, 'add_inner_meta_box' ),
                    'vs-slider',
                    'normal',
                    'high'
                );
            }
            
            public function add_inner_meta_box($post) {
                require_once( VS_SLIDER_PATH . 'views/vs-slider_metabox.php' );
            }

            public function save_post( $post_id ) {

                if ( isset($_POST['action']) && $_POST['action'] === 'editpost' ) {

                    $old_link_text = get_post_meta( $post_id, 'vs-slider_link_text', true );
                    $new_link_text = sanitize_text_field( $_POST['vs-slider_link_text'] );
                    $old_link_url = get_post_meta( $post_id, 'vs-slider_link_url', true );
                    $new_link_url = sanitize_text_field( $_POST['vs-slider_link_url'] );

                    update_post_meta( $post_id, 'vs-slider_link_text', $new_link_text, $old_link_text );
                    update_post_meta( $post_id, 'vs-slider_link_url', $new_link_url, $old_link_url );
                }

            }
        }
    }