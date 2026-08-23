<div class="alert-banner success" style="display: none;"></div>
<div class="alert-banner error" style="display: none;"></div>

<form class="contact-form ajax-contact-form" method="POST" action="{{ route('software.contact.submit') }}">
    @csrf
    <input type="hidden" name="type" value="contact_form">
    
    <div class="form-group-row">
        <div class="form-control-wrap">
            <label class="form-label" for="contact_name">Full Name</label>
            <input type="text" id="contact_name" name="name" class="input-field" placeholder="John Doe" required>
        </div>
        <div class="form-control-wrap">
            <label class="form-label" for="contact_email">Email Address</label>
            <input type="email" id="contact_email" name="email" class="input-field" placeholder="john@example.com" required>
        </div>
    </div>
    
    <div class="form-group-row">
        <div class="form-control-wrap">
            <label class="form-label" for="contact_phone">Phone Number (Optional)</label>
            <input type="text" id="contact_phone" name="phone" class="input-field" placeholder="+1 (555) 000-0000">
        </div>
        <div class="form-control-wrap">
            <label class="form-label" for="contact_subject">Subject</label>
            <input type="text" id="contact_subject" name="subject" class="input-field" placeholder="Demo Inquiry / Partnership" required>
        </div>
    </div>
    
    <div class="form-control-wrap">
        <label class="form-label" for="contact_message">Your Message</label>
        <textarea id="contact_message" name="message" class="input-field" placeholder="Tell us about your event ticketing needs..." required></textarea>
    </div>
    
    <button type="submit" class="btn-primary form-submit-btn">
        <i class="fa-solid fa-paper-plane"></i> Send Message
    </button>
</form>

@once
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bind submit handler to all AJAX contact forms
        $(document).on('submit', '.ajax-contact-form', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $wrapper = $form.parent();
            const $successBanner = $wrapper.find('.alert-banner.success');
            const $errorBanner = $wrapper.find('.alert-banner.error');
            const $submitBtn = $form.find('.form-submit-btn');

            // Hide old banners
            $successBanner.hide().text('');
            $errorBanner.hide().text('');

            // Disable submit button
            const originalBtnHtml = $submitBtn.html();
            $submitBtn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin"></i> Sending...');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                    if (response.success) {
                        $successBanner.text(response.message).fadeIn();
                        $form.trigger('reset');
                        // Scroll to the success banner smoothly
                        $('html, body').animate({
                            scrollTop: $successBanner.offset().top - 120
                        }, 500);
                    } else {
                        $errorBanner.text('Failed to process message. Please check parameters.').fadeIn();
                    }
                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                    let errorText = 'An error occurred while sending your message. Please try again.';
                    
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errorDetails = Object.values(xhr.responseJSON.errors);
                        errorText = errorDetails.map(err => err[0]).join('<br>');
                    }
                    
                    $errorBanner.html(errorText).fadeIn();
                }
            });
        });
    });
</script>
@endonce
