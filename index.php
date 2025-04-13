<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="public/assets/css/style.css">
    </head>

    <body>
        <?php include 'templates/header.php' ?>
        <div class="container">
            <form id="registrationForm" method="post" enctype="multipart/form-data" onsubmit="return submitForm(event)">
                <h2>Registration</h2>
            
            <div id="success-msg" class="success-msg">Registration Successful!</div>
            
                <div class="input-group">
                    <div>
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                        <div class="error-msg" id="full_name_err"></div>
                </div>
                    <div>
                        <label for="user_name">Username</label>
                        <input type="text" id="user_name" class="validate-field" name="user_name" placeholder="Enter your username" required onInput = "check_uniqueness()">
                        <div class="error-msg" id="user_name_err"></div>
                </div>
                </div>

                <div class="input-group">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" class="validate-field" name="email" placeholder="Enter your email" required onInput = "check_uniqueness()">
                        <div class="error-msg" id="email_err"></div>
                </div>
                    <div>
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" class="validate-field" name="phone" placeholder="Enter your phone number" required onInput = "check_uniqueness()">
                        <div class="error-msg" id="phone_err"></div>
                </div>
                </div>

                <div class="input-group">
                    <div>
                        <label for="whatsapp">WhatsApp Number</label>
                        <input type="tel" id="whatsapp" name="whatsapp" placeholder="Enter your WhatsApp number" required>
                        <div class="error-msg" id="whatsapp_err"></div>
                </div>
                    <div>
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter your address" required>
                        <div class="error-msg" id="address_err"></div>
                </div>
                </div>
                <div class="input-group">
                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <small style="font-size: 10px; color: rgba(0, 0, 0, 0.5); display: block; margin-top: 3px; text-align: left;">Password must be at least 8 characters with at least 1 number and 1 special character, and must not contain any white spaces</small>
                        <div class="error-msg" id="password_err"></div>
                </div>
                    <div>
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <div class="error-msg" id="confirm_password_err"></div>
                </div>
                </div>

                <div class="input-group">
                    <div>
                        <label for="user_image">Upload Image</label>
                        <input type="file" id="user_image" name="user_image" accept="image/*" required>
                        <div class="error-msg" id="user_image_err"></div>
                </div>
                </div>

                <button type="submit" id="register-btn" class="btn">Register</button>
            </form>
        </div>
        <?php include 'templates/footer.php' ?>

        //Send request for server-side validation and insertion to DB
        <script src="script.js"></script>
        <script>
            function submitForm(event) {
                //to prevent the form from reloading after submission
                event.preventDefault();

                //reset all the dynamic divs
                document.getElementById("success-msg").style.display = "none";
                document.querySelectorAll('.error-msg').forEach(element =>
                {
                    element.style.display = "none"; 
                    element.innerHTML = "";
                });
                
                //set and send the request to the main server page (DB_Ops.php)
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open('POST', 'config/DB_Ops.php', true);

                var formData = new FormData(document.getElementById('registrationForm'));
                xmlHttp.send(formData);

                // Handle response from DB_Ops.php
                var isSuccessful = false;

                xmlHttp.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status === 200)
                    {
                        var isJson;
                        try
                        {
                            var jsonResponse = JSON.parse(this.responseText);
                            isJson = true;
                        }
                        catch (e)
                        {
                            isJson = false;
                        }

                        if (isJson)
                        {
                            document.querySelectorAll('.error-msg').forEach(element =>
                            {
                                var responseArrayKey = element.id.slice(0, -4);
                                var elementResponse = jsonResponse[responseArrayKey];
                                if (elementResponse !== "")
                                {
                                    element.style.display = "block"; 
                                    element.innerHTML = elementResponse;
                                }
                            });
                        }
                        else
                        {
                            isSuccessful = true;
                        }
                    }
                };

                //now, connect to upload.php, to handle the uploaded image
                //set and send the request to upload.php
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open('POST', 'upload.php', true);
                xmlHttp.send(formData);

                //process the response
                xmlHttp.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status === 200)
                    {
                        var responseText = this.responseText;
                        var firstWord = responseText.trim().split(" ")[0];

                        if (firstWord == "Error")
                        {
                            document.getElementById("user_image_err").innerText = responseText;
                        }
                        else if (isSuccessful)
                        {
                            document.getElementById("success-msg").style.display = "block"; 
                        }
                    }
                };
            }
        </script>

        //Password validation section
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                    // Password validation
                    const passwordInput = document.getElementById('password');
                    const confirmPasswordInput = document.getElementById('confirm_password');

                    passwordInput.addEventListener('input', validatePassword);
                    confirmPasswordInput.addEventListener('input', validateConfirmPassword);

                    function validatePassword() {
                        const password = passwordInput.value;
                        let isValid = true;
                        let errorMessage = '';

                        // Check for any whitespaces
                        if (/\s+/.test(password)) {
                        isValid = false;
                        errorMessage = 'Password must not contain any whitespaces';
                        }
                        // Check password length
                        else if (password.length < 8) {
                            isValid = false;
                            errorMessage = 'Password must be at least 8 characters long';
                        }
                        // Check for number
                        else if (!/[0-9]/.test(password)) {
                            isValid = false;
                            errorMessage = 'Password must contain at least 1 number';
                        }
                        // Check for special character
                        else if (!/[^a-zA-Z0-9\s]/.test(password)) {
                            isValid = false;
                            errorMessage = 'Password must contain at least 1 special character';
                        }

                        // Apply validation styles
                        if (!isValid) {
                            passwordInput.style.border = '2px solid #ff6b6b';

                            // Create or update error message
                            let errorElement = document.getElementById('password-error');
                            if (!errorElement) {
                                errorElement = document.createElement('span');
                                errorElement.id = 'password-error';
                                errorElement.style.color = '#ff6b6b';
                                errorElement.style.fontSize = '12px';
                                errorElement.style.display = 'block';
                                errorElement.style.marginTop = '5px';
                                passwordInput.parentNode.appendChild(errorElement);
                            }
                            errorElement.textContent = errorMessage;
                        } else {
                            passwordInput.style.border = '1px solid #ccc';

                            // Remove error message if it exists
                            const errorElement = document.getElementById('password-error');
                            if (errorElement) {
                                errorElement.remove();
                            }
                        }

                        // Always check confirm password when password changes
                        if (confirmPasswordInput.value) {
                            validateConfirmPassword();
                        }

                        return isValid;
                    }

                    function validateConfirmPassword() {
                        const password = passwordInput.value;
                        const confirmPassword = confirmPasswordInput.value;
                        let isValid = true;

                        // Check if passwords match
                        if (password !== confirmPassword) {
                            isValid = false;
                            confirmPasswordInput.style.border = '2px solid #ff6b6b';

                            // Create or update error message
                            let errorElement = document.getElementById('confirm-password-error');
                            if (!errorElement) {
                                errorElement = document.createElement('span');
                                errorElement.id = 'confirm-password-error';
                                errorElement.style.color = '#ff6b6b';
                                errorElement.style.fontSize = '12px';
                                errorElement.style.display = 'block';
                                errorElement.style.marginTop = '5px';
                                confirmPasswordInput.parentNode.appendChild(errorElement);
                            }
                            errorElement.textContent = 'Passwords do not match';
                        } else {
                            confirmPasswordInput.style.border = '1px solid #ccc';

                            // Remove error message if it exists
                            const errorElement = document.getElementById('confirm-password-error');
                            if (errorElement) {
                                errorElement.remove();
                            }
                        }

                        return isValid;
                    }

                    // Add form validation before submit
                    const form = document.getElementById('registrationForm');
                    const originalSubmitForm = window.submitForm;

                    window.submitForm = function(event) {
                        event.preventDefault();

                        // Validate password and confirm password
                        const isPasswordValid = validatePassword();
                        const isConfirmPasswordValid = validateConfirmPassword();

                        // If both validations pass, proceed with the original submit function
                        if (isPasswordValid && isConfirmPasswordValid) {
                            // Call the original submitForm function
                            originalSubmitForm(event);
                        }
                    };
                }
            );
        </script>

        //Checking Uniqueness handling and AJAX
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".validate-field").on("input", function() {
                    let field = $(this).attr("id"); // Get field ID (user_name, email, phone)
                    check_uniqueness(field);
                });
            });
    
            function check_uniqueness(field) {
                let value = $("#" + field).val();
                let registerBtn = $("#register-btn");
            
                if (value.trim() === "") {
                    $("#" + field + "-check").html(""); // Clear message if empty
                    checkAllFields(); // Check if all fields are valid before enabling the button
                    return;
                }
            
                jQuery.ajax({
                    url: "config/check_uniqueness.php",
                    data: { field: field, value: value },
                    type: "POST",
                    success: function(data) {
                        let response = JSON.parse(data);
                        let messageSpan = $("#" + field + "-check");
            
                        if (response.available) {
                            messageSpan.html("<span style='color: green; font-size: 11px;'>" + field.replace("_", " ") + " is available</span>");
                            $("#" + field).attr("data-valid", "true"); // Mark field as valid
                        } else {
                            messageSpan.html("<span style='color: red; font-size: 11px;'>" + field.replace("_", " ") + " is already taken</span>");
                            $("#" + field).attr("data-valid", "false"); // Mark field as invalid
                        }
            
                        checkAllFields(); // Check if all fields are valid before enabling the button
                    },
                    error: function() {
                        $("#" + field + "-check").html("<span style='color: red; font-size: 11px;'>Error checking " + field.replace("_", " ") + "</span>");
                    }
                });
            }
    
            function checkAllFields() {
                let allValid = true;
            
                $(".validate-field").each(function() {
                    if ($(this).attr("data-valid") === "false") {
                        allValid = false;
                    }
                });
            
                $("#register-btn").prop("disabled", !allValid); // Enable if all fields are valid
            }
        </script>
    </body>
</html>
