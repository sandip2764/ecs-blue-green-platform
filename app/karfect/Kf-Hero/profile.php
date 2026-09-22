<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <title>Profile</title>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col pb-20">

  <!-- Header -->
  <header class="p-4 bg-white flex items-center justify-between shadow-md">
    <div>
      <p class="text-sm font-semibold">Hi, Ranjit Ghosh</p>
      <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023 </p>
    </div>
      <!-- Profile Image -->
      <a href="profile.php">
        <img src="https://randomuser.me/api/portraits/men/56.jpg?crop=faces&fit=crop&h=200&w=200"
            alt="Profile"
            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-green-500 object-cover shadow" />
      </a>
    </div>
  </header>

  <!-- Profile Options -->
  <main class="px-4 py-4 flex-1 overflow-y-auto space-y-3">
    <!-- Reusable Option Item -->
    <template id="option-template">
      <div class="bg-white rounded-xl shadow-sm p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="icon-container p-2 rounded-lg">
            <img class="w-5 h-5 icon" />
          </div>
          <p class="text-sm font-medium title"></p>
        </div>
      </div>
    </template>
    
    <a href="profile menu/personal-details.php" class="block bg-white rounded-xl shadow-sm p-4">
    <div class="flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="bg-green-300 p-2 rounded-lg">
        <img src="https://img.icons8.com/ios/50/user--v1.png" class="w-5 h-5" />
        </div>
        <p class="text-sm font-medium">Personal Details</p>
    </div>
    </div>
    </a>

    <!-- Repeat same pattern for other options below -->
    <a href="profile menu/change-password.php" class="block bg-white rounded-xl shadow-sm p-4 mb-3">
  <div class="flex items-center gap-3">
    <div class="bg-yellow-300 p-2 rounded-lg">
      <img src="https://img.icons8.com/ios/50/password--v1.png" class="w-5 h-5" />
    </div>
    <p class="text-sm font-medium">Change Password</p>
  </div>
</a>

<a href="profile menu/bank-details.php" class="block bg-white rounded-xl shadow-sm p-4">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="bg-purple-300 p-2 rounded-lg">
        <img src="https://img.icons8.com/ios-filled/50/money--v1.png" class="w-5 h-5" />
      </div>
      <p class="text-sm font-medium">Bank Details</p>
    </div>
  </div>
</a>


<a href="profile menu/tutorial-videos.php" class="block bg-white rounded-xl shadow-sm p-4">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="bg-cyan-200 p-2 rounded-lg">
        <img src="https://img.icons8.com/ios-filled/50/tv.png" class="w-5 h-5" />
      </div>
      <p class="text-sm font-medium">Tutorial Videos</p>
    </div>
  </div>
</a>
  
<a href="profile menu/settings.php" class="block bg-white rounded-xl shadow-sm p-4">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="bg-red-300 p-2 rounded-lg">
        <img src="https://img.icons8.com/ios-filled/50/settings.png" class="w-5 h-5" />
      </div>
      <p class="text-sm font-medium">Settings</p>
    </div>
  </div>
</a>

<a href="profile menu/help.php" class="block bg-white rounded-xl shadow-sm p-4">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="bg-orange-300 p-2 rounded-lg">
        <img src="https://img.icons8.com/ios-filled/50/help.png" class="w-5 h-5" />
      </div>
      <p class="text-sm font-medium">Help</p>
    </div>
  </div>
</a>

    <!-- Logout Button -->
    <div class="bg-white mt-4 rounded-xl border border-red-600 p-4 text-center">
      <button class="text-red-600 font-semibold text-base">Logout</button>
    </div>
  </main>

  <!-- Bottom Navigation -->
  <nav class="fixed bottom-0 left-0 right-0 bg-white border-t flex justify-around items-center py-2 shadow-md z-50">
    <a href="dashboard.php" class="flex flex-col items-center justify-center w-full py-1 hover:bg-gray-100">
      <img src="https://img.icons8.com/ios-filled/50/000000/task.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Tasks</span>
    </a>
    <a href="bookings.php" class="flex flex-col items-center justify-center w-full py-1 hover:bg-gray-100">
      <img src="https://img.icons8.com/ios-filled/50/000000/calendar.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Bookings</span>
    </a>
    <a href="notify.php" class="flex flex-col items-center justify-center w-full py-1 hover:bg-gray-100">
      <img src="https://img.icons8.com/?size=100&id=83193&format=png&color=000000" class="w-6 h-6" />
      <span class="text-xs mt-1">Notifications</span>
    </a>
    <a href="earnings.php" class="flex flex-col items-center justify-center w-full py-1 hover:bg-gray-100">
      <img src="https://img.icons8.com/ios-filled/50/000000/rupee.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Earnings</span>
    </a>
    <a href="profile.php" class="flex flex-col items-center justify-center w-full py-1 hover:bg-gray-100">
      <img src="https://img.icons8.com/ios-filled/50/000000/user.png" class="w-6 h-6" />
      <span class="text-xs mt-1 font-bold text-black">Profile</span>
    </a>
  </nav>


</body>
</html>