<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()); ?></h1>
    <?php 
        $activate_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'main_options';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=vs-slider-admin&tab=main_options" class="nav-tab <?= $activate_tab == 'main_options' ? 'nav-tab-active' : '' ?>">Main Options</a>
        <a href="?page=vs-slider-admin&tab=additional_options" class="nav-tab <?= $activate_tab == 'additional_options' ? 'nav-tab-active' : '' ?>">Additional Options</a>
    </h2>
    <form action="options.php" method="post">
        <?php 
            if ( $activate_tab == 'main_options' ) {
                settings_fields('vs_slider_group');
                do_settings_sections('vs-slider-page1');
            } else {
                settings_fields('vs_slider_group');
                do_settings_sections('vs-slider-page2');
            }
            submit_button('Save Settings');
        ?>
    </form>
</div>

