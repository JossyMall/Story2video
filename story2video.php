
### File: `story2video.php`

Update the main plugin file to include the settings page.

```php
<?php
/**
 * Plugin Name: Story2Video
 * Description: Adds functionality to export Google Web Stories to video.
 * Version: 1.1
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include necessary files
include_once(plugin_dir_path(__FILE__) . 'story2video-admin.php');
include_once(plugin_dir_path(__FILE__) . 'story2video-export.php');
include_once(plugin_dir_path(__FILE__) . 'story2video-settings.php');

// Enqueue scripts
function story2video_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_story2video' && $hook !== 'story2video_page_story2video-settings') {
        return;
    }
    wp_enqueue_script('story2video-script', plugin_dir_url(__FILE__) . 'js/story2video.js', array('jquery'), null, true);
    wp_localize_script('story2video-script', 'story2video_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'story2video_enqueue_scripts');
?>
