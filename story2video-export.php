<?php
// Register the export function
add_action('admin_post_story2video_export', 'story2video_export');

function story2video_export() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized user');
    }

    // Get the story ID
    $story_id = intval($_POST['story_id']);

    // Get the story content
    $story = get_post($story_id);

    if ($story && $story->post_type == 'web-story') {
        // Export logic here
        // For example, use FFmpeg to convert the story to video

        $story_content = apply_filters('the_content', $story->post_content);
        $output_file = plugin_dir_path(__FILE__) . "exports/story_$story_id.mp4";

        // Command to render video using FFmpeg (example)
        $command = "ffmpeg -i $story_content -c:v libx264 -c:a aac $output_file";
        shell_exec($command);

        wp_redirect(admin_url('admin.php?page=story2video&export_success=1'));
        exit;
    } else {
        wp_redirect(admin_url('admin.php?page=story2video&export_error=1'));
        exit;
    }
}
?>
