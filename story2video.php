<?php
/*
Plugin Name: Story2Video
Description: Add-on for Google Web Stories plugin to export stories as videos.
Version: 1.0
Author: Angel Cee
*/

// Include necessary files
include_once plugin_dir_path(__FILE__) . 'story2video-admin.php';
include_once plugin_dir_path(__FILE__) . 'story2video-export.php';
include_once plugin_dir_path(__FILE__) . 'story2video-settings.php';
include_once plugin_dir_path(__FILE__) . 'story2video-reels.php';

// Register activation hook
register_activation_hook(__FILE__, 'story2video_activate');
function story2video_activate() {
    // Create the export directory if it doesn't exist
    $upload_dir = wp_upload_dir();
    $export_dir = $upload_dir['basedir'] . '/story2video_export';
    if (!file_exists($export_dir)) {
        wp_mkdir_p($export_dir);
    }
}

// Enqueue scripts and styles
add_action('admin_enqueue_scripts', 'story2video_enqueue_scripts');
function story2video_enqueue_scripts() {
    wp_enqueue_script('story2video-js', plugin_dir_url(__FILE__) . 'js/story2video.js', array('jquery'), '1.0', true);
    wp_localize_script('story2video-js', 'story2video_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('story2video-css', plugin_dir_url(__FILE__) . 'css/story2video.css');
}
?>
