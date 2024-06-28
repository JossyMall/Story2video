<?php
function story2video_settings_page() {
    ?>
    <div class="wrap">
        <h1>Story2Video Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('story2video-settings-group');
            do_settings_sections('story2video-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">FFmpeg Path</th>
                    <td><input type="text" name="story2video_ffmpeg_path" value="<?php echo esc_attr(get_option('story2video_ffmpeg_path', 'ffmpeg')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <button id="test-ffmpeg-path">Test FFmpeg Path</button>
        <div id="ffmpeg-test-result"></div>
    </div>
    <?php
}

add_action('admin_init', 'story2video_register_settings');

function story2video_register_settings() {
    register_setting('story2video-settings-group', 'story2video_ffmpeg_path');
}

add_action('wp_ajax_test_ffmpeg_path', 'story2video_test_ffmpeg_path');

function story2video_test_ffmpeg_path() {
    $ffmpeg_path = sanitize_text_field($_POST['ffmpeg_path']);
    $command = "$ffmpeg_path -version 2>&1";
    $output = shell_exec($command);
    if (strpos($output, 'ffmpeg version') !== false) {
        wp_send_json_success('FFmpeg is installed and the path is valid.');
    } else {
        wp_send_json_error('FFmpeg is not installed or the path is invalid.');
    }
}
?>
