<?php
/*
Plugin Name: Story2Video
Description: Export Google Web Stories to video format.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the necessary files
include_once(plugin_dir_path(__FILE__) . 'includes/story2video-admin.php');
include_once(plugin_dir_path(__FILE__) . 'includes/story2video-export.php');
?>
