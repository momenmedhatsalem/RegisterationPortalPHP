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
        <form id="registrationForm">
            <h2>Registration</h2>
            
            <div id="success-msg" class="success-msg">Registration Successful!</div>
            
            <div class="input-group">
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                    <div class="error-msg">Full Name is required</div>
                </div>
                <div>
                    <label for="user_name">Username</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter your username" required>
                    <div class="error-msg">Username is required</div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <div class="error-msg">Valid email is required</div>
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                    <div class="error-msg">Phone number is required</div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="whatsapp">WhatsApp Number</label>
                    <input type="tel" id="whatsapp" name="whatsapp" placeholder="Enter your WhatsApp number" required>
                    <div class="error-msg">WhatsApp number is required</div>
                </div>
                <div>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter your address" required>
                    <div class="error-msg">Address is required</div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <div class="error-msg">Password is required</div>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    <div class="error-msg">Passwords must match</div>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="user_image">Upload Image</label>
                    <input type="file" id="user_image" name="user_image" accept="image/*" required>
                    <div class="error-msg">Please upload an image</div>
                </div>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>
    </div>

    <script src="script.js"></script>
    
<?php include 'templates/footer.php'?> 
</body>
</html>
<js>
    <script>
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
            event.preventDefault(); 
            document.getElementById("success-msg").style.display = "block"; 
        });
        </script>
        
</js>
