<?php
// Add a menu item for the plugin
add_action('admin_menu', 'story2video_admin_menu');

function story2video_admin_menu() {
    add_menu_page(
        'Story2Video',
        'Story2Video',
        'manage_options',
        'story2video',
        'story2video_admin_page',
        'dashicons-video-alt3'
    );
}

function story2video_admin_page() {
    if (isset($_GET['export_success'])) {
        $output_file = urldecode($_GET['output_file']);
        $uploads_dir = wp_upload_dir();
        $relative_path = str_replace($uploads_dir['basedir'], $uploads_dir['baseurl'], $output_file);
        echo '<div class="notice notice-success is-dismissible"><p>Export successful! <a href="' . esc_url($relative_path) . '" target="_blank">Download Video</a></p></div>';
    } elseif (isset($_GET['export_error'])) {
        echo '<div class="notice notice-error is-dismissible"><p>Export failed. Please try again.</p></div>';
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
?>
