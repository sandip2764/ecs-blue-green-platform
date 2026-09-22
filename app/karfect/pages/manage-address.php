<?php
session_start();
include '../includes/check_login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Addresses - Karfect</title>
    <link rel="stylesheet" href="../assets/css/karfect-address.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="karfect-container">
        <h2>Manage Addresses</h2>
        <div class="karfect-address-list" id="addressList"></div>
        <button class="karfect-add-address-btn" onclick="openAddAddressModal()">Add New Address</button>
    </div>

    <!-- Modal for Add/Edit Address -->
    <div id="addressModal" class="karfect-modal">
        <div class="karfect-modal-content">
            <span class="karfect-close" onclick="closeModal()">×</span>
            <h3 id="modalTitle">Add New Address</h3>
            <div id="map" style="height: 300px; width: 100%; margin-bottom: 20px;"></div>
            <form id="addressForm">
                <input type="hidden" id="addressId" name="addressId">
                <div class="karfect-form-group">
                    <label for="addressSearch">Search Address</label>
                    <input type="text" id="addressSearch" placeholder="Search for your address">
                </div>
                <div class="karfect-form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="karfect-form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="karfect-form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                <div class="karfect-form-group">
                    <label for="landmark">Landmark (Optional)</label>
                    <input type="text" id="landmark" name="landmark">
                </div>
                <div class="karfect-form-group">
                    <label>Address Type</label>
                    <div class="karfect-address-type">
                        <div class="karfect-address-type-box karfect-address-type-selected" data-type="Home" onclick="selectAddressType('Home')">
                            <i class="fas fa-home"></i> Home
                        </div>
                        <div class="karfect-address-type-box" data-type="Work" onclick="selectAddressType('Work')">
                            <i class="fas fa-briefcase"></i> Work
                        </div>
                        <div class="karfect-address-type-box" data-type="Other" onclick="selectAddressType('Other')">
                            <i class="fas fa-map-marker-alt"></i> Other
                        </div>
                    </div>
                    <input type="hidden" id="addressType" name="type" value="Home">
                </div>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <button type="submit" class="karfect-save-btn">Save Address</button>
            </form>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&libraries=places"></script>
    <script src="../assets/js/karfect-address.js"></script>
    <script>
        function selectAddressType(type) {
            document.getElementById('addressType').value = type;
            updateAddressTypeUI(type);
        }
    </script>
</body>
</html>

<?php include '../includes/footer.php'; ?>