$(document).ready(function () {
    if (typeof $.validator === 'undefined') {
        console.warn('jQuery Validation plugin is not loaded. Global validation skipped.');
        return;
    }

    // Allowed email domains variable (can be overridden by server config later)
    // Empty array means allow all correctly formatted domains.
    var allowedEmailDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'businzo.com'];

    // Custom Methods
    $.validator.addMethod("alpha", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Only letters and spaces are allowed.");

    $.validator.addMethod("alphanumeric_special", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s,\-\/\(\)]+$/.test(value);
    }, "Only alphanumeric characters and , - / ( ) are allowed.");

    $.validator.addMethod("domain_email", function (value, element) {
        if (this.optional(element)) return true;
        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) return false;

        var domain = value.split('@')[1];
        if (allowedEmailDomains.length > 0) {
            return allowedEmailDomains.includes(domain.toLowerCase());
        }
        return true;
    }, "Please enter a valid email address with an allowed domain.");

    $.validator.addMethod("only_numbers", function (value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "Only numbers are allowed.");

    $.validator.addMethod("maxfilesize", function (value, element, param) {
        if (this.optional(element)) return true;
        if (element.files && element.files[0]) {
            var size = element.files[0].size;
            // param is in MB
            return size <= (param * 1024 * 1024);
        }
        return true;
    }, "File size must be less than {0} MB.");

    $.validator.addMethod("allowed_mimes", function (value, element, param) {
        if (this.optional(element)) return true;
        var allowedExtensions = param.split(',');
        var extension = value.split('.').pop().toLowerCase();
        return $.inArray(extension, allowedExtensions) !== -1;
    }, "Only the following file types are allowed: {0}.");

    // Apply validation to all forms automatically
    $('form').each(function () {
        var $form = $(this);
        // Exclude forms that we don't want to validate via this generic script
        if ($form.hasClass('no-global-validation')) return;

        $form.validate({
            errorClass: 'text-red-400 text-xs mt-1 block font-medium tracking-wide',
            errorElement: 'span',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                if (element.parent('.relative').length || element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Dynamically add rules to inputs based on name/type
        $form.find('input, textarea, select').each(function () {
            var $input = $(this);
            var name = $input.attr('name');
            var type = $input.attr('type');

            if (!name) return;

            var rules = {};

            // Name fields
            if (name === 'name' || name === 'first_name' || name === 'last_name' || name.includes('name')) {
                // Avoid applying alpha to usernames or file names if applicable
                if (!name.includes('user') && !name.includes('file')) {
                    rules.alpha = true;
                }
            }

            // Address fields
            if (name.includes('address') || name.includes('location')) {
                rules.alphanumeric_special = true;
            }

            // Email fields
            if (type === 'email' || name.includes('email')) {
                rules.domain_email = true;
            }

            // Phone fields
            if (type === 'tel' || name.includes('phone') || name.includes('mobile') || name === 'contact') {
                rules.only_numbers = true;
            }

            // File fields
            if (type === 'file') {
                rules.maxfilesize = 5; // 5 MB
                rules.allowed_mimes = "jpg,jpeg,png,pdf,docs,docx,csv,json";
            }

            if (Object.keys(rules).length > 0) {
                $input.rules("add", rules);
            }
        });
    });
});
