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

        $('.ji-inquiry-form')[0].reset();
        
        if (data.error) {
            alert(data.error);
            return;
        }

        if (data.message) {
            alert(data.message);
        }
    }

    return {
        init: init
    }

})(jQuery);

jQuery(document).ready(function($) {

    Justimmo_Inquiry_Form.init();

});