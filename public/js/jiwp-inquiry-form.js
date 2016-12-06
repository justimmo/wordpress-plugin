Justimmo_Inquiry_Form = (function($) {

    var self = this;

    function init() 
    {
        initInquiryForm();
    }

    function initInquiryForm() 
    {
        $('.ji-inquiry-form').on('submit', formSubmitHandler);
    }

    function formSubmitHandler(e)
    {
        e.preventDefault();
        $.ajax({
            url: Justimmo_Ajax.ajax_url,
            type: 'POST',
            data: {
                action      : 'ajax_send_inquiry',
                security    : Justimmo_Ajax.ajax_nonce,
                formData    : $(this).serialize()
            },
            success: formResponseHandler
        });
    }

    function formResponseHandler(data)
    {
        data = JSON.parse(data);
        
        if (data.error) {
            showInquiryMessage(data.error, 'error');
            return;
        }

        $('.ji-inquiry-form')[0].reset();

        if (data.message) {
            showInquiryMessage(data.message, 'success');
        }
    }

    function showInquiryMessage(message, type) {
        $('.ji-inquiry-messages')
            .empty()
            .append('<div class="ji-inquiry-message ji-inquiry-message--' + type + '">' + message + '</div>');
    }

    return {
        init: init
    }

})(jQuery);

jQuery(document).ready(function($) {

    Justimmo_Inquiry_Form.init();

});