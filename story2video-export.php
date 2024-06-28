<?php
add_action('admin_post_story2video_export', 'story2video_export');

function story2video_export() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized user');
    }

    if (!isset($_POST['story_id']) || !isset($_POST['format']) || !isset($_POST['resolution'])) {
        wp_die('Missing required parameters');
    }

    $story_id = intval($_POST['story_id']);
    $format = sanitize_text_field($_POST['format']);
    $resolution = sanitize_text_field($_POST['resolution']);
    $ffmpeg_path = get_option('story2video_ffmpeg_path', 'ffmpeg');

    $story = get_post($story_id);
    if (!$story) {
        wp_die('Invalid story ID');
    }

    $uploads_dir = wp_upload_dir();
    $output_dir = $uploads_dir['basedir'] . '/story2video-exports';
    if (!file_exists($output_dir)) {
        mkdir($output_dir, 0777, true);
    }

    $output_file = $output_dir . '/' . sanitize_title($story->post_title) . '.' . $format;
    $output_log = $output_dir . '/ffmpeg_log.txt';

    // Example FFmpeg command to convert web story to video
    $ffmpeg_command = "$ffmpeg_path -y -f lavfi -i color=s=1920x1080:d=5 -vf 'drawtext=text=" . escapeshellarg($story->post_title) . ":fontcolor=white:fontsize=24:x=(w-text_w)/2:y=(h-text_h)/2' $output_file 2> $output_log";
    exec($ffmpeg_command, $output, $return_var);

    if ($return_var !== 0 || !file_exists($output_file)) {
        $error_message = file_get_contents($output_log);
        $error_message = nl2br(esc_html($error_message));
        wp_redirect(add_query_arg(array('export_error' => 1, 'error_message' => urlencode($error_message)), admin_url('admin.php?page=story2video')));
        exit;
    }

    wp_redirect(add_query_arg(array('export_success' => 1, 'output_file' => urlencode($output_file)), admin_url('admin.php?page=story2video')));
    exit;
}
?>
