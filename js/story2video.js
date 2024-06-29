document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="admin-post.php"]');
    const progressBar = document.getElementById('progress-bar');
    const progressDiv = document.getElementById('export-progress');
    const testButton = document.getElementById('test-ffmpeg-button');
    const ffmpegTestResult = document.getElementById('ffmpeg-test-result');

    if (form) {
        form.addEventListener('submit', function () {
            progressDiv.style.display = 'block';
            progressBar.value = 0;
            const interval = setInterval(() => {
                progressBar.value += 10;
                if (progressBar.value >= 100) {
                    clearInterval(interval);
                }
            }, 1000);
        });
    }

    if (testButton) {
        testButton.addEventListener('click', function () {
            const ffmpegPath = document.querySelector('input[name="story2video_ffmpeg_path"]').value;
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'story2video_test_ffmpeg',
                    ffmpeg_path: ffmpegPath
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    ffmpegTestResult.innerHTML = `<div class="notice notice-success is-dismissible"><p>${data.message}</p></div>`;
                } else {
                    ffmpegTestResult.innerHTML = `<div class="notice notice-error is-dismissible"><p>${data.message}</p></div>`;
                }
            })
            .catch(error => {
                ffmpegTestResult.innerHTML = `<div class="notice notice-error is-dismissible"><p>Error: ${error.message}</p></div>`;
            });
        });
    }
});
