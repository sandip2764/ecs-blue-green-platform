<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <title>Personal Details</title>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-md p-4 flex items-center justify-between">
    <div class="flex items-center space-x-2">
      <a href="../profile.php">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <p class="text-base font-semibold">Personal Details</p>
        <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
      </div>
    </div>
  </header>

  <!-- Content -->
  <main class="p-4 space-y-4">

    <h2 class="text-xl font-bold">Profile Details</h2>

    <div class="bg-white rounded-xl p-6 shadow text-center space-y-4">

<!-- Profile Image -->
<div class="relative flex justify-center">
  <img src="https://randomuser.me/api/portraits/men/56.jpg" class="w-24 h-24 rounded-full border-4 border-green-500 shadow-sm" alt="Profile" />
  
  <!-- Verified Badge -->
  <div class="absolute -bottom-3 flex justify-center w-full">
    <div class="animate-ping absolute inline-flex h-6 w-6 rounded-full bg-blue-400 opacity-75"></div>
    <div class="relative inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-600 text-white text-xs font-bold shadow-md">
      ✓
    </div>
  </div>
</div>

<!-- Role -->
<p class="text-sm font-medium text-black-800 mt-4">Technician</p>

<!-- Hero ID -->
<p class="text-xs text-gray-500">Hero ID: <span class="font-semibold">KFHWBSP241028333</span></p>


      <!-- Rating -->
      <div class="flex justify-center gap-1 text-yellow-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.751l-6 5.849L19.335 24 12 20.13 4.665 24 6 15.6l-6-5.849 8.332-1.733z"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.751l-6 5.849L19.335 24 12 20.13 4.665 24 6 15.6l-6-5.849 8.332-1.733z"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.751l-6 5.849L19.335 24 12 20.13 4.665 24 6 15.6l-6-5.849 8.332-1.733z"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.751l-6 5.849L19.335 24 12 20.13 4.665 24 6 15.6l-6-5.849 8.332-1.733z"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.431L24 9.751l-6 5.849L19.335 24 12 20.13 4.665 24 6 15.6l-6-5.849 8.332-1.733z"/></svg>
      </div>

      <!-- Details -->
      <div class="text-left space-y-4">

        <div>
          <p class="text-sm text-gray-600">Name</p>
          <p class="text-lg font-bold">Ranjit Ghosh</p>
        </div>

        <div>
          <p class="text-sm text-gray-600">Working Zone</p>
          <p class="text-lg font-bold">Ballygunge, Kolkata, WB</p>
        </div>

        <div>
          <p class="text-sm text-gray-600">Date of Birth</p>
          <p class="text-lg font-bold">10 May 1999</p>
        </div>

        <div>
          <p class="text-sm text-gray-600">Experience</p>
          <p class="text-lg font-bold">4+ Years</p>
        </div>

      </div>
    </div>
  </main>

</body>
</html>
