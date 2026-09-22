<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bookings</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <script>
    function showTab(tab) {
      const tabs = ['upcoming', 'completed', 'cancelled'];
      tabs.forEach(t => {
        document.getElementById(t).classList.add('hidden');
        document.getElementById(t + '-btn').classList.remove('border-b-2', 'border-black', 'text-black');
        document.getElementById(t + '-btn').classList.add('text-gray-500');
      });
      document.getElementById(tab).classList.remove('hidden');
      document.getElementById(tab + '-btn').classList.add('border-b-2', 'border-black', 'text-black');
      document.getElementById(tab + '-btn').classList.remove('text-gray-500');
    }

    // Auto-switch tab based on URL query
    window.onload = () => {
      const params = new URLSearchParams(window.location.search);
      const tab = params.get('status');
      if (tab && ['upcoming', 'completed', 'cancelled'].includes(tab)) {
        showTab(tab);
      }
    };
  </script>
</head>
<body class="bg-gray-100 min-h-screen pb-20">

  <!-- Header -->
  <header class="p-4 bg-white shadow">
    <p class="text-sm font-semibold">Bookings</p>
    <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023 </p>
  </header>

  <!-- Tab Navigation -->
  <div class="flex justify-around mt-2 bg-white shadow">
    <button id="upcoming-btn" onclick="showTab('upcoming')" class="w-full py-2 text-center border-b-2 border-black font-medium text-black">Upcoming</button>
    <button id="completed-btn" onclick="showTab('completed')" class="w-full py-2 text-center text-gray-500">Completed</button>
    <button id="cancelled-btn" onclick="showTab('cancelled')" class="w-full py-2 text-center text-gray-500">Cancelled</button>
  </div>

  <!-- Tabs -->
  <main class="p-4 space-y-4">

    <!-- Upcoming -->
    <div id="upcoming">
      <!-- Accepted Booking Card -->
      <div class="bg-white rounded-xl shadow-md p-4 space-y-3">
        <div class="flex items-center gap-3">
          <img src="https://randomuser.me/api/portraits/women/15.jpg" class="w-12 h-12 rounded-full border object-cover" alt="User" />
          <div>
            <p class="font-semibold">Amit Roy</p>
            <p class="text-sm text-gray-500">AC Servicing | Home Appliances</p>
            <p class="text-xs text-yellow-600">⭐ 4.8</p>
          </div>
          <div class="ml-auto text-right">
            <p class="text-green-600 font-semibold text-2xl">₹550</p>
          </div>
        </div>

        <div class="text-sm text-gray-600">
          <p><strong>Address:</strong> 78/B, Lake Gardens, Kolkata</p>
          <p><strong>Contact:</strong> +91 62894 67981</p>
          <p><strong>Slot:</strong> 2:00 PM – 4:00 PM</p>
          <p><strong>Note:</strong> Customer prefers quiet technician.</p>
          <p><strong>Customer Type:</strong> New Customer</p>
          <p><strong>Status:</strong> <span class="text-blue-600 font-medium">Confirmed</span></p>
        </div>

        <div class="flex justify-between gap-3 pt-2">
          <button class="flex-1 px-4 py-2 text-sm text-white bg-green-500 rounded-md hover:bg-green-600">Start Job</button>
          <button class="flex-1 px-4 py-2 text-sm text-white bg-gray-500 rounded-md hover:bg-gray-600">Map</button>
        </div>
      </div>
    </div>

    <!-- Completed -->
    <div id="completed" class="hidden">
      <p class="text-center text-gray-500 py-4">No completed bookings yet.</p>
    </div>

    <!-- Cancelled -->
    <div id="cancelled" class="hidden">
      <p class="text-center text-gray-500 py-4">No cancelled bookings.</p>
    </div>

  </main>

  <!-- Bottom Navigation -->
  <nav class="fixed bottom-0 left-0 right-0 bg-white border-t flex justify-around items-center py-2 shadow-md z-50">
    <a href="dashboard.php" class="flex flex-col items-center justify-center w-full py-1 text-gray-500">
      <img src="https://img.icons8.com/ios-filled/50/000000/task.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Tasks</span>
    </a>
    <a href="bookings.php" class="flex flex-col items-center justify-center w-full py-1 text-black">
      <img src="https://img.icons8.com/ios-filled/50/000000/calendar.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Bookings</span>
    </a>
    <a href="notify.php" class="flex flex-col items-center justify-center w-full py-1 text-gray-500">
      <img src="https://img.icons8.com/?size=100&id=83193&format=png&color=000000" class="w-6 h-6" />
      <span class="text-xs mt-1">Notifications</span>
    </a>
    <a href="earnings.php" class="flex flex-col items-center justify-center w-full py-1 text-gray-500">
      <img src="https://img.icons8.com/ios-filled/50/000000/rupee.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Earnings</span>
    </a>
    <a href="profile.php" class="flex flex-col items-center justify-center w-full py-1 text-gray-500">
      <img src="https://img.icons8.com/ios-filled/50/000000/user.png" class="w-6 h-6" />
      <span class="text-xs mt-1">Profile</span>
    </a>
  </nav>

</body>
</html>
