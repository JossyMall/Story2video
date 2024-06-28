<?php
function story2video_reels_page() {
    $upload_dir = wp_upload_dir();
    $export_dir = $upload_dir['basedir'] . '/story2video_export';
    $export_url = $upload_dir['baseurl'] . '/story2video_export';
    $videos = glob($export_dir . '/*.mp4');
    ?>
    <div class="wrap">
        <h1>Reels</h1>
        <div class="reels-gallery">
            <?php foreach ($videos as $video): ?>
                <div class="reels-item">
                    <video controls>
                        <source src="<?php echo esc_url($export_url . '/' . basename($video)); ?>" type="video/mp4">
                    </video>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
?>
