<?php
/**
 * Plugin Name: Story2Video
 * Description: Adds functionality to export Google Web Stories to video.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include necessary files
include_once(plugin_dir_path(__FILE__) . 'story2video-admin.php');
include_once(plugin_dir_path(__FILE__) . 'story2video-export.php');

// Enqueue scripts
function story2video_enqueue_scripts() {
    wp_enqueue_script('story2video-script', plugin_dir_url(__FILE__) . 'js/story2video.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'story2video_enqueue_scripts');
