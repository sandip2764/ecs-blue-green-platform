<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Earnings</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>
<body class="bg-gray-50 text-gray-800 overflow-auto min-h-screen">
  <!-- Header -->
  <header class="bg-white px-4 py-2 shadow">
    <h2 class="font-semibold text-lg">Earnings</h2>
    <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
  </header>

  <!-- Tabs -->
  <div class="flex justify-around bg-gray-100 mt-1">
    <button onclick="switchTab('daily')" id="dailyTab" class="py-2 px-4 font-medium border-b-2 border-black text-black">Daily</button>
    <button onclick="switchTab('weekly')" id="weeklyTab" class="py-2 px-4 font-medium border-b-2 border-transparent text-gray-400">Weekly</button>
  </div>

  <!-- Daily Content -->
  <section id="dailyContent" class="p-4 pb-28">
    <div class="bg-blue-100 text-sm font-medium py-2 px-3 rounded mb-4">
      <input type="date" class="bg-blue-100 outline-none cursor-pointer w-full" value="2025-05-21" />
    </div>

    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h3 class="text-lg font-bold mb-2">Total payout</h3>
      <p class="text-green-600 font-bold text-xl">₹0</p>
    </div>

    <h3 class="font-semibold mb-2">Performance</h3>
    <div class="space-y-4">
      <div class="bg-blue-50 rounded-2xl shadow p-6 text-center">
        <p class="font-bold text-3xl">0h 0m</p>
        <p class="text-gray-500 mt-1">Active Hours</p>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-green-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Tasks Completed</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-blue-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Jobs Picked</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-red-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Complaints</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-yellow-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Jobs Missed</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Weekly Content -->
  <section id="weeklyContent" class="p-4 pb-28 hidden">
    <div class="bg-blue-100 text-sm font-medium py-2 px-3 rounded mb-4 flex justify-between items-center gap-2">
      <input type="date" class="bg-blue-100 outline-none cursor-pointer w-full" value="2025-05-19" />
      <span class="mx-1">to</span>
      <input type="date" class="bg-blue-100 outline-none cursor-pointer w-full" value="2025-05-21" />
    </div>

    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h3 class="text-lg font-bold mb-2">Total payout</h3>
      <p class="text-green-600 font-bold text-xl">₹0</p>
    </div>

    <h3 class="font-semibold mb-2">Performance</h3>
    <div class="space-y-4">
      <div class="bg-blue-50 rounded-2xl shadow p-6 text-center">
        <p class="font-bold text-3xl">0h 0m</p>
        <p class="text-gray-500 mt-1">Active Hours</p>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-green-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Tasks Completed</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-blue-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Jobs Picked</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-red-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Complaints</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4 text-center">
          <p class="text-yellow-600 text-2xl font-bold">0</p>
          <p class="text-gray-500 text-sm">Jobs Missed</p>
        </div>
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

  <script>
    function switchTab(tab) {
      const tabs = ['daily', 'weekly'];
      tabs.forEach(t => {
        document.getElementById(`${t}Content`).classList.add('hidden');
        document.getElementById(`${t}Tab`).classList.remove('border-black', 'text-black');
        document.getElementById(`${t}Tab`).classList.add('text-gray-400', 'border-transparent');
      });

      document.getElementById(`${tab}Content`).classList.remove('hidden');
      document.getElementById(`${tab}Tab`).classList.remove('text-gray-400', 'border-transparent');
      document.getElementById(`${tab}Tab`).classList.add('border-black', 'text-black');
    }
  </script>
</body>
</html>
