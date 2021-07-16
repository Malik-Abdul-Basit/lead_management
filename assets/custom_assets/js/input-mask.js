// Class definition

var KTInputmask = function () {

    // Private functions
    var demos = function () {

        // fax number format
        $(".apply_fax_mask").inputmask("mask", {
            "mask": "(999) 999-9999"
        });

        // cnic format
        $(".apply_cnic_mask").inputmask("mask", {
            "mask": "99999-9999999-9"
        });

        // mobile format
        $(".apply_mobile_mask").inputmask({
            "mask": "999-999 9999"/*,placeholder: "800-640 6409"*/
        });

        //ip address
        $(".apply_ip_address_mask").inputmask({
            "mask": "999.999.999.999"
        });

        //email address
        $(".apply_email_mask").inputmask({
            mask: "*{1,30}[.*{1,30}][.*{1,30}][.*{1,30}]@*{1,30}[.*{2,30}][.*{1,10}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTInputmask.init();
});