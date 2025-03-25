$(document).ready(function() {
    $('#comment-form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Check if the comment textarea is not empty
        var comment = $('textarea[name="comment"]').val();
        if(comment.trim() === '') {
            alert("Please enter a comment.");
            return; // Stop if the comment is empty
        }

        // Show a loading message or disable the button while the request is being processed
        $('button[type="submit"]').prop('disabled', true).text('Submitting...');

        // Get the form data
        var formData = $(this).serialize(); // This will collect all the form input values

        $.ajax({
            url: '../../engine/seller_comment.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Assuming the server returns a success message
                if(response === 1) {
                    alert("Your comment has been added successfully.");
                    // Optionally, you can reset the form here
                    $('#comment-form')[0].reset();
                } else {
                    alert("An error occurred while submitting your comment.");
                }
                $('button[type="submit"]').prop('disabled', false).text('Add comment'); // Reset button state
            },
            error: function() {
                alert("An error occurred. Please try again later.");
                $('button[type="submit"]').prop('disabled', false).text('Add comment');
            }
        });
    });
});
