<h3><?= (!empty($content)) ? esc_html($content) : esc_html(VS_Slider_Settings::$options['vs_slider_title']); ?></h3>
<div class="vs-slider flexslider">
    <ul class="slides">
        <?php 
        
            $args = array(
                'post_type' => 'vs-slider',
                'post_status' => 'publish',
                'post__in' => $id,
                'orderby' => $orderby,
                'posts_per_page' => -1,
            );

            $my_query = new WP_Query( $args );

            if ( $my_query->have_posts()) :
                while ( $my_query->have_posts() ) : $my_query->the_post();
                
                $button_text = get_post_meta( get_the_ID(), 'vs-slider_link_text', true );
                $button_url = get_post_meta( get_the_ID(), 'vs-slider_link_url', true );
        ?>
            <li>
                <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                <div class="vss-sontainer">
                    <div class="slider-details-container">
                        <div class="wrapper">
                            <div class="slider-title">
                                <h2>Slider Title</h2>
                            </div>
                            <div class="slider-description">
                                <div class="subtitle"><?php the_content();?></div>
                                <a href="<?= esc_url($button_url); ?>" class="link"><?= esc_html($button_text); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php 
                endwhile;
                wp_reset_postdata();
            endif;
        ?>
    </ul>
</div>