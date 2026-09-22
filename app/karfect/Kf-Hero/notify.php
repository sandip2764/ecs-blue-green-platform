<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <title>Notifications</title>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
<header class="bg-white px-4 py-2 shadow">
    <h2 class="font-semibold text-lg">Notifications</h2>
    <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
  </header>

  <!-- Motivational Message -->
  <section class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl mx-4 my-4 p-4 shadow-md">
    <h2 class="text-lg font-bold">Welcome, Hero! 💪</h2>
    <p class="text-sm mt-1">
      Your dedication keeps Kolkata shining brighter every day. Keep up the amazing work. KARFECT is proud to have you on board!
    </p>
  </section>

  <!-- Notifications List -->
  <section class="px-4 space-y-3 pb-6">
    <!-- Example Notification -->
    <div class="bg-white p-3 rounded-xl shadow flex items-start space-x-3">
      <div class="text-green-500 mt-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
        </svg>
      </div>
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-800">You completed 5 services this week! 🎉</p>
        <p class="text-xs text-gray-500 mt-1">Keep it up and unlock bonus rewards.</p>
        <p class="text-xs text-gray-400 mt-1">2 hrs ago</p>
      </div>
    </div>

    <div class="bg-white p-3 rounded-xl shadow flex items-start space-x-3">
      <div class="text-yellow-500 mt-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-800">Reminder: Update your availability 🕒</p>
        <p class="text-xs text-gray-500 mt-1">Clients are searching, don’t miss out!</p>
        <p class="text-xs text-gray-400 mt-1">1 day ago</p>
      </div>
    </div>

    <div class="bg-white p-3 rounded-xl shadow flex items-start space-x-3">
      <div class="text-blue-500 mt-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-800">Your profile was approved ✅</p>
        <p class="text-xs text-gray-500 mt-1">You can now start accepting bookings on KARFECT.</p>
        <p class="text-xs text-gray-400 mt-1">3 days ago</p>
      </div>
    </div>
  </section>

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
      <span class="text-xs mt-1">Profile</span>
    </a>
  </nav>

</body>
</html>
