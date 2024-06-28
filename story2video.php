<?php
/**
 * Plugin Name: Story2Video
 * Description: Adds functionality to export Google Web Stories to video.
 * Version: 1.3
 * Author: Angel Cee
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include necessary files
include_once(plugin_dir_path(__FILE__) . 'story2video-admin.php');
include_once(plugin_dir_path(__FILE__) . 'story2video-export.php');
include_once(plugin_dir_path(__FILE__) . 'story2video-settings.php');
include_once(plugin_dir_path(__FILE__) . 'story2video-reels.php');

// Enqueue scripts and styles
function story2video_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_story2video' && $hook !== 'story2video_page_story2video-settings' && $hook !== 'story2video_page_story2video-reels') {
        return;
    }
    wp_enqueue_script('story2video-script', plugin_dir_url(__FILE__) . 'js/story2video.js', array('jquery'), null, true);
    wp_localize_script('story2video-script', 'story2video_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('story2video-style', plugin_dir_url(__FILE__) . 'css/story2video.css');
}
add_action('admin_enqueue_scripts', 'story2video_enqueue_scripts');
?>
