function showContent(section) {
    // Hide all sections
    document.querySelectorAll(".content-section").forEach(el => el.classList.add("d-none"));
    // Show selected
    document.getElementById(section).classList.remove("d-none");
    // Update active button
    document.querySelectorAll(".sidebar-menu button").forEach(btn => btn.classList.remove("active"));
    event.target.classList.add("active");
}


$("#user-address-button").click(function (event) {
    let isValid = true;
    // Clear previous validation messages
    $("#user-address-form").find('.form-control').removeClass('is-invalid');

    // Iterate through required input fields
    $("#user-address-form").find('input[required], select[required]').each(function () {
        if ($(this).val() === '') {
            $(this).addClass('is-invalid'); // Add 'is-invalid' class
            $("#user-address-button").prop('disabled', true);
            isValid = false; // Set form validation flag to false
        } else {
            isValid = true;
            $("#user-address-button").prop('disabled', false);
        }
    });

    // If the form is valid, submit the form with image data
    if (isValid) {

        const isDefault = $('#is_default').is(':checked') ? 1 : 0;
        let formData = new FormData();
        formData.append('address_id', $('#address_id').val());
        formData.append('is_default', isDefault);
        formData.append('address', $('#address').val());
        formData.append('city', $('#city').val());
        formData.append('house_no', $('#house_no').val());
        formData.append('street_name', $('#street_name').val());
        formData.append('postal_code', $('#postal_code').val());
        formData.append('country', $('#country').val());
        formData.append('country_code', $('#country_code').val());
        formData.append('_token', csrfToken); // Include CSRF token for security


        $.ajax({
            url: updateAddressUrl,
            type: 'POST',
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function (response) {
                if (response.success) {
                    $('#ajax-message').removeClass('d-none alert-danger').addClass('alert-success').text(response.message);
                    $('.user-img img').attr('src', response.image_path);
                    setTimeout(function () {
                        $('#ajax-message').addClass('d-none');
                    }, 5000);
                } else {
                    $('#ajax-message').removeClass('d-none alert-success').addClass('alert-danger').text('Failed to update address.');
                    setTimeout(function () {
                        $('#ajax-message').addClass('d-none');
                    }, 5000);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log errors for debugging
                alert('An error occurred while updating the address.');
            }
        });
    }
    return false;
});


$("#user-account-button").click(function (event) {
    let isValid = true;
    // Clear previous validation messages
    $("#user-account-form").find('.form-control').removeClass('is-invalid');

    // Iterate through required input fields
    $("#user-account-form").find('input[required], select[required]').each(function () {
        if ($(this).val() === '') {
            $(this).addClass('is-invalid'); // Add 'is-invalid' class
            $("#user-account-button").prop('disabled', true);
            isValid = false; // Set form validation flag to false
        } else {
            isValid = true;
            $("#user-account-button").prop('disabled', false);
        }
    });

    // If the form is valid, submit the form with image data
    if (isValid) {
        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('address', $('#address').val());
        formData.append('mobile', $('#mobile').val());
        formData.append('_token', csrfToken); // Include CSRF token for security

        // Append image file if provided
        let profilePic = $('#profile_picture')[0].files[0];
        if (profilePic) {
            formData.append('profile_picture', profilePic);
        }

        $.ajax({
            url: updateAccountUrl,
            type: 'POST',
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function (response) {
                if (response.success) {
                    $('#ajax-message').removeClass('d-none alert-danger').addClass('alert-success').text(response.message);
                    $('.user-img img').attr('src', response.image_path);
                    setTimeout(function () {
                        $('#ajax-message').addClass('d-none');
                    }, 5000);
                } else {
                    $('#ajax-message').removeClass('d-none alert-success').addClass('alert-danger').text('Failed to update address.');
                    setTimeout(function () {
                        $('#ajax-message').addClass('d-none');
                    }, 5000);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log errors for debugging
                alert('An error occurred while updating the address.');
            }
        });
    }
    return false;
});