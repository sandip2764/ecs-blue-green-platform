<?php
require_once 'check_login.php';

// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Load last selected address from session if available
$default_location = isset($_SESSION['selected_location']) ? $_SESSION['selected_location'] : 'Select location';
?>

<header class="mobile-header">
    <div class="mobile-header-left">
        <div class="location_selection">
            <div class="location_selection_elements">
                <div class="map-pin-container" id="mapPinMobile">
                    <svg class="map-pin-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path class="map-pin-path" d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                        <circle class="map-pin-circle" cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <span class="location_name"><?php echo htmlspecialchars($default_location); ?></span>
                <span class="location_angle_down">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                    </svg>
                </span>
            </div>
            <!-- Mobile Popup -->
            <div class="location-popup" id="locationPopupMobile" style="display: none;">
                <div class="location-search">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="locationSearchMobile" placeholder="Enter your location">
                    <div class="loader" id="loaderMobile" style="display: none;"></div>
                </div>
                <div class="suggestions" id="suggestionsMobile" style="display: none;"></div>
                <div class="error-message" id="errorMessageMobile" style="display: none;">Location not found</div>
                <button class="current-location-btn" id="currentLocationBtnMobile">
                    <svg class="location-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b48ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v4m0 12v4M2 12h4m12 0h4"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    Use current location
                </button>
                <div class="recent-locations" id="recentLocationsMobile">
                    <h4>Recents</h4>
                    <div class="recent-locations-list"></div>
                </div>
                <div class="google-branding">powered by <span>Google</span></div>
            </div>
        </div>
    </div>
    <div class="mobile-header-right">
        <div class="cart-icon-container" id="cartIconMobile">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="cart-icon">
                <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" />
            </svg>
            <span class="cart-count" style="display: none;">0</span>
        </div>
    </div>
</header>

<nav>
    <div class="nav_first">
        <div class="logo">
            <img src="<?php echo BASE_PATH; ?>assets/images/transparent_karfect.png" alt="Karfect Logo">
        </div>
    </div>
    <div class="nav_second">
        <a href="<?php echo BASE_PATH; ?>pages/home/"><span>Home</span></a>
        <a href="<?php echo BASE_PATH; ?>pages/beauty/"><span>Beauty</span></a>
        <a href="<?php echo BASE_PATH; ?>pages/event/"><span>Event</span></a>
    </div>
    <div class="nav_fourth">
        <div class="location_selection">
            <div class="location_selection_elements">
                <div class="map-pin-container" id="mapPin">
                    <svg class="map-pin-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path class="map-pin-path" d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                        <circle class="map-pin-circle" cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <span class="location_name"><?php echo htmlspecialchars($default_location); ?></span>
                <span class="location_angle_down">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                    </svg>
                </span>
            </div>
            <!-- Desktop Popup -->
            <div class="location-popup" id="locationPopup" style="display: none;">
                <div class="location-search">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="locationSearch" placeholder="Enter your location">
                    <div class="loader" id="loader" style="display: none;"></div>
                </div>
                <div class="suggestions" id="suggestions" style="display: none;"></div>
                <div class="error-message" id="errorMessage" style="display: none;">Location not found</div>
                <button class="current-location-btn" id="currentLocationBtn">
                    <svg class="location-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6b48ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v4m0 12v4M2 12h4m12 0h4"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    Use current location
                </button>
                <div class="recent-locations" id="recentLocations">
                    <h4>Recents</h4>
                    <div class="recent-locations-list"></div>
                </div>
                <div class="google-branding">powered by <span>Google</span></div>
            </div>
        </div>
    </div>
    <div class="nav_third">
        <div class="cart-icon-container" id="cartIcon">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="cart-icon">
                <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" />
            </svg>
            <span class="cart-count" style="display: none;">0</span>
        </div>
        <div class="cart-dropdown" id="cartDropdown" style="display: none;">
            <div class="cart-items"></div>
            <div class="cart-summary">
                <div class="cart-subtotal">
                    <span>Subtotal</span>
                    <span class="cart-subtotal-amount">₹0.00</span>
                </div>
                <div class="cart-gst">
                    <span>GST (18%)</span>
                    <span class="cart-gst-amount">₹0.00</span>
                </div>
                <div class="cart-total">
                    <span>Total</span>
                    <span class="cart-total-amount">₹0.00</span>
                </div>
                <a href="<?php echo BASE_PATH; ?>pages/cart/cart.php" class="cart-view-button">View Cart</a>
            </div>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-icon-container" id="userIcon">
                <svg class="user-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle class="user-icon-circle" cx="12" cy="8" r="5"></circle>
                    <path class="user-icon-path" d="M20 21a8 8 0 0 0-16 0"></path>
                </svg>
            </div>
            <div class="user-dropdown" id="userDropdown" style="display: none;">
                <a href="<?php echo BASE_PATH; ?>account.php" class="dropdown-item">Account</a>
                <a href="<?php echo BASE_PATH; ?>pages/order-history.php" class="dropdown-item">Orders</a>
                <a href="<?php echo BASE_PATH; ?>pages/manage-address.php" class="dropdown-item">Addresses</a>
                <a href="<?php echo BASE_PATH; ?>includes/logout.php" class="dropdown-item">Sign Out</a>
            </div>
        <?php else: ?>
            <a href="<?php echo BASE_PATH; ?>login.php" class="login_icon"><b>Sign up</b></a>
        <?php endif; ?>
    </div>
</nav>
<div class="space-gap"></div>

<link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/header.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/cart.css?v=<?php echo time(); ?>">
<link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">

<!-- Google Maps API Script with your API key -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&libraries=places&callback=initAutocomplete"></script>

<script>window.BASE_PATH = '<?php echo BASE_PATH; ?>';</script>
<script src="<?php echo BASE_PATH; ?>assets/js/cart.js?v=<?php echo time(); ?>"></script>

<script>
// User dropdown toggle
const userIcon = document.getElementById('userIcon');
const userDropdown = document.getElementById('userDropdown');
if (userIcon && userDropdown) {
    userIcon.addEventListener('click', () => {
        userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
    });
    document.addEventListener('click', (e) => {
        if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.style.display = 'none';
        }
    });
}

// Map pin animation
const mapPin = document.getElementById('mapPin');
const mapPinMobile = document.getElementById('mapPinMobile');
if (mapPin) {
    mapPin.addEventListener('mouseenter', () => {
        mapPin.classList.remove('normal');
        mapPin.classList.add('animate');
    });
    mapPin.addEventListener('mouseleave', () => {
        mapPin.classList.remove('animate');
        mapPin.classList.add('normal');
    });
}
if (mapPinMobile) {
    mapPinMobile.addEventListener('mouseenter', () => {
        mapPinMobile.classList.remove('normal');
        mapPinMobile.classList.add('animate');
    });
    mapPinMobile.addEventListener('mouseleave', () => {
        mapPinMobile.classList.remove('animate');
        mapPinMobile.classList.add('normal');
    });
}

// Location popup toggle for desktop
const locationSelection = document.querySelector('.nav_fourth .location_selection_elements');
const locationPopup = document.getElementById('locationPopup');
if (locationSelection && locationPopup) {
    locationSelection.addEventListener('click', () => {
        locationPopup.style.display = locationPopup.style.display === 'block' ? 'none' : 'block';
        loadRecentSearches('recentLocations');
    });
    document.addEventListener('click', (e) => {
        if (!locationSelection.contains(e.target) && !locationPopup.contains(e.target)) {
            locationPopup.style.display = 'none';
        }
    });
}

// Location popup toggle for mobile
const locationSelectionMobile = document.querySelector('.mobile-header .location_selection_elements');
const locationPopupMobile = document.getElementById('locationPopupMobile');
if (locationSelectionMobile && locationPopupMobile) {
    locationSelectionMobile.addEventListener('click', () => {
        locationPopupMobile.style.display = locationPopupMobile.style.display === 'block' ? 'none' : 'block';
        loadRecentSearches('recentLocationsMobile');
    });
    document.addEventListener('click', (e) => {
        if (!locationSelectionMobile.contains(e.target) && !locationPopupMobile.contains(e.target)) {
            locationPopupMobile.style.display = 'none';
        }
    });
}

// Manage recent searches and session storage
function saveRecentSearch(fullAddress, pincode) {
    const parts = fullAddress.split(',');
    const shortAddress = parts.length >= 2 ? `${parts[0].trim()}, ${parts[1].trim()}` : parts[0].trim();
    let recentSearches = [fullAddress]; // Store full address for recent searches
    localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
    
    // Save short address and PIN code to session via AJAX
    fetch('<?php echo BASE_PATH; ?>includes/save_location.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `selected_location=${encodeURIComponent(shortAddress)}&pincode=${encodeURIComponent(pincode)}`
    }).then(response => response.text())
      .then(data => {
          if (data === 'success') {
              // Check if location is in Kolkata
              const pin = parseInt(pincode);
              const isKolkata = pin >= 700001 && pin <= 700088;
              if (!isKolkata) {
                  window.location.href = '<?php echo BASE_PATH; ?>pages/service-unavailable.php';
              } else {
                  // Reload page to show content if on service-unavailable page
                  if (window.location.pathname.includes('service-unavailable.php')) {
                      window.location.href = '<?php echo BASE_PATH; ?>index.php';
                  }
              }
          }
      })
      .catch(error => console.error('Error saving location to session:', error));
    
    loadRecentSearches('recentLocations');
    loadRecentSearches('recentLocationsMobile');
}

function loadRecentSearches(containerId) {
    const container = document.getElementById(containerId);
    const recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
    const recentLocationsDiv = container.querySelector('.recent-locations-list');
    recentLocationsDiv.innerHTML = '';
    recentSearches.forEach(search => {
        const parts = search.split(',');
        const displayText = parts.length >= 2 ? `${parts[0].trim()}, ${parts[1].trim()}` : parts[0].trim();
        const locationItem = document.createElement('div');
        locationItem.className = 'location-item';
        locationItem.innerHTML = `
            <svg class="clock-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <div class="location-details">
                <p>${parts[0].trim()}</p>
                <span>${displayText}</span>
            </div>
        `;
        locationItem.addEventListener('click', () => {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: search }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    let pincode = null;
                    results[0].address_components.forEach(component => {
                        if (component.types.includes('postal_code')) {
                            pincode = component.long_name;
                        }
                    });
                    if (pincode) {
                        if (containerId === 'recentLocations') {
                            document.querySelector('.nav_fourth .location_name').textContent = displayText;
                            locationPopup.style.display = 'none';
                        } else {
                            document.querySelector('.mobile-header .location_name').textContent = displayText;
                            locationPopupMobile.style.display = 'none';
                        }
                        saveRecentSearch(search, pincode);
                    } else {
                        alert('Unable to fetch PIN code for this location.');
                    }
                }
            });
        });
        recentLocationsDiv.appendChild(locationItem);
    });
}

// Google Maps Autocomplete with Custom Suggestions
let placesService;

function initAutocomplete() {
    const input = document.getElementById('locationSearch');
    const inputMobile = document.getElementById('locationSearchMobile');
    const suggestions = document.getElementById('suggestions');
    const suggestionsMobile = document.getElementById('suggestionsMobile');
    const loader = document.getElementById('loader');
    const loaderMobile = document.getElementById('loaderMobile');
    const errorMessage = document.getElementById('errorMessage');
    const errorMessageMobile = document.getElementById('errorMessageMobile');

    // Check if elements exist
    if (!input || !inputMobile || !suggestions || !suggestionsMobile) {
        console.error('Required elements not found.');
        return;
    }

    // Initialize Places Service
    placesService = new google.maps.places.AutocompleteService();

    // Debounce function to limit API calls
    const debounce = (func, delay) => {
        let timeoutId;
        return (...args) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func(...args), delay);
        };
    };

    // Function to fetch and display suggestions
    const fetchSuggestions = (query, suggestionContainer, loaderElement, errorElement, isMobile) => {
        if (query.length < 2) {
            suggestionContainer.style.display = 'none';
            errorElement.style.display = 'none';
            return;
        }

        loaderElement.style.display = 'block';
        errorElement.style.display = 'none';
        suggestionContainer.style.display = 'block';
        suggestionContainer.innerHTML = '';

        const request = {
            input: query,
            types: ['geocode'],
            componentRestrictions: { country: 'in' }
        };

        placesService.getPlacePredictions(request, (predictions, status) => {
            loaderElement.style.display = 'none';

            if (status !== google.maps.places.PlacesServiceStatus.OK || !predictions || predictions.length === 0) {
                suggestionContainer.style.display = 'none';
                errorElement.style.display = 'block';
                errorElement.textContent = 'No suggestions found';
                console.error('Places API Error:', status);
                return;
            }

            suggestionContainer.innerHTML = '';
            predictions.forEach(prediction => {
                const suggestionItem = document.createElement('div');
                suggestionItem.className='suggestion-item';
                suggestionItem.innerHTML = `
                    <svg class="suggestion-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <div class="suggestion-details">
                        <p>${prediction.structured_formatting.main_text}</p>
                        <span>${prediction.structured_formatting.secondary_text}</span>
                    </div>
                `;
                suggestionItem.addEventListener('click', () => {
                    loaderElement.style.display = 'block';
                    suggestionContainer.style.display = 'none';
                    const placeRequest = {
                        placeId: prediction.place_id,
                        fields: ['formatted_address', 'geometry', 'address_components']
                    };
                    const placesDetailService = new google.maps.places.PlacesService(document.createElement('div'));
                    placesDetailService.getDetails(placeRequest, (place, status) => {
                        loaderElement.style.display = 'none';
                        if (status === google.maps.places.PlacesServiceStatus.OK && place.formatted_address) {
                            const address = place.formatted_address;
                            const parts = address.split(',');
                            const displayText = parts.length >= 2 ? `${parts[0].trim()}, ${parts[1].trim()}` : parts[0].trim();
                            const locationName = isMobile ?
                                document.querySelector('.mobile-header .location_name') :
                                document.querySelector('.nav_fourth .location_name');
                            locationName.textContent = displayText;
                            
                            // Extract PIN code
                            let pincode = null;
                            place.address_components.forEach(component => {
                                if (component.types.includes('postal_code')) {
                                    pincode = component.long_name;
                                }
                            });
                            if (pincode) {
                                saveRecentSearch(address, pincode);
                            } else {
                                errorElement.style.display = 'block';
                                errorElement.textContent = 'Unable to fetch PIN code for this location';
                            }
                            
                            if (isMobile) {
                                locationPopupMobile.style.display = 'none';
                            } else {
                                locationPopup.style.display = 'none';
                            }
                        } else {
                            errorElement.style.display = 'block';
                            errorElement.textContent = 'Unable to fetch location details';
                        }
                    });
                });
                suggestionContainer.appendChild(suggestionItem);
            });
        });
    };

    // Debounced suggestion fetcher
    const debouncedFetchSuggestions = debounce(fetchSuggestions, 300);

    // Custom Autocomplete for Desktop
    if (input) {
        input.addEventListener('input', () => {
            const query = input.value.trim();
            debouncedFetchSuggestions(query, suggestions, loader, errorMessage, false);
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    }

    // Custom Autocomplete for Mobile
    if (inputMobile) {
        inputMobile.addEventListener('input', () => {
            const query = inputMobile.value.trim();
            debouncedFetchSuggestions(query, suggestionsMobile, loaderMobile, errorMessageMobile, true);
        });

        inputMobile.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    }

    // Automatically fetch current location on first visit
    if (!sessionStorage.getItem('location_set')) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const geocoder = new google.maps.Geocoder();
                    const latlng = { lat, lng };
                    geocoder.geocode({ location: latlng }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                            const address = results[0].formatted_address;
                            let pincode = null;
                            results[0].address_components.forEach(component => {
                                if (component.types.includes('postal_code')) {
                                    pincode = component.long_name;
                                }
                            });
                            if (pincode) {
                                const parts = address.split(',');
                                const displayText = parts.length >= 2 ? `${parts[0].trim()}, ${parts[1].trim()}` : parts[0].trim();
                                const locationNameDesktop = document.querySelector('.nav_fourth .location_name');
                                const locationNameMobile = document.querySelector('.mobile-header .location_name');
                                if (locationNameDesktop) locationNameDesktop.textContent = displayText;
                                if (locationNameMobile) locationNameMobile.textContent = displayText;
                                saveRecentSearch(address, pincode);
                                sessionStorage.setItem('location_set', 'true');
                            } else {
                                alert('Unable to fetch PIN code for this location. Please select a location manually.');
                            }
                        }
                    });
                },
                error => {
                    console.error('Error fetching current location:', error);
                    alert('Unable to fetch current location. Please select a location manually.');
                    sessionStorage.setItem('location_set', 'true');
                }
            );
        } else {
            alert('Geolocation is not supported by your browser. Please select a location manually.');
            sessionStorage.setItem('location_set', 'true');
        }
    }
}

// Current Location
const currentLocationBtn = document.getElementById('currentLocationBtn');
const currentLocationBtnMobile = document.getElementById('currentLocationBtnMobile');
const loader = document.getElementById('loader');
const loaderMobile = document.getElementById('loaderMobile');
const errorMessage = document.getElementById('errorMessage');
const errorMessageMobile = document.getElementById('errorMessageMobile');

if (currentLocationBtn) {
    currentLocationBtn.addEventListener('click', () => {
        loader.style.display = 'block';
        errorMessage.style.display = 'none';
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const geocoder = new google.maps.Geocoder();
                const latlng = { lat, lng };
                geocoder.geocode({ location: latlng }, (results, status) => {
                    loader.style.display = 'none';
                    if (status === 'OK' && results[0]) {
                        const address = results[0].formatted_address;
                        let pincode = null;
                        results[0].address_components.forEach(component => {
                            if (component.types.includes('postal_code')) {
                                pincode = component.long_name;
                            }
                        });
                        if (pincode) {
                            const parts = address.split(',');
                            const displayText = parts.length >= 2 ? `${parts[0].trim()}, ${parts[1].trim()}` : parts[0].trim();
                            const locationName = document.querySelector('.nav_fourth .location_name');
                            locationName.textContent = displayText;
                            saveRecentSearch(address, pincode);
                            locationPopup.style.display = 'none';
                        } else {
                            errorMessage.style.display = 'block';
                            errorMessage.textContent = 'Unable to fetch PIN code for this location';
                        }
                    } else {
                        errorMessage.style.display = 'block';
                        errorMessage.textContent = 'Unable to fetch location';
                    }
                });
            }, (error) => {
                errorMessage.style.display = 'block';
                loader.style.display = 'none';
                alert('Unable to fetch location. Please allow location access.');
            });
        } else {
            errorMessage.style.display = 'block';
            loader.style.display = 'none';
            alert('Geolocation is not supported by your browser.');
        }
    });
}

if (currentLocationBtnMobile) {
    currentLocationBtnMobile.addEventListener('click', () => {
        loaderMobile.style.display = 'block';
        errorMessageMobile.style.display = 'none';
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const geocoder = new google.maps.Geocoder();
                const latlng = { lat, lng };
                geocoder.geocode({ location: latlng }, (results, status) => {
                    loaderMobile.style.display = 'none';
                    if (status === 'OK' && results[0]) {
                        const address = results[0].formatted_address;
                        let pincode = null;
                        results[0].address_components.forEach(component => {
                            if (component.types.includes('postal_code')) {
                                pincode = component.long_name;
                            }
                        });
                        if (pincode) {
                            const parts = address.split(',');
                            const displayText = parts.length >= 2 ? `${parts[0].trim()}, ${parts[1].trim()}` : parts[0].trim();
                            const locationName = document.querySelector('.mobile-header .location_name');
                            locationName.textContent = displayText;
                            saveRecentSearch(address, pincode);
                            locationPopupMobile.style.display = 'none';
                        } else {
                            errorMessageMobile.style.display = 'block';
                            errorMessageMobile.textContent = 'Unable to fetch PIN code for this location';
                        }
                    } else {
                        errorMessageMobile.style.display = 'block';
                        errorMessageMobile.textContent = 'Unable to fetch location';
                    }
                });
            }, (error) => {
                errorMessageMobile.style.display = 'block';
                loaderMobile.style.display = 'none';
                alert('Unable to fetch location. Please allow location access.');
            });
        } else {
            errorMessageMobile.style.display = 'block';
            loaderMobile.style.display = 'none';
            alert('Geolocation is not supported by your browser.');
        }
    });
}
</script>