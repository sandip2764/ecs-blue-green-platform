<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../includes/db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header('Location: ../login.php');
    exit;
}

$order_id = $_GET['order_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: ../index.php');
    exit;
}

// Fetch the address directly from the orders table since address_id is not available
$latitude = $order['latitude'];
$longitude = $order['longitude'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/karfect-cart.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="tracking-container">
        <h2>Order Tracking</h2>
        <div class="order-details">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
            <p><strong>Estimated Delivery:</strong> 30 minutes</p>
            <p><strong>Hero Name:</strong> Rahul Sharma</p>
        </div>
        <div id="map" class="tracking-map"></div>
    </div>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap"></script>
    <script>
        function initMap() {
            const destination = { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> };
            const source = { lat: destination.lat + 0.002, lng: destination.lng + 0.002 }; // Random nearby location

            const map = new google.maps.Map(document.getElementById('map'), {
                center: destination,
                zoom: 15
            });

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({ map: map });

            directionsService.route({
                origin: source,
                destination: destination,
                travelMode: 'DRIVING'
            }, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);

                    const path = result.routes[0].overview_path;
                    let step = 0;
                    const marker = new google.maps.Marker({
                        position: source,
                        map: map,
                        icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    });

                    function animateMarker() {
                        if (step < path.length) {
                            marker.setPosition(path[step]);
                            step++;
                            setTimeout(animateMarker, 500);
                        }
                    }
                    animateMarker();
                }
            });
        }
    </script>
</body>
</html>