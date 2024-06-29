<?php
function story2video_admin_page() {
    if (isset($_GET['export_success'])) {
        $output_file = urldecode($_GET['output_file']);
        $uploads_dir = wp_upload_dir();
        $relative_path = str_replace($uploads_dir['basedir'], $uploads_dir['baseurl'], $output_file);
        echo '<div class="notice notice-success is-dismissible"><p>Export successful! <a href="' . esc_url($relative_path) . '" target="_blank">Download Video</a></p></div>';
    } elseif (isset($_GET['export_error'])) {
        $error_message = urldecode($_GET['error_message']);
        echo '<div class="notice notice-error is-dismissible"><p>Export failed. Error message: ' . $error_message . '</p></div>';
    }

    $stories = get_posts(array('post_type' => 'web-story', 'numberposts' => -1));
    ?>
    <div class="wrap">
        <h1>Story2Video</h1>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="story2video_export">
            <label for="story_id">Select a Web Story:</label>
            <select name="story_id" id="story_id">
                <?php foreach ($stories as $story): ?>
                    <option value="<?php echo $story->ID; ?>"><?php echo $story->post_title; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="format">Select Video Format:</label>
            <select name="format" id="format">
                <option value="mp4">MP4</option>
                <option value="avi">AVI</option>
                <option value="mkv">MKV</option>
            </select>

            <label for="resolution">Select Resolution:</label>
            <select name="resolution" id="resolution">
                <option value="1080p">1080p</option>
                <option value="720p">720p</option>
                <option value="480p">480p</option>
            </select>

            <?php submit_button('Export to Video'); ?>
        </form>

        <div id="export-progress" style="display: none;">
            <p>Exporting...</p>
            <progress id="progress-bar" max="100" value="0"></progress>
        </div>
    </div>
    <?php
}

function story2video_settings_page() {
    ?>
    <div class="wrap">
        <h1>Story2Video Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('story2video-settings-group'); ?>
            <?php do_settings_sections('story2video-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">FFmpeg Path</th>
                    <td><input type="text" name="story2video_ffmpeg_path" value="<?php echo esc_attr(get_option('story2video_ffmpeg_path')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>

        <button id="test-ffmpeg-button" class="button button-secondary">Test FFmpeg Path</button>
        <div id="ffmpeg-test-result"></div>
    </div>
    <?php
}

function story2video_reels_page() {
    $uploads_dir = wp_upload_dir();
    $export_dir = $uploads_dir['basedir'] . '/story2video-exports';
    $export_url = $uploads_dir['baseurl'] . '/story2video-exports';

    if (!file_exists($export_dir)) {
        echo '<div class="notice notice-warning"><p>No exported videos found.</p></div>';
        return;
    }

    $files = scandir($export_dir);
    $videos = array_diff($files, array('.', '..'));

    ?>
    <div class="wrap">
        <h1>Exported Videos</h1>
        <div class="story2video-gallery">
            <?php foreach ($videos as $video): ?>
                <div class="story2video-item">
                    <video width="320" height="240" controls>
                        <source src="<?php echo esc_url($export_url . '/' . $video); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p><?php echo esc_html($video); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function story2video_admin_menu() {
    add_menu_page('Story2Video', 'Story2Video', 'manage_options', 'story2video', 'story2video_admin_page', 'dashicons-video-alt3');
    add_submenu_page('story2video', 'Settings', 'Settings', 'manage_options', 'story2video_settings', 'story2video_settings_page');
    add_submenu_page('story2video', 'Reels', 'Reels', 'manage_options', 'story2video_reels', 'story2video_reels_page');
}
add_action('admin_menu', 'story2video_admin_menu');

function story2video_register_settings() {
    register_setting('story2video-settings-group', 'story2video_ffmpeg_path');
}
add_action('admin_init', 'story2video_register_settings');
?>
