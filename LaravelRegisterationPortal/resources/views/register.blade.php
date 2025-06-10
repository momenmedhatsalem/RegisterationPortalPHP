<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registration</title>
    <style>
    :root {
      --text-align: {{ in_array(session('locale'), ['ar', 'he', 'fa']) ? 'right' : 'left' }};
    }
    </style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
    @include('partials.header')


    <div class="container">
        <form id="registrationForm" method="POST" action="/submit" enctype="multipart/form-data" novalidate>
            @csrf
            <h2>{{ __('register.registration') }}</h2>

            <div id="success-msg" class="success-msg" style="display:none;">
                {{ __('register.success_msg') }}
            </div>

            <div class="input-group">
                <div>
                    <label for="name">{{ __('register.full_name') }}</label>
                    <input type="text" id="name" name="name" placeholder="{{ __('register.full_name_placeholder') }}" required />
                    <div class="error-msg" id="name_err"></div>
                </div>
                <div>
                    <label for="username">{{ __('register.username') }}</label>
                    <input type="text" id="username" class="validate-field" name="username" placeholder="{{ __('register.username_placeholder') }}" required oninput="check_unique('username')" />
                    <span id="username_check_msg" class="text-sm"></span>
                    <div class="error-msg" id="user_name_err"></div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="email">{{ __('register.email') }}</label>
                    <input type="email" id="email" class="validate-field" name="email" placeholder="{{ __('register.email_placeholder') }}" required oninput="check_unique('email')" />
                      <span id="email_check_msg" class="text-sm"></span>
                    <div class="error-msg" id="email_err"></div>
                </div>
                <div>
                    <label for="phone_number">{{ __('register.phone_number') }}</label>
                    <input type="tel" id="phone_number" class="validate-field" name="phone_number" placeholder="{{ __('register.phone_number_placeholder') }}" required oninput="check_unique('phone_number')"/>
                        <span id="phone_number_check_msg" class="text-sm"></span>
                    <div class="error-msg" id="phone_number_err"></div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="whatsapp_phone_number">{{ __('register.whatsapp_number') }}</label>
                    <input type="tel" id="whatsapp_phone_number" name="whatsapp_phone_number" placeholder="{{ __('register.whatsapp_number_placeholder') }}" required />
                    <small style="font-size: 10px; color: rgba(0, 0, 0, 0.5); display: block; margin-top: 3px; text-align: left;">
                        Please start with country code, e.g. +1 for USA, +20 for EG.
                    </small>
                    <button type="button" class="whatsapp_phone_number-btn" id="validBtn">{{ __('register.validate') }}</button>
                    <div class="error-msg" id="whatsapp_phone_number_err"></div>
                    <div id="whatsapp_phone_number-check-msg"></div>
                </div>
                <div>
                    <label for="address">{{ __('register.address') }}</label>
                    <input type="text" id="address" name="address" placeholder="{{ __('register.address_placeholder') }}" required />
                    <div class="error-msg" id="address_err"></div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="password">{{ __('register.password') }}</label>
                    <input type="password" id="password" name="password" placeholder="{{ __('register.password_placeholder') }}" required />
                    <small style="font-size: 10px; color: rgba(0, 0, 0, 0.5); display: block; margin-top: 3px; text-align: left;">
                        {{ __('register.password_note') }}
                    </small>
                    <div class="error-msg" id="password_err"></div>
                </div>
                <div>
                    <label for="confirm_password">{{ __('register.confirm_password') }}</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="{{ __('register.confirm_password_placeholder') }}" required />
                    <div class="error-msg" id="confirm_password_err"></div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="user_image">{{ __('register.upload_image') }}</label>
                    <input type="file" id="user_image" name="user_image" accept="image/*" required />
                    <div class="error-msg" id="user_image_err"></div>
                </div>
            </div>

            <button type="submit" id="register-btn" class="btn">{{ __('register.register_btn') }}</button>
        </form>
    </div>


    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

   // Track validation state
const uniqueFieldStatus = {
    username: false,
    email: false,
    phone_number: false
};

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function check_unique(fieldId) {
    const fieldValue = $("#" + fieldId).val();
    const msgSpan = $("#" + fieldId + "_check_msg");

    if (fieldValue.trim() === "") {
        msgSpan.text("").css("color", "");
        uniqueFieldStatus[fieldId] = false;
        return;
    }

    $.post('/check-unique', {
        field: fieldId,
        value: fieldValue
    }, function(response) {
        msgSpan.addClass("text-sm").css({
            "font-size": "12px",
            "margin-top": "2px"
        });

        if (response.available) {
            msgSpan.text(fieldId + " is available").css("color", "green");
            uniqueFieldStatus[fieldId] = true;
        } else {
            msgSpan.text(fieldId + " is already taken").css("color", "red");
            uniqueFieldStatus[fieldId] = false;
        }
    });
}

function submitForm(event) {
    event.preventDefault();

    // Check if all unique fields are valid (green)
    for (const field in uniqueFieldStatus) {
        if (!uniqueFieldStatus[field]) {
            alert(`Please make sure the ${field} is available before submitting.`);
            return;
        }
    }

    $("#success-msg").hide();
    $(".error-msg").hide().html("");

    const formData = new FormData($("#registrationForm")[0]);

    $.ajax({
        url: "/submit",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === "success") {
                $("#success-msg").show();
                $("#registrationForm")[0].reset();
                window.scrollTo(0, 0);
            } else {
                $(".error-msg").each(function () {
                    const id = $(this).attr("id").replace("_err", "");
                    if (response[id]) {
                        $(this).show().html(response[id]);
                    }
                });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    Object.keys(errors).forEach(function(field) {
                        const errorField = $("#" + field + "_err");
                        if (errorField.length) {
                            errorField.show().html(errors[field][0]);
                        }
                    });
                }
            } else {
                console.error("Error:", xhr.status, xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        }
    });
}

$("#registrationForm").on("submit", submitForm);

 // Password validation and confirm password check
        $(document).ready(function(){
            const passwordInput = $("#password");
            const confirmPasswordInput = $("#confirm_password");

            function validatePassword() {
                const password = passwordInput.val();
                let errorMessage = "";

                if(/\s+/.test(password)) errorMessage = "Password must not contain any whitespaces";
                else if(password.length < 8) errorMessage = "Password must be at least 8 characters long";
                else if(!/[0-9]/.test(password)) errorMessage = "Password must contain at least 1 number";
                else if(!/[^a-zA-Z0-9\s]/.test(password)) errorMessage = "Password must contain at least 1 special character";

                if(errorMessage){
                    $("#password_err").show().html(errorMessage);
                    passwordInput.css("border", "2px solid #ff6b6b");
                    return false;
                } else {
                    $("#password_err").hide().html("");
                    passwordInput.css("border", "1px solid #ccc");
                    return true;
                }
            }

            function validateConfirmPassword() {
                if(passwordInput.val() !== confirmPasswordInput.val()){
                    $("#confirm_password_err").show().html("Passwords do not match");
                    confirmPasswordInput.css("border", "2px solid #ff6b6b");
                    return false;
                } else {
                    $("#confirm_password_err").hide().html("");
                    confirmPasswordInput.css("border", "1px solid #ccc");
                    return true;
                }
            }

            passwordInput.on("input", validatePassword);
            confirmPasswordInput.on("input", validateConfirmPassword);

            $("#registrationForm").on("submit", function(e) {
                if(!validatePassword() || !validateConfirmPassword()){
                    e.preventDefault();
                }
            });
        });
 //Whatsapp Number Validation
         function checkWhatsApp() {
            const number = document.getElementById('whatsapp_phone_number').value;
            const msgDiv = document.getElementById('whatsapp_phone_number-check-msg');
            const errDiv = document.getElementById('whatsapp_phone_number_err');
            const validBtn = document.getElementById('validBtn');

            msgDiv.textContent = '';
            errDiv.textContent = '';

        

            validBtn.textContent = 'Validating...';

            $.ajax({
                url: "{{ route('check.whatsapp') }}",
                type: 'POST',
                data: { 
                    whatsapp_phone_number: number 
                },
                success: function(data) {
                    validBtn.textContent = 'Validate';
                    if (data.valid) {
                        msgDiv.innerHTML = '<span style="color: green;">✅ Valid WhatsApp number</span>';
                    } else {
                        msgDiv.innerHTML = '<span style="color: red;">❌ ' + (data.message || 'Invalid WhatsApp number')+ '</span>';
                    }
                },
                error: function(xhr) {
                    validBtn.textContent = 'Validate';
                    console.error('Error response:', xhr.responseText);//debug
                     try {
                const response = JSON.parse(xhr.responseText);
                let errorMessage = 'Validation failed. Please Try again later.'
                errDiv.textContent = response.message || errorMessage;
                } catch (e) {
                errDiv.textContent = errorMessage;
                }
                errDiv.textContent = errorMessage;
                errDiv.classList.remove('hidden');
                }
            });
        }

    </script>
</body>
</html>
