<?php
add_action('admin_post_story2video_export', 'story2video_export');
add_action('wp_ajax_story2video_test_ffmpeg', 'story2video_test_ffmpeg');

function story2video_export() {
    if (!isset($_POST['story_id']) || !isset($_POST['format']) || !isset($_POST['resolution'])) {
        wp_redirect(add_query_arg('export_error', urlencode('Missing parameters'), admin_url('admin.php?page=story2video')));
        exit;
    }

    $story_id = intval($_POST['story_id']);
    $format = sanitize_text_field($_POST['format']);
    $resolution = sanitize_text_field($_POST['resolution']);

    $story = get_post($story_id);
    if (!$story) {
        wp_redirect(add_query_arg('export_error', urlencode('Invalid story ID'), admin_url('admin.php?page=story2video')));
        exit;
    }

    $ffmpeg_path = get_option('story2video_ffmpeg_path', '/usr/bin/ffmpeg');
    $uploads_dir = wp_upload_dir();
    $export_dir = $uploads_dir['basedir'] . '/story2video-exports';
    $output_file = $export_dir . '/' . sanitize_title($story->post_title) . '.' . $format;

    if (!file_exists($export_dir)) {
        mkdir($export_dir, 0755, true);
    }

    // Here you would implement the actual video conversion logic using FFmpeg
    $story_url = get_permalink($story);
    $command = escapeshellcmd("$ffmpeg_path -i \"$story_url\" -vf scale=-1:$resolution \"$output_file\"");
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        wp_redirect(add_query_arg('export_error', urlencode('FFmpeg error: ' . implode
