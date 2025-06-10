<!DOCTYPE html>
<html>
<head>
    <title>New registered user</title>
</head>
<body>
    <h2>New registered user</h2>
    <p>A new user <strong>{{  $user['name']}}</strong> is registered to the system.</p>
    <h3>User Details:</h3>
    <ul>
        <li><strong>Name:</strong> {{  $user['name'] }}</li>
        <li><strong>Username:</strong> {{ $user['username'] }}</li>
        <li><strong>Email:</strong> {{  $user['email'] }}</li>
        <li><strong>Phone number:</strong> {{  $user['phone_number'] }}</li>
        <li><strong>WhatsApp number:</strong> {{  $user['whatsapp_number'] }}</li>

    </ul>
</body>

</html>
