let map, marker, autocomplete;

// Base URL for API calls
const BASE_URL = window.BASE_PATH ? window.BASE_PATH.replace(/\/$/, '') : '';

document.addEventListener('DOMContentLoaded', () => {
    console.log('Attempting to fetch addresses from:', `${BASE_URL}/api/address/get_addresses.php`);
    fetchAddresses();
    initMap();
    initAutocomplete();
});

function initMap() {
    const defaultLocation = { lat: 22.5726, lng: 88.3639 }; // Default to Kolkata
    map = new google.maps.Map(document.getElementById('map'), {
        center: defaultLocation,
        zoom: 15,
        mapTypeControl: false,
        streetViewControl: false,
    });

    marker = new google.maps.Marker({
        map: map,
        position: defaultLocation,
        draggable: true,
    });

    google.maps.event.addListener(marker, 'dragend', () => {
        const position = marker.getPosition();
        document.getElementById('latitude').value = position.lat();
        document.getElementById('longitude').value = position.lng();
        reverseGeocode(position);
    });

    map.addListener('click', (event) => {
        const position = event.latLng;
        marker.setPosition(position);
        document.getElementById('latitude').value = position.lat();
        document.getElementById('longitude').value = position.lng();
        reverseGeocode(position);
    });
}

function initAutocomplete() {
    const input = document.getElementById('addressSearch');
    autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: 'in' },
    });

    autocomplete.addListener('place_changed', () => {
        const place = autocomplete.getPlace();
        if (place.geometry) {
            const location = place.geometry.location;
            map.setCenter(location);
            marker.setPosition(location);
            document.getElementById('latitude').value = location.lat();
            document.getElementById('longitude').value = location.lng();
            document.getElementById('address').value = place.formatted_address;
        }
    });
}

function reverseGeocode(position) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ location: position }, (results, status) => {
        if (status === 'OK' && results[0]) {
            document.getElementById('address').value = results[0].formatted_address;
        }
    });
}

function fetchAddresses() {
    fetch(`${BASE_URL}/api/address/get_addresses.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status} (${response.statusText})`);
            }
            return response.text();
        })
        .then(text => {
            console.log('Raw response from get_addresses.php:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error(`JSON parse error: ${e.message}. Raw response: ${text}`);
            }
        })
        .then(data => {
            const addressList = document.getElementById('addressList');
            addressList.innerHTML = '';

            if (data.success && data.addresses.length > 0) {
                data.addresses.forEach(address => {
                    const card = document.createElement('div');
                    card.classList.add('karfect-address-card');
                    card.innerHTML = `
                        ${address.is_default == 1 ? '<span class="karfect-default-badge">Default</span>' : ''}
                        <div class="karfect-type">${address.type}</div>
                        <p>${address.name}, ${address.address}</p>
                        <p>${address.landmark ? 'Landmark: ' + address.landmark : ''}</p>
                        <p>Phone: ${address.phone}</p>
                        <div class="karfect-address-actions">
                            <button onclick="openEditAddressModal(${address.id})">EDIT</button>
                            <button onclick="deleteAddress(${address.id})">DELETE</button>
                            ${address.is_default == 0 ? `<button class="karfect-set-default-btn" onclick="setDefaultAddress(${address.id})">SET AS DEFAULT</button>` : ''}
                        </div>
                    `;
                    addressList.appendChild(card);
                });
            } else {
                addressList.innerHTML = '<p>No addresses found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching addresses:', error);
            document.getElementById('addressList').innerHTML = '<p>Error loading addresses. Please check the console for details.</p>';
        });
}

function setDefaultAddress(addressId) {
    fetch(`${BASE_URL}/api/address/set_default_address.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ addressId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchAddresses();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error setting default address:', error);
        alert('Error setting default address.');
    });
}

function openAddAddressModal() {
    console.log('Attempting to fetch addresses for limit check:', `${BASE_URL}/api/address/get_addresses.php`);
    fetch(`${BASE_URL}/api/address/get_addresses.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status} (${response.statusText})`);
            }
            return response.text();
        })
        .then(text => {
            console.log('Raw response from get_addresses.php (openAddAddressModal):', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error(`JSON parse error: ${e.message}. Raw response: ${text}`);
            }
        })
        .then(data => {
            if (data.success && data.addresses.length >= 5) {
                alert('You can only add up to 5 addresses.');
                return;
            }

            document.getElementById('modalTitle').textContent = 'Add New Address';
            document.getElementById('addressForm').reset();
            document.getElementById('addressId').value = '';
            document.getElementById('addressType').value = 'Home'; // Default to Home
            updateAddressTypeUI('Home');
            document.getElementById('addressModal').style.display = 'block';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        marker.setPosition(userLocation);
                        document.getElementById('latitude').value = userLocation.lat;
                        document.getElementById('longitude').value = userLocation.lng;
                        reverseGeocode(userLocation);
                    },
                    (error) => {
                        console.error('Geolocation error:', error);
                        const defaultLocation = { lat: 22.5726, lng: 88.3639 };
                        map.setCenter(defaultLocation);
                        marker.setPosition(defaultLocation);
                    }
                );
            } else {
                const defaultLocation = { lat: 22.5726, lng: 88.3639 };
                map.setCenter(defaultLocation);
                marker.setPosition(defaultLocation);
            }
        })
        .catch(error => {
            console.error('Error checking address limit:', error);
            alert('Error loading address limit. Please check the console for details.');
        });
}

function openEditAddressModal(addressId) {
    fetch(`${BASE_URL}/api/address/get_addresses.php`)
        .then(response => response.json())
        .then(data => {
            const address = data.addresses.find(addr => addr.id == addressId);
            if (address) {
                console.log('Editing address with type:', address.type); // Debug log
                document.getElementById('modalTitle').textContent = 'Edit Address';
                document.getElementById('addressId').value = address.id;
                document.getElementById('name').value = address.name;
                document.getElementById('phone').value = address.phone;
                document.getElementById('address').value = address.address;
                document.getElementById('landmark').value = address.landmark || '';

                // Normalize address type for consistency
                const normalizedType = address.type.charAt(0).toUpperCase() + address.type.slice(1).toLowerCase();
                console.log('Normalized address type:', normalizedType); // Debug log
                if (['Home', 'Work', 'Other'].includes(normalizedType)) {
                    document.getElementById('addressType').value = normalizedType;
                    updateAddressTypeUI(normalizedType);
                } else {
                    console.error('Invalid address type:', normalizedType);
                    document.getElementById('addressType').value = 'Home'; // Fallback to Home
                    updateAddressTypeUI('Home');
                }

                document.getElementById('latitude').value = address.latitude;
                document.getElementById('longitude').value = address.longitude;

                const position = { lat: parseFloat(address.latitude), lng: parseFloat(address.longitude) };
                map.setCenter(position);
                marker.setPosition(position);

                document.getElementById('addressModal').style.display = 'block';
            } else {
                alert('Address not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching address for edit:', error);
            alert('Error loading address for editing. Please check the console for details.');
        });
}

function updateAddressTypeUI(selectedType) {
    const typeBoxes = document.querySelectorAll('.karfect-address-type-box');
    typeBoxes.forEach(box => {
        if (box.dataset.type === selectedType) {
            box.classList.add('karfect-address-type-selected');
        } else {
            box.classList.remove('karfect-address-type-selected');
        }
    });
}

function deleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address?')) {
        fetch(`${BASE_URL}/api/address/delete_address.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ addressId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchAddresses();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting address:', error);
            alert('Error deleting address.');
        });
    }
}

function closeModal() {
    document.getElementById('addressModal').style.display = 'none';
}

document.getElementById('addressForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const addressId = document.getElementById('addressId').value;
    const url = addressId ? `${BASE_URL}/api/address/update_address.php` : `${BASE_URL}/api/address/add_address.php`;
    
    const formData = {
        addressId: addressId,
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        landmark: document.getElementById('landmark').value,
        type: document.getElementById('addressType').value,
        latitude: document.getElementById('latitude').value,
        longitude: document.getElementById('longitude').value,
    };

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            fetchAddresses();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error saving address:', error);
        alert('Error saving address.');
    });
});