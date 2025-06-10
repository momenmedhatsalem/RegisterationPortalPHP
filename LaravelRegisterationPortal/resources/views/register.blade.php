<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('register.registration') }}</title>

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
                        {{ __('register.whatsapp_number_note') }}
                    </small>
                 <button type="button" class="whatsapp_phone_number-btn" id="validBtn" onclick="checkWhatsApp()">{{ __('register.validate') }}</button>
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
 <script>
        window.translations = {
            username_available: "{{ __('register.username_available') }}",
            username_taken: "{{ __('register.username_taken') }}",
            email_available: "{{ __('register.email_available') }}",
            email_taken: "{{ __('register.email_taken') }}",
            phone_number_available: "{{ __('register.phone_number_available') }}",
            phone_number_taken: "{{ __('register.phone_number_taken') }}",
            password_whitespace: "{{ __('register.password_whitespace') }}",
            password_length: "{{ __('register.password_length') }}",
            password_number: "{{ __('register.password_number') }}",
            password_special: "{{ __('register.password_special') }}",
            password_mismatch: "{{ __('register.password_mismatch') }}",
            whatsapp_valid: "{{ __('register.whatsapp_valid') }}",
            whatsapp_invalid: "{{ __('register.whatsapp_invalid') }}",
            validation_failed: "{{ __('register.validation_failed') }}",
            unique_field_error: "{{ __('register.unique_field_error') }}"
        };
        console.log("Current locale: {{ app()->getLocale() }}");
        console.log("Translations:", window.translations);
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Map field IDs to translated field names
        const fieldTranslations = {
            username: "{{ __('register.username') }}",
            email: "{{ __('register.email') }}",
            phone_number: "{{ __('register.phone_number') }}"
        };

        // Function to replace :field placeholder
        function translateMessage(key, replacements = {}) {
            let message = window.translations[key] || key;
            for (const [placeholder, value] of Object.entries(replacements)) {
                const replacement = fieldTranslations[value] || value;
                message = message.replace(`:${placeholder}`, replacement);
            }
            return message;
        }

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
                    msgSpan.text(translateMessage(`${fieldId}_available`, { field: fieldId })).css("color", "green");
                    uniqueFieldStatus[fieldId] = true;
                } else {
                    msgSpan.text(translateMessage(`${fieldId}_taken`, { field: fieldId })).css("color", "red");
                    uniqueFieldStatus[fieldId] = false;
                }
            });
        }

        function submitForm(event) {
            event.preventDefault();

            for (const field in uniqueFieldStatus) {
                if (!uniqueFieldStatus[field]) {
                    alert(translateMessage('unique_field_error', { field: field }));
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
                        alert(translateMessage('validation_failed'));
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

                if(/\s+/.test(password)) errorMessage = translateMessage('password_whitespace');
                else if(password.length < 8) errorMessage = translateMessage('password_length');
                else if(!/[0-9]/.test(password)) errorMessage = translateMessage('password_number');
                else if(!/[^a-zA-Z0-9\s]/.test(password)) errorMessage = translateMessage('password_special');

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
                    $("#confirm_password_err").show().html(translateMessage('password_mismatch'));
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

            // Bind WhatsApp validation button
            $("#validBtn").on("click", checkWhatsApp);
        });

        function checkWhatsApp() {
            const number = document.getElementById('whatsapp_phone_number').value;
            const msgDiv = document.getElementById('whatsapp_phone_number-check-msg');
            const errDiv = document.getElementById('whatsapp_phone_number_err');
            const validBtn = document.getElementById('validBtn');

            msgDiv.textContent = '';
            errDiv.textContent = '';

            validBtn.textContent = "{{ __('register.validate') }}";

            $.ajax({
                url: "{{ route('check.whatsapp') }}",
                type: 'POST',
                data: {
                    whatsapp_phone_number: number
                },
                success: function(data) {
                    validBtn.textContent = "{{ __('register.validate') }}";
                    if (data.valid) {
                        msgDiv.innerHTML = '<span style="color: green;">✅ ' + translateMessage('whatsapp_valid') + '</span>';
                    } else {
                        msgDiv.innerHTML = '<span style="color: red;">❌ ' + (data.message || translateMessage('whatsapp_invalid')) + '</span>';
                    }
                },
                error: function(xhr) {
                    validBtn.textContent = "{{ __('register.validate') }}";
                    console.error('Error response:', xhr.responseText);
                    try {
                        const response = JSON.parse(xhr.responseText);
                        let errorMessage = translateMessage('validation_failed');
                        errDiv.textContent = response.message || errorMessage;
                    } catch (e) {
                        errDiv.textContent = translateMessage('validation_failed');
                    }
                    errDiv.classList.remove('hidden');
                }
            });
        }
    </script>
</body>
</html>
