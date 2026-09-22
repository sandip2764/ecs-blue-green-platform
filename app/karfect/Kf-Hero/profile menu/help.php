<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <title>Help</title>
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
        <p class="text-base font-semibold">Help & Support</p>
        <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
      </div>
    </div>
  </header>

  <main class="p-4 space-y-6">
    <h2 class="text-xl font-bold">Help Center</h2>

    <!-- Complain about Customer -->
    <div class="bg-white rounded-xl p-4 space-y-4 shadow">
      <p class="text-base font-semibold">Complain About Customer</p>
      <select id="complaintType" class="w-full border rounded-lg p-2">
        <option value="">Select Issue Type</option>
        <option value="payment">Payment Related</option>
        <option value="behavior">Behavior Related</option>
        <option value="other">Other</option>
      </select>
      <input id="bookingId" type="text" placeholder="Enter Booking ID" class="w-full border rounded-lg p-2" />
      <input id="complaintDate" type="date" class="w-full border rounded-lg p-2" />
      <button onclick="submitComplaint()" class="w-full bg-black text-white py-2 rounded-xl">Submit Help Request</button>
    </div>

    <!-- Payout Not Received -->
    <div class="bg-white rounded-xl p-4 space-y-4 shadow">
      <p class="text-base font-semibold">Payout Not Received</p>
      <input id="payoutBookingId" type="text" placeholder="Enter Booking ID" class="w-full border rounded-lg p-2" />
      <input id="payoutDate" type="date" class="w-full border rounded-lg p-2" />
      <button onclick="submitPayout()" class="w-full bg-black text-white py-2 rounded-xl">Submit Help Request</button>
    </div>

    <!-- FAQ -->
    <div class="bg-white rounded-xl p-4 shadow">
      <p class="text-base font-semibold mb-2">Frequently Asked Questions</p>
      <ul class="text-sm list-disc pl-5 space-y-1 text-gray-600">
        <li>How to accept a booking?</li>
        <li>How to update your availability?</li>
        <li>What to do if customer cancels?</li>
        <li>How I can change my workzone?</li>
      </ul>
    </div>

  <!-- Support Contact Card -->
  <div class="bg-white rounded-xl p-4 shadow space-y-3 text-center">
    <p class="text-base font-semibold">Customer Support</p>

    <div class="flex justify-center items-center space-x-2">
      <i data-lucide="phone" class="w-5 h-5 text-green-600"></i>
      <span class="text-sm text-gray-700">+91 98765 43210</span>
    </div>

    <div class="flex justify-center items-center space-x-2">
      <i data-lucide="mail" class="w-5 h-5 text-green-600"></i>
      <span class="text-sm text-gray-700">support@karfect.in</span>
    </div>
  </div>
</div>

  </main>

  <!-- Popup -->
  <div id="popup" class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl text-center shadow-xl space-y-3 flex flex-col items-center">
      <i id="popupIcon" data-lucide="check-circle" class="w-10 h-10 text-green-600"></i>
      <p id="popupMessage" class="font-medium text-sm text-green-700"></p>
    </div>
  </div>

  <script>
    function showPopup(type, message = '') {
      const popup = document.getElementById("popup");
      const popupMessage = document.getElementById("popupMessage");
      const popupIcon = document.getElementById("popupIcon");

      if (type === 'error') {
        popupIcon.setAttribute("data-lucide", "x-circle");
        popupIcon.classList.replace("text-green-600", "text-red-600");
        popupMessage.classList.replace("text-green-700", "text-red-600");
        popupMessage.innerText = message || "Please fill out all required fields.";
      } else {
        popupIcon.setAttribute("data-lucide", "check-circle");
        popupIcon.classList.replace("text-red-600", "text-green-600");
        popupMessage.classList.replace("text-red-600", "text-green-700");
        popupMessage.innerText = type === 'complaint'
          ? "Complaint submitted successfully!"
          : "Request submitted! We will try to solve it at the earliest.";
      }

      lucide.createIcons();
      popup.classList.remove("hidden");
      setTimeout(() => {
        popup.classList.add("hidden");
      }, 2500);
    }

    function submitComplaint() {
      const issueType = document.getElementById("complaintType").value;
      const bookingId = document.getElementById("bookingId").value;
      const date = document.getElementById("complaintDate").value;

      if (!issueType || !bookingId || !date) {
        showPopup('error', "Please fill in all complaint details.");
        return;
      }

      showPopup('complaint');
    }

    function submitPayout() {
      const bookingId = document.getElementById("payoutBookingId").value;
      const date = document.getElementById("payoutDate").value;

      if (!bookingId || !date) {
        showPopup('error', "Please fill in both booking ID and date.");
        return;
      }

      showPopup('payout');
    }

    window.onload = () => {
      lucide.createIcons();
    }
  </script>

</body>
</html>
