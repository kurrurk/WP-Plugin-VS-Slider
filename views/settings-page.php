<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php 
            settings_fields('vs_slider_group');
            do_settings_sections('vs-slider-page1');
            do_settings_sections('vs-slider-page2');
            submit_button('Save Settings');
        ?>
    </form>
</div>

