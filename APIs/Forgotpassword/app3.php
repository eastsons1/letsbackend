<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microsoft OAuth 2.0</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

    <button onclick="loginWithMicrosoft()">Log In with Microsoft</button>

    <script>
        function loginWithMicrosoft() {
            var clientId = '766090b1-948f-4eb3-ad69-9fc723b4e7d8';
            var redirectUri = 'https://stagingclientportal.taxleaf.com/MicrosoftConnect';
            var scope = 'https://graph.microsoft.com/User.Read';
            var loginUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize';

            var url = `${loginUrl}?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=token&scope=${scope}`;

            // Redirect the user to the Microsoft login page
            window.location.href = url;
        }

        // This function will be called when the user is redirected back with the access token
        function handleMicrosoftResponse() {
            var accessToken = getParameterByName('access_token');
            if (accessToken) {
                // Use the access token as needed
                console.log('Access Token:', accessToken);

                // Now, you can make further requests using the access token
                // For example, fetch user details from Microsoft Graph API
                $.ajax({
                    url: 'https://graph.microsoft.com/v1.0/me/',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + accessToken
                    },
                    success: function(response) {
                        console.log('User Details:', response);
                        // Handle user details as needed
						
						alert(response);
                    },
                    error: function(error) {
                        console.error('Error fetching user details:', error);
                    }
                });
            }
        }

        // Helper function to get URL parameters
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Call the handleMicrosoftResponse function when the page loads to handle the redirect
        handleMicrosoftResponse();
    </script>
</body>
</html>
