<?php
/*
Plugin Name: Story2Video
Description: Convert Google Web Stories to Video.
Version: 1.0
Author: Your Name
*/

function story2video_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_story2video' && $hook !== 'story2video_page_story2video_settings' && $hook !== 'story2video_page_story2video_reels') {
        return;
    }
    wp_enqueue_style('story2video-css', plugin_dir_url(__FILE__) . 'assets/css/story2video.css');
    wp_enqueue_script('story2video-js', plugin_dir_url(__FILE__) . 'assets/js/story2video.js', array('jquery'), null, true);
    wp_localize_script('story2video-js', 'story2video_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'story2video_enqueue_admin_scripts');

require_once plugin_dir_path(__FILE__) . 'story2video-admin.php';
require_once plugin_dir_path(__FILE__) . 'story2video-ajax.php';

register_activation_hook(__FILE__, 'story2video_activate');
function story2video_activate() {
    if (!file_exists(WP_CONTENT_DIR . '/uploads/story2video-exports')) {
        mkdir(WP_CONTENT_DIR . '/uploads/story2video-exports', 0755, true);
    }
}
?>
