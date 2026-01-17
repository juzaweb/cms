/**
 * AJAX Comment Submission
 * Handles comment form submission without page reload for Itech theme
 */
$(function () {
    const $commentForm = $('#commentForm');
    const $commentsBlock = $('#Blog1_comments-block-wrapper');
    const $commentCount = $('.comments .title');

    if (!$commentForm.length) {
        return;
    }

    // Handle form submission
    $commentForm.on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const formData = new FormData(this);
        const url = $form.attr('action') || window.location.href;

        // Disable submit button to prevent double submission
        $submitBtn.prop('disabled', true).text('Submitting...');

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                if (response.comment) {
                    const comment = response.comment;
                    
                    // Create comment HTML
                    const commentHtml = createCommentHtml(comment);
                    
                    // Append to comment list
                    $commentsBlock.append(commentHtml);
                    
                    // Update comment count
                    updateCommentCount(1);
                    
                    // Clear form
                    $('#content').val('');
                    
                    // Show success message
                    showMessage(response.message || 'Comment added successfully', 'success');
                    
                    // Scroll to the new comment
                    $('html, body').animate({
                        scrollTop: $commentsBlock.find('.comment-item:last').offset().top - 100
                    }, 500);
                } else {
                    showMessage('Comment added successfully', 'success');
                    // Reload page if response doesn't contain comment data
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        // Handle validation errors
                        const errors = xhr.responseJSON.errors;
                        const errorMessages = Object.values(errors).flat();
                        errorMessage = errorMessages.join('<br>');
                    }
                }
                
                showMessage(errorMessage, 'error');
            },
            complete: function () {
                // Re-enable submit button
                $submitBtn.prop('disabled', false).text($submitBtn.data('original-text') || 'Submit');
            }
        });
    });

    // Store original button text
    $commentForm.find('button[type="submit"]').each(function() {
        $(this).data('original-text', $(this).text());
    });

    /**
     * Create HTML for a new comment
     */
    function createCommentHtml(comment) {
        const commentDate = comment.created_time || 'Just now';
        const commentAuthor = comment.name || 'Guest';
        const commentContent = comment.content || '';
        
        return `
            <div class="comment-item">
                <div class="comment-header">
                    <span class="comment-author">${escapeHtml(commentAuthor)}</span>
                    <span class="comment-date">${escapeHtml(commentDate)}</span>
                </div>
                <div class="comment-body">
                    ${commentContent}
                </div>
            </div>
        `;
    }

    /**
     * Update comment count
     */
    function updateCommentCount(increment) {
        const currentText = $commentCount.text();
        const match = currentText.match(/(\d+)/);
        
        if (match) {
            const currentCount = parseInt(match[1]);
            const newCount = currentCount + increment;
            const newText = currentText.replace(/\d+/, newCount);
            $commentCount.text(newText);
        }
    }

    /**
     * Show message to user
     */
    function showMessage(message, type) {
        // Remove any existing messages
        $('.comment-message').remove();
        
        const messageClass = type === 'success' ? 'alert-success' : 'alert-error';
        const messageHtml = `
            <div class="comment-message alert-message ${messageClass}" style="margin: 15px 0;">
                ${message}
            </div>
        `;
        
        $commentForm.before(messageHtml);
        
        // Auto-remove message after 5 seconds
        setTimeout(function() {
            $('.comment-message').fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }
});
