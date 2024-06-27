<?php
/*
Plugin Name: Story2Video
Description: Export Google Web Stories to video format.
Version: 1.0
Author: Your Name
*/
function story2video_enqueue_scripts() {
    wp_enqueue_script('story2video-script', plugin_dir_url(__FILE__) . 'js/story2video.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'story2video_enqueue_scripts');


// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary files
include_once(plugin_dir_path(__FILE__) . 'includes/story2video-admin.php');
include_once(plugin_dir_path(__FILE__) . 'includes/story2video-export.php');
?>
