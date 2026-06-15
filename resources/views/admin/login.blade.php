<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for eye icon -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
          <style>
            /* Hilangkan ikon show password bawaan Edge */
            input[type="password"]::-ms-reveal,
            input[type="password"]::-ms-clear {
                display: none;
            }

            /* Versi Chromium Edge terbaru */
            ::-webkit-credentials-auto-fill-button,
            ::-webkit-strong-password-auto-fill-button {
                visibility: hidden;
                pointer-events: none;
            }
            </style>
</head>
<body class="min-h-dvh flex items-center justify-center bg-no-repeat bg-center sm:bg-top bg-cover"
      style="background-image: url('/images/bg-kelurahan.png')">

    <div class="absolute inset-0 bg-black/50 sm:bg-black/40"></div> <!-- lapisan gelap -->

    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">

    <div class="bg-white/90 shadow-xl rounded-lg p-6 sm:p-10 w-full max-w-sm sm:max-w-md">
        <h2 class="text-xl sm:text-2xl font-bold text-center mb-6">LOGIN ADMIN</h2>

        @if ($errors->any())
            <p class="text-red-600 text-sm font-medium text-center mb-3">
                {{ $errors->first() }}
            </p>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <label class="font-semibold text-sm">Username</label>
            <input
                type="text"
                name="username"
                required
                class="w-full px-3 py-2 border rounded mb-4 focus:outline-none focus:ring focus:ring-blue-300"
            >

            <label class="font-semibold text-sm">Password</label>
            <div class="relative mb-8">

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full h-11 px-3 pr-12 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
                >

                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">

                    <i id="eyeIcon" class="fa-solid fa-eye-slash"></i>

                </button>

            </div>

        <button
            type="submit"
            class="w-full bg-blue-700 hover:bg-blue-500 text-white py-2 sm:py-2.5 rounded font-semibold">
            Login
        </button>
                </form>
            </div>

<script>
    function togglePassword() {

    const pwd = document.getElementById('password');
    const eye = document.getElementById('eyeIcon');

    if (pwd.type === 'password') {

        pwd.type = 'text';

        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');

    } else {

        pwd.type = 'password';

        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    }
}
</script>

</body>
</html>
