<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />
  <title>Settings</title>
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
        <p class="text-base font-semibold" data-key="settingsTitle">Settings</p>
        <p class="text-xs text-gray-500">KFHWBSP241028333 | 15.15.1 | 6023</p>
      </div>
    </div>
  </header>

  <!-- Content -->
  <main class="p-4 space-y-3">
    <h2 class="text-xl font-bold" data-key="settingsTitle">Settings</h2>

    <!-- Notification Type (Checkbox Style) -->
    <div class="bg-white rounded-xl p-4 space-y-2 shadow">
      <p class="text-sm text-gray-600" data-key="preferredNotification">Preferred Notification Type</p>
      <div class="space-y-2">
        <label class="flex items-center space-x-2">
          <input type="checkbox" id="notif_app" value="app" class="accent-green-500 h-4 w-4 rounded transition">
          <span class="text-sm text-gray-700">App Notification</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" id="notif_sms" value="sms" class="accent-green-500 h-4 w-4 rounded transition">
          <span class="text-sm text-gray-700">SMS</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" id="notif_email" value="email" class="accent-green-500 h-4 w-4 rounded transition">
          <span class="text-sm text-gray-700">Email</span>
        </label>
      </div>
    </div>

    <!-- Language Preferences -->
    <div class="bg-white rounded-xl p-4 space-y-2 shadow">
      <p class="text-sm text-gray-600" data-key="preferredLanguage">Preferred Language</p>
      <select id="languagePreference" onchange="changeLanguage(this.value)" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        <option value="en">English</option>
        <option value="hi">Hindi</option>
        <option value="bn">Bengali</option>
      </select>
    </div>

    <!-- Save Button -->
    <button onclick="saveSettings()" class="w-full bg-black text-white py-2 rounded-xl mt-4 font-medium" data-key="saveChanges">
      Save Changes
    </button>
  </main>

  <!-- Success Popup -->
  <div id="popup" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl text-center shadow-xl">
      <p class="font-medium text-green-600" data-key="settingsUpdated">Settings updated successfully!</p>
    </div>
  </div>

  <script>
    const translations = {
      hi: {
        settingsTitle: "सेटिंग्स",
        preferredNotification: "पसंदीदा सूचना प्रकार",
        preferredLanguage: "पसंदीदा भाषा",
        saveChanges: "परिवर्तन सहेजें",
        settingsUpdated: "सेटिंग्स सफलतापूर्वक अपडेट हो गईं!"
      },
      bn: {
        settingsTitle: "সেটিংস",
        preferredNotification: "পছন্দসই বিজ্ঞপ্তির ধরন",
        preferredLanguage: "পছন্দসই ভাষা",
        saveChanges: "পরিবর্তন সংরক্ষণ করুন",
        settingsUpdated: "সেটিংস সফলভাবে আপডেট হয়েছে!"
      },
      en: {
        settingsTitle: "Settings",
        preferredNotification: "Preferred Notification Type",
        preferredLanguage: "Preferred Language",
        saveChanges: "Save Changes",
        settingsUpdated: "Settings updated successfully!"
      }
    };

    function changeLanguage(lang) {
      localStorage.setItem("selectedLang", lang);
      const trans = translations[lang] || translations.en;
      document.querySelectorAll('[data-key]').forEach(el => {
        const key = el.getAttribute('data-key');
        if (trans[key]) el.innerText = trans[key];
      });
    }

    function saveSettings() {
      const selectedNotifications = [];
      ['app', 'sms', 'email'].forEach(type => {
        const checkbox = document.getElementById(`notif_${type}`);
        if (checkbox.checked) selectedNotifications.push(type);
      });

      const language = document.getElementById("languagePreference").value;

      localStorage.setItem("selectedNotification", JSON.stringify(selectedNotifications));
      localStorage.setItem("selectedLang", language);

      changeLanguage(language);

      const popup = document.getElementById('popup');
      popup.classList.remove('hidden');
      setTimeout(() => {
        popup.classList.add('hidden');
      }, 2000);
    }

    document.addEventListener("DOMContentLoaded", () => {
      const savedLang = localStorage.getItem("selectedLang") || "en";
      const savedNotifications = JSON.parse(localStorage.getItem("selectedNotification") || '["app", "sms"]');

      document.getElementById("languagePreference").value = savedLang;

      ['app', 'sms', 'email'].forEach(type => {
        document.getElementById(`notif_${type}`).checked = savedNotifications.includes(type);
      });

      changeLanguage(savedLang);
    });
  </script>

</body>
</html>

