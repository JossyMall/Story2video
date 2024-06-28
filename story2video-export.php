<?php
// Register the export function
add_action('admin_post_story2video_export', 'story2video_export');

function story2video_export() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized user');
    }

    // Get the inputs
    $story_id = intval($_POST['story_id']);
    $format = sanitize_text_field($_POST['format']);
    $resolution = sanitize_text_field($_POST['resolution']);

    // Get the FFmpeg path from settings
    $ffmpeg_path = get_option('story2video_ffmpeg_path', 'ffmpeg');

    // Get the story content
    $story = get_post($story_id);

    if ($story && $story->post_type == 'web-story') {
        // Export logic here
        // For example, use FFmpeg to convert the story to video

        $story_content = apply_filters('the_content', $story->post_content);
        $uploads_dir = wp_upload_dir();
        $output_dir = $uploads_dir['basedir'] . '/story2video-exports';

        // Create the output directory if it doesn't exist
        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0755, true);
        }

        $output_file = $output_dir . "/story_$story_id.$format";

        // Determine FFmpeg resolution settings
        $resolution_option = '';
        switch ($resolution) {
            case '1080p':
                $resolution_option = '-vf scale=1920:1080';
                break;
            case '720p':
                $resolution_option = '-vf scale=1280:720';
                break;
            case '480p':
                $resolution_option = '-vf scale=854:480';
                break;
            default:
                $resolution_option = '-vf scale=1280:720';
                break;
        }

        // Command to render video using FFmpeg (example)
        $command = "$ffmpeg_path -i $story_content $resolution_option -c:v libx264 -c:a aac $output_file 2>&1";
        $output = shell_exec($command);

        // Error handling
        if (strpos($output, 'Error') !== false || !file_exists($output_file)) {
            wp_redirect(admin_url('admin.php?page=story2video&export_error=1'));
            exit;
        } else {
            wp_redirect(admin_url('admin.php?page=story2video&export_success=1&output_file=' . urlencode($output_file)));
            exit;
        }
    } else {
        wp_redirect(admin_url('admin.php?page=story2video&export_error=1'));
        exit;
    }
}
?>
