jQuery(document).ready(function($) {
    $('form').submit(function() {
        $('#export-progress').show();
        var progressBar = $('#progress-bar');
        var interval = setInterval(function() {
            var value = progressBar.val();
            if (value < 100) {
                progressBar.val(value + 10);
            } else {
                clearInterval(interval);
            }
        }, 1000); // Update every second
    });
});
