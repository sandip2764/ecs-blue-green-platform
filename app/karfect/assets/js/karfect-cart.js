document.addEventListener('DOMContentLoaded', () => {
    const BASE_PATH = window.BASE_PATH || '';
    const changeAddressButton = document.querySelector('.change-address-button');
    const addressModal = document.getElementById('addressModal');
    const closeModal = document.querySelector('.close-modal');
    const addressOptions = document.querySelectorAll('.address-option');
    const checkoutButton = document.querySelector('.cart-checkout-button');
    const successPopup = document.getElementById('successPopup');
    const trackOrderButton = document.getElementById('trackOrderButton');

    // Open Address Modal
    if (changeAddressButton && addressModal) {
        changeAddressButton.addEventListener('click', () => {
            addressModal.style.display = 'flex';
        });
    }

    // Close Address Modal
    if (closeModal && addressModal) {
        closeModal.addEventListener('click', () => {
            addressModal.style.display = 'none';
        });
    }

    // Select Address
    addressOptions.forEach(option => {
        option.addEventListener('click', () => {
            const addressId = option.getAttribute('data-address-id');
            fetch(BASE_PATH + 'api/cart/update_default_address.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `address_id=${addressId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to update address');
                }
            })
            .catch(error => {
                console.error('Error updating address:', error);
                alert('Error updating address');
            });
        });
    });

    // Razorpay Checkout
    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            const totalAmount = parseFloat(checkoutButton.getAttribute('data-total')) * 100; // Convert to paise

            fetch(BASE_PATH + 'api/orders/create_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `amount=${totalAmount}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const options = {
                        key: 'rzp_test_kOQpzpZ1wKCAs7',
                        amount: totalAmount,
                        currency: 'INR',
                        name: 'Karfect',
                        description: 'Order Payment',
                        order_id: data.razorpay_order_id,
                        handler: function(response) {
                            fetch(BASE_PATH + 'api/orders/verify_payment.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: `razorpay_payment_id=${response.razorpay_payment_id}&razorpay_order_id=${response.razorpay_order_id}&razorpay_signature=${response.razorpay_signature}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    fetch(BASE_PATH + 'api/orders/save_order.php', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                        body: `razorpay_order_id=${response.razorpay_order_id}&payment_id=${response.razorpay_payment_id}&amount=${totalAmount / 100}`
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === 'success') {
                                            successPopup.style.display = 'flex';
                                            sessionStorage.setItem('last_order_id', data.order_id);

                                            // Automatically redirect to order_success.php after 3 seconds
                                            setTimeout(() => {
                                                window.location.href = BASE_PATH + 'pages/order_success.php';
                                            }, 3000);
                                        } else {
                                            alert(data.message || 'Failed to save order');
                                        }
                                    });
                                } else {
                                    alert(data.message || 'Payment verification failed');
                                }
                            });
                        },
                        prefill: {
                            name: '',
                            email: '',
                            contact: ''
                        },
                        theme: {
                            color: '#6e42e5'
                        }
                    };
                    const rzp = new Razorpay(options);
                    rzp.open();
                } else {
                    alert(data.message || 'Failed to create order');
                }
            })
            .catch(error => {
                console.error('Error creating order:', error);
                alert('Error creating order');
            });
        });
    }

    // Track Order Button (Optional, can be removed since we're auto-redirecting)
    if (trackOrderButton) {
        trackOrderButton.addEventListener('click', () => {
            const orderId = sessionStorage.getItem('last_order_id');
            if (orderId) {
                window.location.href = BASE_PATH + 'pages/order_success.php'; // Redirect to order_success.php
            }
        });
    }

    // Collapsible Order Details
    const toggleButtons = document.querySelectorAll('.toggle-details');
    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const orderItems = button.parentElement.nextElementSibling;
            const isVisible = orderItems.style.display === 'block';
            orderItems.style.display = isVisible ? 'none' : 'block';
            button.textContent = isVisible ? 'Details ▼' : 'Hide Details ▲';
        });
    });
});