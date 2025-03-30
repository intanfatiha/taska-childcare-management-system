<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/Taska-Hikmah-login.jpg') }}" type="image/png">
  <title>LITTLECARE: TASKA HIKMAH</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/Taska-Hikmah-login.jpg') }}');">


  <div class="min-h-screen flex flex-col justify-start items-center pt-20">
    <!-- Welcome Section -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mt-10">
      <div class="flex items-center justify-center mb-6 space-x-4">
        <!-- Logo and Title -->
        <img src="{{ asset('assets/ppuk_logo.png') }}" alt="Tuition Centre Logo" style="width: 150px; height: auto;" class="mx-auto">
        <h1 class="text-3xl font-semibold text-center text-gray-800">LITTLECARE: TASKA HIKMAH CHILDCARE MANAGEMENT SYSTEM</h1>
      </div>

      <!-- Conditional Rendering (if user is logged in) -->
      <div id="user-buttons" class="flex justify-center space-x-4">
        <!-- Login and Register links will show if user is not logged in -->
        <div id="auth-buttons" class="space-x-4">
          <a href="/login" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-all">Login</a>
          <a href="{{ url('/registration') }}" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-all">Register Your Children</a>
          <a href="{{ url('register') }}" class="bg-gray-500 text-white px-3 py-1 rounded-lg hover:bg-gray-600 transition-all">Register </a>

        </div>

        <!-- Dashboard link will show if user is logged in -->
        <div id="dashboard-button" class="hidden space-x-4">
          <a href="/admin-home" class="bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-600 transition-all">Dashboard</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Sample JavaScript to simulate the login state
    const isLoggedIn = false;  // Change this to true to simulate a logged-in user

    if (isLoggedIn) {
      document.getElementById('auth-buttons').classList.add('hidden');
      document.getElementById('dashboard-button').classList.remove('hidden');
    } else {
      document.getElementById('auth-buttons').classList.remove('hidden');
      document.getElementById('dashboard-button').classList.add('hidden');
    }
  </script>
</body>
</html>