<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <title>Change Password</title>
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
        <p class="text-base font-semibold">Change Password</p>
        <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
      </div>
    </div>
  </header>

  <!-- Main Form -->
  <main class="p-4 space-y-3">

    <form id="passwordForm" class="bg-white rounded-xl p-4 space-y-4 shadow">

      <div>
        <label for="oldPassword" class="text-sm text-gray-600 block mb-1">Old Password</label>
        <input type="password" maxlength="16" id="oldPassword" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter old password" required>
      </div>

    <!-- New Password Field -->
       <div class="relative">
        <label for="newPassword" class="text-sm text-gray-600 block mb-1">New Password</label>
        <input type="password" maxlength="16" id="newPassword" class="w-full px-4 py-2 border rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter new password" required>
        <button type="button" onclick="toggleVisibility('newPassword', this)" class="absolute right-2 top-9 text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" id="eye-newPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.442-4.357m2.103-1.77A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.843 5.222M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
        </svg>
        </button>
      </div>

      <!-- Confirm Password Field -->
      <div class="relative">
        <label for="confirmPassword" class="text-sm text-gray-600 block mb-1">Confirm New Password</label>
        <input type="password" maxlength="16" id="confirmPassword" class="w-full px-4 py-2 border rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Re-enter new password" required>
        <button type="button" onclick="toggleVisibility('confirmPassword', this)" class="absolute right-2 top-9 text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" id="eye-newPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.442-4.357m2.103-1.77A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.843 5.222M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
        </svg>
        </button>
      </div>

      <button type="submit" class="w-full bg-black text-white py-2 rounded-xl mt-4 font-medium hover:bg-green-700 transition duration-200">
        Save Changes
      </button>
    </form>
  </main>

  <!-- Success Popup -->
  <div id="successPopup" class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded shadow-lg hidden">
    Password changed successfully!
  </div>

  <!-- JS Section -->
  <script>
    const form = document.getElementById('passwordForm');
    const popup = document.getElementById('successPopup');

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const oldPassword = document.getElementById('oldPassword').value;
      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if (newPassword !== confirmPassword) {
        showPopup(" New and confirm password do not match!", 'red');
        return;
      }

      if (oldPassword === newPassword) {
        showPopup(" Old and new password must be different!", 'red');
        return;
      }

      // Password change logic goes here...

      form.reset(); // Clear form
      showPopup(" Password changed successfully!", 'green');
    });

    function showPopup(message, color) {
      popup.textContent = message;
      popup.classList.remove('hidden');
      popup.classList.remove('bg-green-500', 'bg-red-500');

      popup.classList.add(color === 'green' ? 'bg-green-500' : 'bg-red-500');

      setTimeout(() => {
        popup.classList.add('hidden');
      }, 2500);
    }

     function toggleVisibility(inputId, button) {
  const input = document.getElementById(inputId);
  const icon = button.querySelector('svg');
  const isVisible = input.type === 'text';

  if (isVisible) {
    // Hide password and show eye-slash
    input.type = 'password';
    icon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
           a10.05 10.05 0 012.442-4.357m2.103-1.77A9.956 9.956 0 0112 5
           c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.843 5.222M15 12
           a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 3l18 18" />
    `;
  } else {
    // Show password and show open eye
    input.type = 'text';
    icon.innerHTML = `
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5
           c4.478 0 8.268 2.943 9.542 7
           -1.274 4.057-5.064 7-9.542 7
           -4.477 0-8.268-2.943-9.542-7z" />
    `;
  }
}
  </script>
</body>
</html>
