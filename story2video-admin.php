<?php
// Add a menu item for the plugin
add_action('admin_menu', 'story2video_admin_menu');

function story2video_admin_menu() {
    add_menu_page(
        'Story2Video',
        'Story2Video',
        'manage_options',
        'story2video',
        'story2video_admin_page',
        'dashicons-video-alt3'
    );
}

function story2video_admin_page() {
    ?>
    <div class="wrap">
        <h1>Story2Video</h1>
        <form method="post" action="options.php">
            <?php settings_fields('story2video_options_group'); ?>
            <?php do_settings_sections('story2video'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
