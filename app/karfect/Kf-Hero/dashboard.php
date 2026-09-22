<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept'])) {
  header("Location: bookings.php?status=upcoming&job=accepted");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hero-Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />

  <style>
    .switch-dot {
      transition: transform 0.3s ease;
    }
    input:checked ~ .dot {
      transform: translateX(1.5rem);
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col pb-20">

  <!-- Header -->
  <header class="p-4 bg-white flex items-center justify-between shadow">
    <div>
      <p class="text-sm font-semibold">Hi, Ranjit Ghosh</p>
      <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
    </div>

    <div class="flex items-center gap-3">
      <!-- Toggle -->
      <div class="flex items-center space-x-2">
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" id="statusToggle" class="sr-only peer">
          <div class="w-12 h-6 bg-gray-300 rounded-full peer-checked:bg-green-500 transition duration-300"></div>
          <div class="dot absolute top-1 left-1 bg-white w-4 h-4 rounded-full switch-dot"></div>
        </label>
        <span id="statusText" class="text-sm text-gray-700">OFFLINE</span>
      </div>

      <!-- Profile Image -->
      <a href="profile.php">
        <img src="https://randomuser.me/api/portraits/men/56.jpg" alt="Profile" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-green-500 object-cover shadow" />
      </a>
    </div>
  </header>

  <!-- Task List -->
  <main class="p-4 space-y-4">
    <!-- Offline Message -->
    <div id="offlineMessage" class="flex flex-col items-center justify-center h-[70vh] text-center text-gray-500 space-y-4 bg-transparent">
      <img src="https://cdn-icons-png.flaticon.com/512/595/595067.png" class="w-24 h-24 opacity-50" />
      <p class="text-lg font-semibold text-gray-600">You are currently <span class="text-red-500">OFFLINE</span></p>
      <p class="text-sm text-gray-500">Please toggle the switch above to go <span class="text-green-600 font-semibold">ONLINE</span> and start receiving tasks.</p>
    </div>

    <!-- Searching Screen -->
    <div id="searchingScreen" class="hidden flex flex-col items-center justify-center h-[70vh] text-center space-y-5 bg-transparent">
      <img src="https://img.icons8.com/?size=100&id=112468&format=png&color=00b300" alt="Loading" class="w-28 h-28 animate-bounce" />
      <p class="text-xl font-bold text-gray-700 animate-pulse">Searching for nearby jobs...</p>
      <p class="text-sm text-gray-500">Please wait while we find a customer for you.</p>
    </div>

    <!-- Job Card -->
    <div id="jobCard" class="hidden bg-white rounded-xl shadow-md p-4 space-y-2">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <img src="https://randomuser.me/api/portraits/women/15.jpg" class="w-12 h-12 rounded-full border object-cover" alt="User" />
          <div>
            <p class="font-semibold">Priya Sharma</p>
            <p class="text-sm text-gray-500">AC Servicing | Home Appliances</p>
            <p class="text-xs text-yellow-600">⭐ 4.8</p>
          </div>
        </div>
        <div class="text-right">
          <p class="text-green-600 font-semibold text-2xl">₹550</p>
          <p class="text-xs text-gray-500">3.2 km • 9 min away</p>
        </div>
      </div>

      <div class="text-sm text-gray-600">
        <p><strong>Address:</strong> 78/B, Lake Gardens, Kolkata</p>
        <p><strong>Slot:</strong> 2:00 PM – 4:00 PM</p>
        <p><strong>Note:</strong> Customer prefers quiet technician.</p>
        <p><strong>Customer Type:</strong> New Customer</p>
      </div>

      <div class="flex items-center justify-between pt-2">
        <div class="text-sm font-semibold text-red-700"><span id="timer">10:00</span></div>
        <div class="flex gap-3">
          <button id="declineBtn" class="px-4 py-1 text-sm text-white bg-red-500 rounded-md hover:bg-red-600">Decline</button>
          <button id="acceptBtn" class="px-4 py-1 text-sm text-white bg-green-500 rounded-md hover:bg-green-600">Accept</button>
        </div>
      </div>
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
      <span class="text-xs mt-1">Profile</span>
    </a>
  </nav>

  <!-- Script -->
  <script>
    const toggle = document.getElementById("statusToggle");
    const statusText = document.getElementById("statusText");
    const jobCard = document.getElementById("jobCard");
    const offlineMessage = document.getElementById("offlineMessage");
    const searchingScreen = document.getElementById("searchingScreen");
    const timerEl = document.getElementById("timer");
    const acceptBtn = document.getElementById("acceptBtn");
    const declineBtn = document.getElementById("declineBtn");

    let timerInterval;
    let searchTimeout = null;
    const TOTAL_TIME = 600;
    const BLANK_DELAY = 5000;

    function startTimer() {
      clearInterval(timerInterval);
      timerInterval = setInterval(() => {
        const now = Math.floor(Date.now() / 1000);
        const jobStart = parseInt(localStorage.getItem("jobStartTime"));
        let timeLeft = TOTAL_TIME - (now - jobStart);

        if (timeLeft <= 0) {
          timerEl.textContent = "00:00";
          clearInterval(timerInterval);
          jobCard.classList.add("hidden");
          searchingScreen.classList.remove("hidden");

          searchTimeout = setTimeout(() => {
            if (!toggle.checked) return;
            const newJobTime = Math.floor(Date.now() / 1000);
            localStorage.setItem("jobStartTime", newJobTime);
            searchingScreen.classList.add("hidden");
            jobCard.classList.remove("hidden");
            startTimer();
          }, BLANK_DELAY);

          return;
        }

        const minutes = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const seconds = String(timeLeft % 60).padStart(2, '0');
        timerEl.textContent = `${minutes}:${seconds}`;
      }, 1000);
    }

    function handleOnline() {
      statusText.textContent = "ONLINE";
      offlineMessage.classList.add("hidden");
      jobCard.classList.add("hidden");
      searchingScreen.classList.remove("hidden");

      searchTimeout = setTimeout(() => {
        if (!toggle.checked) return;
        const jobStartTime = Math.floor(Date.now() / 1000);
        localStorage.setItem("jobStartTime", jobStartTime);
        searchingScreen.classList.add("hidden");
        jobCard.classList.remove("hidden");
        startTimer();
      }, BLANK_DELAY);
    }

    function handleOffline() {
      statusText.textContent = "OFFLINE";
      offlineMessage.classList.remove("hidden");
      searchingScreen.classList.add("hidden");
      jobCard.classList.add("hidden");
      clearInterval(timerInterval);
      clearTimeout(searchTimeout);
      localStorage.removeItem("jobStartTime");
    }

    const isOnline = localStorage.getItem("isOnline") === "true";
    toggle.checked = isOnline;

    if (isOnline) {
      statusText.textContent = "ONLINE";
      offlineMessage.classList.add("hidden");

      const jobStartTime = parseInt(localStorage.getItem("jobStartTime"));
      if (jobStartTime) {
        const now = Math.floor(Date.now() / 1000);
        const timePassed = now - jobStartTime;
        if (timePassed >= TOTAL_TIME) {
          jobCard.classList.add("hidden");
          searchingScreen.classList.remove("hidden");
          timerEl.textContent = "00:00";
          localStorage.removeItem("jobStartTime");

          searchTimeout = setTimeout(() => {
            if (!toggle.checked) return;
            const newJobTime = Math.floor(Date.now() / 1000);
            localStorage.setItem("jobStartTime", newJobTime);
            searchingScreen.classList.add("hidden");
            jobCard.classList.remove("hidden");
            startTimer();
          }, BLANK_DELAY);
        } else {
          jobCard.classList.remove("hidden");
          searchingScreen.classList.add("hidden");
          startTimer();
        }
      } else {
        searchingScreen.classList.remove("hidden");
        searchTimeout = setTimeout(() => {
          if (!toggle.checked) return;
          const jobStartTime = Math.floor(Date.now() / 1000);
          localStorage.setItem("jobStartTime", jobStartTime);
          searchingScreen.classList.add("hidden");
          jobCard.classList.remove("hidden");
          startTimer();
        }, BLANK_DELAY);
      }
    } else {
      handleOffline();
    }

    toggle.addEventListener("change", () => {
      const isOnlineNow = toggle.checked;
      localStorage.setItem("isOnline", isOnlineNow);
      isOnlineNow ? handleOnline() : handleOffline();
    });

    acceptBtn.addEventListener("click", () => {
      localStorage.removeItem("jobStartTime");
      jobCard.classList.add("hidden");
      searchingScreen.classList.remove("hidden");
      window.location.href = 'bookings.php?status=upcoming';
    });

    declineBtn.addEventListener("click", () => {
      localStorage.removeItem("jobStartTime");
      jobCard.classList.add("hidden");
      searchingScreen.classList.remove("hidden");
      searchTimeout = setTimeout(() => {
        if (!toggle.checked) return;
        const newJobTime = Math.floor(Date.now() / 1000);
        localStorage.setItem("jobStartTime", newJobTime);
        searchingScreen.classList.add("hidden");
        jobCard.classList.remove("hidden");
        startTimer();
      }, BLANK_DELAY);
    });
  </script>

</body>
</html>
