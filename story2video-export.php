<?php
function story2video_export_story_to_video($story_id) {
    $ffmpeg_path = get_option('story2video_ffmpeg_path');
    $upload_dir = wp_upload_dir();
    $export_dir = $upload_dir['basedir'] . '/story2video_export';
    $story_path = get_attached_file($story_id);
    $output_file = $export_dir . '/' . basename($story_path, '.webp') . '.mp4';

    // Check if FFmpeg path is set
    if (!$ffmpeg_path) {
        return new WP_Error('no_ffmpeg', 'FFmpeg path is not set.');
    }

    // Run FFmpeg command
    $command = "$ffmpeg_path -i $story_path $output_file 2>&1";
    $output = shell_exec($command);

    // Check if the output file was created
    if (!file_exists($output_file)) {
        return new WP_Error('export_failed', 'Video export failed. FFmpeg output: ' . $output);
    }

    return $output_file;
}

add_action('wp_ajax_story2video_export', 'story2video_export_handler');
function story2video_export_handler() {
    check_ajax_referer('story2video_export', 'security');
    $story_id = intval($_POST['story_id']);

    $result = story2video_export_story_to_video($story_id);
    if (is_wp_error($result)) {
        wp_send_json_error($result->get_error_message());
    } else {
        wp_send_json_success('Export successful. Video saved to: ' . $result);
    }
}
?>
