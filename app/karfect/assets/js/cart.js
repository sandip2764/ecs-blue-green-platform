document.addEventListener('DOMContentLoaded', () => {
    const cartIcon = document.getElementById('cartIcon');
    const cartIconMobile = document.getElementById('cartIconMobile');
    const cartDropdown = document.getElementById('cartDropdown');
    const cartItems = document.querySelector('.cart-items');
    const cartCount = document.querySelectorAll('.cart-count');
    const cartSubtotal = document.querySelector('.cart-subtotal-amount');
    const cartGst = document.querySelector('.cart-gst-amount');
    const cartTotal = document.querySelector('.cart-total-amount');
    const BASE_PATH = window.BASE_PATH || '';

    function updateCart() {
        fetch(BASE_PATH + 'api/cart/get_cart.php')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Invalid JSON response from get_cart.php:', text);
                        throw new Error('Server returned invalid JSON');
                    }
                });
            })
            .then(data => {
                if (data.status === 'success') {
                    cartItems.innerHTML = '';
                    let itemCount = 0;

                    data.items.forEach(item => {
                        itemCount += item.quantity;
                        const itemElement = document.createElement('div');
                        itemElement.classList.add('cart-item');
                        itemElement.setAttribute('data-cart-id', item.id);
                        itemElement.innerHTML = `
                            <img src="${BASE_PATH}${item.image}" alt="${item.title}" class="cart-item-image">
                            <div class="cart-item-details">
                                <span class="cart-item-title">${item.title}</span>
                                <span class="cart-item-price">₹${item.discounted_price} x ${item.quantity}</span>
                                <div class="cart-item-quantity">
                                    <button class="cart-quantity-button decrease" data-cart-id="${item.id}" data-service-id="${item.service_id}">-</button>
                                    <span class="cart-quantity-display">${item.quantity}</span>
                                    <button class="cart-quantity-button increase" data-cart-id="${item.id}" data-service-id="${item.service_id}">+</button>
                                </div>
                            </div>
                            <button class="cart-item-remove" data-cart-id="${item.id}">Remove</button>
                        `;
                        cartItems.appendChild(itemElement);
                    });

                    cartCount.forEach(count => {
                        count.textContent = itemCount;
                        count.style.display = itemCount > 0 ? 'inline' : 'none';
                    });
                    if (cartSubtotal) cartSubtotal.textContent = `₹${data.subtotal}`;
                    if (cartGst) cartGst.textContent = `₹${data.gst}`;
                    if (cartTotal) cartTotal.textContent = `₹${data.total}`;

                    // Sync quantity controls in women/index.php
                    document.querySelectorAll('.service-card').forEach(card => {
                        const serviceId = card.querySelector('.add-button').getAttribute('data-service-id');
                        const quantityControl = card.querySelector('.quantity-control');
                        const quantityDisplay = card.querySelector('.quantity-display');
                        const item = data.items.find(item => item.service_id == serviceId);
                        if (item) {
                            card.classList.add('added');
                            quantityControl.style.display = 'flex';
                            quantityDisplay.textContent = item.quantity;
                        } else {
                            card.classList.remove('added');
                            quantityControl.style.display = 'none';
                            quantityDisplay.textContent = '1';
                        }
                    });
                } else {
                    cartItems.innerHTML = '<p>Your cart is empty</p>';
                    cartCount.forEach(count => count.style.display = 'none');
                    if (cartSubtotal) cartSubtotal.textContent = '₹0.00';
                    if (cartGst) cartGst.textContent = '₹0.00';
                    if (cartTotal) cartTotal.textContent = '₹0.00';

                    // Reset quantity controls in women/index.php
                    document.querySelectorAll('.service-card').forEach(card => {
                        card.classList.remove('added');
                        card.querySelector('.quantity-control').style.display = 'none';
                        card.querySelector('.quantity-display').textContent = '1';
                    });
                }
            })
            .catch(error => console.error('Error fetching cart:', error));
    }

    function toggleCartDropdown() {
        cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
        if (cartDropdown.style.display === 'block') {
            updateCart();
        }
    }

    if (cartIcon) {
        cartIcon.addEventListener('click', toggleCartDropdown);
    }
    if (cartIconMobile) {
        cartIconMobile.addEventListener('click', toggleCartDropdown);
    }

    document.addEventListener('click', (e) => {
        if (!cartIcon.contains(e.target) && !cartIconMobile.contains(e.target) && !cartDropdown.contains(e.target)) {
            cartDropdown.style.display = 'none';
        }

        // Add to Cart Button Logic
        if (e.target.closest('.add-button')) {
            const button = e.target.closest('.add-button');
            const serviceId = button.getAttribute('data-service-id');
            const card = button.closest('.service-card');
            const quantityControl = card.querySelector('.quantity-control');
            const quantityDisplay = card.querySelector('.quantity-display');

            if (!serviceId || isNaN(serviceId)) {
                console.error('Invalid service ID:', serviceId);
                alert('Invalid service ID. Please check the button configuration.');
                return;
            }

            fetch(BASE_PATH + 'api/cart/get_cart.php')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Invalid JSON response from get_cart.php:', text);
                            throw new Error('Server returned invalid JSON');
                        }
                    });
                })
                .then(data => {
                    if (data.status !== 'success') {
                        console.error('Error fetching cart:', data.message);
                        alert(data.message || 'Failed to fetch cart');
                        return;
                    }

                    const itemExists = data.items && data.items.some(item => item.service_id == serviceId);
                    if (itemExists) {
                        const existingItem = data.items.find(item => item.service_id == serviceId);
                        card.classList.add('added');
                        quantityControl.style.display = 'flex';
                        quantityDisplay.textContent = existingItem.quantity;
                        alert('Service already in cart!');
                    } else {
                        fetch(BASE_PATH + 'api/cart/add_to_cart.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `service_id=${serviceId}&quantity=1`
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.text().then(text => {
                                    try {
                                        return JSON.parse(text);
                                    } catch (e) {
                                        console.error('Invalid JSON response from add_to_cart.php:', text);
                                        throw new Error('Server returned invalid JSON');
                                    }
                                });
                            })
                            .then(data => {
                                if (data.status === 'success') {
                                    card.classList.add('added');
                                    quantityControl.style.display = 'flex';
                                    quantityDisplay.textContent = '1';
                                    updateCart();
                                } else if (data.status === 'exists') {
                                    card.classList.add('added');
                                    quantityControl.style.display = 'flex';
                                    quantityDisplay.textContent = data.quantity;
                                    alert('Service already in cart!');
                                } else {
                                    if (data.message && data.message.includes('login')) {
                                        window.location.href = BASE_PATH + 'login.php';
                                    } else {
                                        alert(data.message || 'Failed to add to cart');
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Error adding to cart:', error);
                                alert('Error adding to cart: ' + error.message);
                            });
                    }
                })
                .catch(error => {
                    console.error('Error checking cart:', error);
                    alert('Error checking cart: ' + error.message);
                });
        }

        // Quantity Control for women/index.php (with stopPropagation)
        if (e.target.closest('.quantity-button')) {
            e.stopPropagation();
            const button = e.target.closest('.quantity-button');
            const card = button.closest('.service-card');
            const quantityDisplay = card.querySelector('.quantity-display');
            const serviceId = card.querySelector('.add-button').getAttribute('data-service-id');
            let quantity = parseInt(quantityDisplay.textContent);

            if (button.classList.contains('increase')) {
                quantity++;
            } else if (button.classList.contains('decrease')) {
                quantity--;
            }

            if (quantity < 1) {
                fetch(BASE_PATH + 'api/cart/delete_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `service_id=${serviceId}`
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Invalid JSON response from delete_cart.php:', text);
                                throw new Error('Server returned invalid JSON');
                            }
                        });
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            card.classList.remove('added');
                            card.querySelector('.quantity-control').style.display = 'none';
                            updateCart();
                        } else {
                            alert(data.message || 'Failed to delete item');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting cart item:', error);
                        alert('Error deleting cart item: ' + error.message);
                    });
            } else {
                fetch(BASE_PATH + 'api/cart/update_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `service_id=${serviceId}&quantity=${quantity}`
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Invalid JSON response from update_cart.php:', text);
                                throw new Error('Server returned invalid JSON');
                            }
                        });
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            quantityDisplay.textContent = quantity;
                            updateCart();
                        } else {
                            alert(data.message || 'Failed to update quantity');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating quantity:', error);
                        alert('Error updating quantity: ' + error.message);
                    });
            }
        }

        // Cart Dropdown and Cart Page Quantity Control
        if (e.target.closest('.cart-quantity-button')) {
            const button = e.target.closest('.cart-quantity-button');
            const cartId = button.getAttribute('data-cart-id');
            const serviceId = button.getAttribute('data-service-id');
            const quantityDisplay = button.parentElement.querySelector('.cart-quantity-display');
            let quantity = parseInt(quantityDisplay.textContent);

            if (button.classList.contains('increase')) {
                quantity++;
            } else if (button.classList.contains('decrease')) {
                quantity--;
            }

            if (quantity < 1) {
                fetch(BASE_PATH + 'api/cart/delete_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `cart_id=${cartId}`
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Invalid JSON response from delete_cart.php:', text);
                                throw new Error('Server returned invalid JSON');
                            }
                        });
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            updateCart();
                        } else {
                            alert(data.message || 'Failed to delete item');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting cart item:', error);
                        alert('Error deleting cart item: ' + error.message);
                    });
            } else {
                fetch(BASE_PATH + 'api/cart/update_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `cart_id=${cartId}&quantity=${quantity}`
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Invalid JSON response from update_cart.php:', text);
                                throw new Error('Server returned invalid JSON');
                            }
                        });
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            quantityDisplay.textContent = quantity;
                            updateCart();
                        } else {
                            alert(data.message || 'Failed to update quantity');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                        alert('Error updating cart: ' + error.message);
                    });
            }
        }

        // Cart Item Remove
        if (e.target.closest('.cart-item-remove')) {
            const cartId = e.target.getAttribute('data-cart-id');
            fetch(BASE_PATH + 'api/cart/delete_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `cart_id=${cartId}`
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Invalid JSON response from delete_cart.php:', text);
                            throw new Error('Server returned invalid JSON');
                        }
                    });
                })
                .then(data => {
                    if (data.status === 'success') {
                        updateCart();
                    } else {
                        alert(data.message || 'Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error removing cart item:', error);
                    alert('Error removing cart item: ' + error.message);
                });
        }
    });

    // Initial cart update on page load
    updateCart();
});
