<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add your stylesheets or any other necessary assets here -->
</head>
<body>

    <h2>User Registration</h2>

    <form id="registrationForm">
        <!-- CSRF Token for Laravel Sanctum -->
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

        <!-- Name -->
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <!-- Password -->
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <!-- Password Confirmation -->
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <!-- Submit Button -->
        <button type="button" onclick="registerUser()">Register</button>
    </form>

    <!-- Add your scripts or any other necessary assets here -->
    <script>
        function registerUser() {
            var form = $('#registrationForm')[0];
            var formData = new FormData(form);

            // Send a POST request to your Laravel backend for user registration
            $.ajax({
                url: 'api/register',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    console.log(data);
                    // Handle the response as needed
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>

</body>
</html>
