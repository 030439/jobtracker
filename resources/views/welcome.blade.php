<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add your stylesheets or any other necessary assets here -->
</head>
<body>

    <h2>User List</h2>

    <ul id="userList">
        <!-- User list will be appended here dynamically -->
    </ul>

    <!-- Add your scripts or any other necessary assets here -->
    <script>
        $(document).ready(function() {
            // Fetch user list on page load
            fetchUserList();

            function fetchUserList() {
                $.ajax({
                    url: '/api/users',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(data) {
                        // Call function to display the user list
                        displayUserList(data);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }

            function displayUserList(users) {
                // Clear existing list
                $('#userList').empty();

                // Append each user to the list
                users.forEach(function(user) {
                    $('#userList').append('<li>' + user.name + ' - ' + user.email + '</li>');
                });
            }
        });
    </script>

</body>
</html>
