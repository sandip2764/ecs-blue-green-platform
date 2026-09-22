<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Unavailable - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/header.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="service-unavailable-container">
        <div class="service-unavailable-content">
            <svg class="unavailable-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ff4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 8v4"></path>
                <path d="M12 16h.01"></path>
            </svg>
            <h2>Service Not Available</h2>
            <p>Sorry, our services are currently available only in Kolkata (PIN codes 700001 to 700088).</p>
            <blockquote>
                "We’re expanding soon—stay tuned to bring Karfect to your city!"
            </blockquote>
            <button id="changeLocationButton" class="change-location-btn">Change Location</button>
        </div>
    </div>

    <script>
        // Change Location Button on Service Unavailable Page
        const changeLocationButton = document.getElementById('changeLocationButton');
        const locationPopup = document.getElementById('locationPopup');
        const locationPopupMobile = document.getElementById('locationPopupMobile');
        if (changeLocationButton) {
            changeLocationButton.addEventListener('click', () => {
                if (locationPopup) {
                    locationPopup.style.display = 'block';
                    loadRecentSearches('recentLocations');
                }
                if (locationPopupMobile) {
                    locationPopupMobile.style.display = 'block';
                    loadRecentSearches('recentLocationsMobile');
                }
            });
        }
    </script>
</body>
</html>