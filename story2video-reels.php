<?php
function story2video_reels_page() {
    $uploads_dir = wp_upload_dir();
    $output_dir = $uploads_dir['basedir'] . '/story2video-exports';
    $output_url = $uploads_dir['baseurl'] . '/story2video-exports';

    if (!file_exists($output_dir)) {
        echo '<div class="wrap"><h1>Reels</h1><p>No videos have been exported yet.</p></div>';
        return;
    }

    $video_files = glob($output_dir . '/*.{mp4,avi,mkv}', GLOB_BRACE);
    ?>
    <div class="wrap">
        <h1>Reels</h1>
        <div class="reels-gallery">
            <?php
            foreach ($video_files as $file) {
                $relative_path = str_replace($uploads_dir['basedir'], $uploads_dir['baseurl'], $file);
                echo '<div class="reels-item">';
                echo '<video src="' . esc_url($relative_path) . '" controls></video>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}
?>
