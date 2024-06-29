jQuery(document).ready(function($) {
    $('#test-ffmpeg-button').on('click', function() {
        $.ajax({
            url: story2video_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'story2video_test_ffmpeg',
            },
            success: function(response) {
                if (response.success) {
                    $('#ffmpeg-test-result').html('<p style="color: green;">' + response.data.message + '</p>');
                } else {
                    $('#ffmpeg-test-result').html('<p style="color: red;">' + response.data.message + '</p>');
                }
            },
            error: function() {
                $('#ffmpeg-test-result').html('<p style="color: red;">An error occurred while testing FFmpeg.</p>');
            }
        });
    });

    $('form[action="admin-post.php"]').on('submit', function() {
        $('#export-progress').show();
        var progressBar = $('#progress-bar');
        var interval = setInterval(function() {
            var currentVal = parseInt(progressBar.val());
            if (currentVal < 100) {
                progressBar.val(currentVal + 1);
            } else {
                clearInterval(interval);
            }
        }, 100);

        setTimeout(function() {
            clearInterval(interval);
            progressBar.val(100);
            $('#export-progress').hide();
        }, 10000);
    });
});
