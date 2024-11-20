<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FIEND</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 text-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-3xl font-bold text-center text-violet-500 mb-6">Login to FIEND</h2>
        <form id="loginForm">
            @csrf

            <div class="mb-6">
                <label for="phone" class="block text-lg font-semibold mb-2">Phone Number</label>
                <input type="text" id="phone" name="phone" required
                    class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-lg font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>

            <div class="text-center">
                <button type="submit"
                    class="px-6 py-3 bg-violet-500 text-white font-bold rounded-lg shadow-md hover:bg-violet-600 transition">
                    Login
                </button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (event) {
                event.preventDefault();

                const phone = $('#phone').val();
                const password = $('#password').val();

                // Regex for PH phone number validation
                const phoneRegex = /^(09|\+639)\d{9}$/;

                if (!phoneRegex.test(phone)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Input',
                        text: 'Please enter a valid Philippine phone number (e.g., 09123456789 or +639123456789).',
                    });
                    return;
                }

                if (password.length < 6) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Input',
                        text: 'Password must be at least 6 characters long.',
                    });
                    return;
                }

                // AJAX request
                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        phone: phone,
                        password: password
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.message,
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your request.',
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
