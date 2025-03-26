<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form id="registrationForm">
            <h2>Registration</h2>

            <div class="input-group">
                <div>
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                </div>
                <div>
                    <label for="user_name">Username</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter your username" required>
                </div>
            </div>

            <div class="input-group">
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
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

            <button type="submit" class="btn">Register</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
<style>
/* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #a7a6d6, #2575fc);
    
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Form Container */
.container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    width: 550px;
    text-align: center;
}

/* Title */
h2 {
    margin-bottom: 25px;
    font-size: 26px;
    font-display: center;
}

/* Input Group (For Two Inputs in One Row) */
.input-group {
    display: flex;
    justify-content: space-between;
    gap: 40px; /* INCREASED SPACE BETWEEN COLUMNS */
    margin-bottom: 20px; /* Space Between Rows */
    margin-right: 40px;
}

.input-group div {
    width: 48%;
}

/* Labels */
label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 8px;
    text-align: left;
}

/* Inputs */
input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
}

input:focus {
    border-color: #6a11cb;
}

/* File Upload Input */
input[type="file"] {
    border: none;
    padding: 5px;
}

/* Register Button */
.btn {
    background: linear-gradient(to right, #a7a6d6, #2575fc);
    border: none;
    color: white;
    padding: 12px;
    width: 100%;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: linear-gradient(to right, #5a0ebc, #1f66db);
}

</style>
