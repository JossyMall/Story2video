jQuery(document).ready(function($) {
    // Handle FFmpeg path testing
    $('#test-ffmpeg-path').on('click', function() {
        var ffmpegPath = $('input[name="story2video_ffmpeg_path"]').val();
        $.ajax({
            url: story2video_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'test_ffmpeg_path',
                ffmpeg_path: ffmpegPath
            },
            success: function(response) {
                if (response.success) {
                    $('#ffmpeg-test-result').html('<p style="color: green;">' + response.data + '</p>');
                } else {
                    $('#ffmpeg-test-result').html('<p style="color: red;">' + response.data + '</p>');
                }
            }
        });
    });

    // Handle export progress
    $('form').on('submit', function() {
        $('#export-progress').show();
        var progressBar = $('#progress-bar');
        var progressValue = 0;
        var interval = setInterval(function() {
            progressValue += 10;
            progressBar.val(progressValue);
            if (progressValue >= 100) {
                clearInterval(interval);
            }
        }, 500);
    });
});
