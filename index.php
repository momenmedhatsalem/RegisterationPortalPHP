<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
<?php include 'templates/header.php'?> 
    <div class="container">
        <form id="registrationForm" method="post" enctype="multipart/form-data" onsubmit="return submitForm(event)">
            <h2>Registration</h2>

            <div class="input-group">
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                </div>
                <div>
                    <label for="user_name">Username</label>
                    <input type="text" id="user_name" class="validate-field"name="user_name" placeholder="Enter your username" required onInput = "check_uniqueness()">
                    <span id="user_name-check"></span>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" class="validate-field" name="email" placeholder="Enter your email" required onInput = "check_uniqueness()">
                    <span id="email-check"></span>
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" class="validate-field" name="phone" placeholder="Enter your phone number" required onInput = "check_uniqueness()">
                    <span id="phone-check"></span>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="whatsapp">WhatsApp Number</label>
                    <input type="tel" id="whatsapp" name="whatsapp" placeholder="Enter your WhatsApp number" required>
                </div>
                <div>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter your address" required>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="user_image">Upload Image</label>
                    <input type="file" id="user_image" name="user_image" accept="image/*" required>
                </div>
            </div>

            <button type="submit" id="register-btn" class="btn" disabled>Register</button>
        </form>
    </div>
<?php include 'templates/footer.php'?>

<script src="script.js"></script>
<script>
    function submitForm(event) {
        //to prevent the form from reloading after submission
        event.preventDefault();

        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open('POST', 'config/DB_Ops.php', true);
        //xmlHttp.setRequestHeader('Content-Type', 'multipart/form-data');

        var formData = new FormData(document.getElementById('registrationForm'));

        // Convert FormData to URL-encoded string
        /*var data = '';
        formData.forEach(function(value, key) {
            data += encodeURIComponent(key) + '=' + encodeURIComponent(value) + '&';
        });
        data.slice(0, -1);*/

        // Send the request with the form data in the body
        xmlHttp.send(formData);
        
        // Handle response from the server
        xmlHttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status === 200) {
                //document.getElementById('responseDiv').innerHTML = this.responseText;
                alert(this.responseText);
                //TODO: handle the response text and display it in the appropriate parts of the form
            }
        };
    } 
    </script>
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
