<?php
function story2video_settings_page() {
    ?>
    <div class="wrap">
        <h1>Story2Video Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('story2video_settings_group');
            do_settings_sections('story2video_settings_group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">FFmpeg Path</th>
                    <td>
                        <input type="text" name="story2video_ffmpeg_path" value="<?php echo esc_attr(get_option('story2video_ffmpeg_path')); ?>" />
                        <button type="button" id="test-ffmpeg-path">Test FFmpeg Path</button>
                        <div id="ffmpeg-test-result"></div>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <div id="export-progress" style="display:none;">
            <progress id="progress-bar" max="100" value="0"></progress>
        </div>
    </div>
    <?php
}

add_action('admin_init', 'story2video_register_settings');
function story2video_register_settings() {
    register_setting('story2video_settings_group', 'story2video_ffmpeg_path');
}

// AJAX handler to test FFmpeg path
add_action('wp_ajax_test_ffmpeg_path', 'story2video_test_ffmpeg_path');
function story2video_test_ffmpeg_path() {
    $ffmpeg_path = sanitize_text_field($_POST['ffmpeg_path']);
    $output = shell_exec("$ffmpeg_path -version 2>&1");
    if (strpos($output, 'ffmpeg version') !== false) {
        wp_send_json_success('FFmpeg is installed and working.');
    } else {
        wp_send_json_error('FFmpeg is not installed or the path is incorrect.');
    }
}
?>
