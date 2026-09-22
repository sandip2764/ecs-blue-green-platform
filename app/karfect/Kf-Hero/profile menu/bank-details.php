<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <title>Bank Details</title>
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
        <p class="text-base font-semibold">Bank details</p>
        <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
      </div>
    </div>
    <button class="text-sm bg-black text-white px-3 py-1 rounded flex items-center">
      Edit
    </button>
  </header>

  <!-- Content -->
  <main class="p-4 space-y-3">
    <h2 class="text-xl font-bold">Bank Account Details</h2>

    <div class="bg-white rounded-xl p-4 space-y-4 shadow">

      <div>
        <p class="text-sm text-gray-600">Bank account number</p>
        <div class="flex items-center justify-between">
          <p class="text-lg font-bold">153045781236</p>
          <img src="https://img.icons8.com/?size=100&id=6xO3fnY41hu2&format=png&color=40C057" alt="verified" class="w-5 h-5" />
        </div>
      </div>

      <div>
        <p class="text-sm text-gray-600">IFSC code</p>
        <p class="text-lg font-bold">SBIN0000390</p>
      </div>

      <div>
        <p class="text-sm text-gray-600">Branch</p>
        <p class="text-lg font-bold">BALLYGUNGE, KOLKATA</p>
      </div>

      <div>
        <p class="text-sm text-gray-600">Bank</p>
        <p class="text-lg font-bold">STATE BANK OF INDIA</p>
      </div>

    </div>
  </main>

</body>
</html>
