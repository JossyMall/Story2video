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
            <?php submit_button('Export to Video'); ?>
        </form>
    </div>
    <?php
}
?>
