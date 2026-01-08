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
                add_filter( 'manage_vs-slider_posts_columns', array( $this, 'vs_slider_cpt_columns' ));
                add_action( 'manage_vs-slider_posts_custom_column', array( $this, 'vs_slider_custom_columns' ), 10, 2 );
                add_filter( 'manage_edit-vs-slider_sortable_columns', array( $this, 'vs_slider_sortable_columns' ) );

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

                if ( ! isset( $_POST['vs-slider_nonce'] )) {

                    if (! wp_verify_nonce( $_POST['vs-slider_nonce'], 'vs-slider_nonce' ) ) {
                        return;
                    }

                } 

                if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                    return;
                }

                if ( isset($_POST['post_type']) && $_POST['post_type'] != 'vs-slider' ) {
                    if ( ! current_user_can( 'edit_page', $post_id ) ) {
                        return;
                    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
                        return;
                    }
                }

                if ( isset($_POST['action']) && $_POST['action'] === 'editpost' ) {

                    $old_link_text = get_post_meta( $post_id, 'vs-slider_link_text', true );
                    $new_link_text = !empty(sanitize_text_field( $_POST['vs-slider_link_text'] )) ? sanitize_text_field( $_POST['vs-slider_link_text'] ) : 'Add some text';
                    $old_link_url = get_post_meta( $post_id, 'vs-slider_link_url', true );
                    $new_link_url = !empty(sanitize_text_field( $_POST['vs-slider_link_url'] ))  ? sanitize_text_field( $_POST['vs-slider_link_url'] ) : '#'; // esc_url_raw can also be used here

                    update_post_meta( $post_id, 'vs-slider_link_text', $new_link_text, $old_link_text );
                    update_post_meta( $post_id, 'vs-slider_link_url', $new_link_url, $old_link_url );
                }

            }

            public function vs_slider_cpt_columns( $columns ) {

                $last = array_slice($columns, -1);
                array_pop($columns);

                $columns['vs_slider_link_text'] = esc_html__('Link Text', 'vs-slider');
                $columns['vs_slider_link_url'] = esc_html__('Link URL', 'vs-slider');

                $columns[array_keys($last)[0]] = $last[array_keys($last)[0]];

                return $columns;

            }

            public function vs_slider_custom_columns( $column, $post_id) {
                switch ( $column ) {
                    case 'vs_slider_link_text':
                        $link_text = get_post_meta( $post_id, 'vs-slider_link_text', true );
                        echo esc_html( $link_text );
                        break;
                    case 'vs_slider_link_url':
                        $link_url = get_post_meta( $post_id, 'vs-slider_link_url', true );
                        echo esc_url( $link_url );
                        break;
                }
            }

            public function vs_slider_sortable_columns( $columns ) {
                $columns['vs_slider_link_text'] = 'vs_slider_link_text';
                //$columns['vs_slider_link_url'] = 'vs_slider_link_url';
                return $columns;
            }
        }
    }