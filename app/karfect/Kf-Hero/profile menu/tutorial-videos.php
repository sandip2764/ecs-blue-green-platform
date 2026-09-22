<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <title>Tutorial Videos</title>
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
        <p class="text-base font-semibold">Tutorial Videos</p>
        <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="p-4">
    <h2 class="text-xl font-bold mb-4">Your Tutorials</h2>

    <!-- Placeholder Section -->
    <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col items-center justify-center text-center space-y-4">
      <!-- Animated Icon -->
      <div class="w-36 h-36">
        <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_ydo1amjm.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <p class="text-gray-600 font-medium">No tutorial videos available right now.</p>
      <p class="text-sm text-gray-400">Stay tuned. We are working on adding helpful content for you!</p>
    </div>
  </main>

  <!-- Lottie Player Script -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</body>
</html>
