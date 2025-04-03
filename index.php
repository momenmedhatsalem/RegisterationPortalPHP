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
                        <input type="text" id="user_name" name="user_name" placeholder="Enter your username" required>
                        <div class="error-msg" id="user_name_err"></div>
                </div>
                </div>

                <div class="input-group">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        <div class="error-msg" id="email_err"></div>
                </div>
                    <div>
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
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

                <button type="submit" class="btn">Register</button>
            </form>
        </div>
        <?php include 'templates/footer.php' ?>

        <script src="script.js"></script>
        <script>
            function submitForm(event) {
                //to prevent the form from reloading after submission
                event.preventDefault();

                //set and send the request
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open('POST', 'config/DB_Ops.php', true);

                var formData = new FormData(document.getElementById('registrationForm'));
                xmlHttp.send(formData);

                //rest all the dynamic divs
                document.getElementById("success-msg").style.display = "none";
                document.querySelectorAll('.error-msg').forEach(element =>
                {
                    element.style.display = "none"; 
                    element.innerHTML = "";
                });

                // Handle response from the server
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
                            document.getElementById("success-msg").style.display = "block"; 
                        }
                    }
                };
            }

            //Password validation section
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
    </body>
</html>
