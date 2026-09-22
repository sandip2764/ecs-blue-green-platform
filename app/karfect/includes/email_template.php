<?php
function getEmailTemplate($order_details, $user_details, $order_items) {
    $order_id = $order_details['order_id'];
    $order_date = date('F j, Y', strtotime($order_details['created_at']));
    $subtotal = $order_details['total_amount'] / 1.18; // Remove GST to get subtotal
    $gst = $order_details['total_amount'] - $subtotal;
    $total = $order_details['total_amount'];
    $delivery_address = $order_details['address'];
    $payment_method = 'Razorpay';
    $estimated_delivery = date('F j, Y', strtotime($order_details['created_at'] . ' + 5 days'));
    $user_name = $user_details['name']; // Updated to use 'name'
    $user_email = $user_details['email'];

    $product_rows = '';
    foreach ($order_items as $item) {
        $product_rows .= "
            <tr style='border-bottom: 1px solid #e0e0e0;'>
                <td style='padding: 10px; color: #18181B;'>{$item['product_name']}</td>
                <td style='padding: 10px; color: #18181B; text-align: center;'>{$item['quantity']}</td>
                <td style='padding: 10px; color: #18181B; text-align: right;'>₹{$item['unit_price']}</td>
                <td style='padding: 10px; color: #18181B; text-align: right;'>₹" . ($item['quantity'] * $item['unit_price']) . "</td>
            </tr>";
    }

    return "
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Order Confirmation</title>
    </head>
    <body style='font-family: Arial, sans-serif; background-color: #f4f4f5; margin: 0; padding: 0;'>
        <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden;'>
            <!-- Header -->
            <div style='background-color: #6b48ff; padding: 20px; text-align: center;'>
                <h1 style='color: #ffffff; font-size: 24px; margin: 0;'>Order Confirmation</h1>
                <p style='color: #e0e0e0; font-size: 14px; margin: 5px 0;'>Thank you for shopping with Karfect!</p>
            </div>

            <!-- Order Summary -->
            <div style='padding: 20px;'>
                <h2 style='color: #18181B; font-size: 18px; margin-bottom: 10px;'>Hello, {$user_name}</h2>
                <p style='color: #757575; font-size: 14px; margin-bottom: 20px;'>Your order has been successfully placed. Here are the details:</p>

                <div style='background-color: #f4f4f5; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>
                    <p style='color: #18181B; font-size: 14px; margin: 0;'><strong>Order ID:</strong> #{$order_id}</p>
                    <p style='color: #18181B; font-size: 14px; margin: 5px 0;'><strong>Order Date:</strong> {$order_date}</p>
                    <p style='color: #18181B; font-size: 14px; margin: 5px 0;'><strong>Estimated Delivery:</strong> {$estimated_delivery}</p>
                    <p style='color: #18181B; font-size: 14px; margin: 5px 0;'><strong>Payment Method:</strong> {$payment_method}</p>
                </div>

                <!-- Product List -->
                <h3 style='color: #18181B; font-size: 16px; margin-bottom: 10px;'>Order Items</h3>
                <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>
                    <thead>
                        <tr style='background-color: #f4f4f5;'>
                            <th style='padding: 10px; color: #18181B; font-size: 14px; text-align: left;'>Product</th>
                            <th style='padding: 10px; color: #18181B; font-size: 14px; text-align: center;'>Quantity</th>
                            <th style='padding: 10px; color: #18181B; font-size: 14px; text-align: right;'>Unit Price</th>
                            <th style='padding: 10px; color: #18181B; font-size: 14px; text-align: right;'>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$product_rows}
                    </tbody>
                </table>

                <!-- Total Summary -->
                <div style='text-align: right; margin-bottom: 20px;'>
                    <p style='color: #18181B; font-size: 14px; margin: 5px 0;'><strong>Subtotal:</strong> ₹" . number_format($subtotal, 2) . "</p>
                    <p style='color: #18181B; font-size: 14px; margin: 5px 0;'><strong>GST (18%):</strong> ₹" . number_format($gst, 2) . "</p>
                    <p style='color: #18181B; font-size: 16px; margin: 5px 0;'><strong>Grand Total:</strong> ₹" . number_format($total, 2) . "</p>
                </div>

                <!-- Delivery Address -->
                <h3 style='color: #18181B; font-size: 16px; margin-bottom: 10px;'>Delivery Address</h3>
                <p style='color: #757575; font-size: 14px; margin-bottom: 20px;'>{$delivery_address}</p>

                <!-- Thank You Message -->
                <p style='color: #18181B; font-size: 14px; text-align: center; margin-bottom: 20px;'>Thank you for choosing Karfect! We’ll notify you once your order is shipped.</p>
            </div>

            <!-- Footer -->
            <div style='background-color: #f4f4f5; padding: 15px; text-align: center;'>
                <p style='color: #757575; font-size: 12px; margin: 0;'>Need help? Contact us at <a href='mailto:support@karfect.com' style='color: #6b48ff; text-decoration: none;'>support@karfect.com</a> or +91-1234567890</p>
                <p style='color: #757575; font-size: 12px; margin: 5px 0;'>© 2025 Karfect Pvt. Ltd. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";
}
?>