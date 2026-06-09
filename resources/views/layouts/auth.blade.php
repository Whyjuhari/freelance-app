<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>FreelanceHub - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

</head>

<body
    class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 antialiased min-h-screen transition-colors duration-300">

    <!-- LOGIN FORM -->
    <div id="loginForm" class="flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>


    <script>
        // Toggle between Login and Register
        function showRegister() {
            document.getElementById("loginForm").classList.add("hidden");
            document
                .getElementById("registerForm")
                .classList.remove("hidden");
        }

        function showLogin() {
            document.getElementById("registerForm").classList.add("hidden");
            document.getElementById("loginForm").classList.remove("hidden");
        }

        // Toggle Password Visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>

</html>
