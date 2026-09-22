<?php
require_once 'includes/db_config.php'; // Database connection

// Handle AJAX request for booking details
if (isset($_GET['get_details'])) {
    header('Content-Type: application/json; charset=utf-8');
    $order_id = filter_var($_GET['get_details'], FILTER_SANITIZE_STRING);
    
    try {
        $stmt = $conn->prepare("
            SELECT o.user_id, o.order_id, oi.title AS service_name, s.category AS service_category,
                   o.status, oi.image AS service_image, o.total_amount, o.address, o.created_at,
                   u.email, u.phone, oi.quantity, t.payment_id, t.status AS transaction_status
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN services s ON oi.service_id = s.id
            LEFT JOIN transactions t ON o.order_id = t.order_id
            WHERE o.order_id = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Booking not found']);
        }
        $stmt->close();
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
}

// Handle Delete operation
if (isset($_GET['delete'])) {
    $order_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
    
    try {
        $conn->begin_transaction(); // Start transaction
        
        // Delete from order_items first due to foreign key constraint
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $stmt->close();
        
        // Delete from orders
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $stmt->close();
        
        $conn->commit(); // Commit transaction
        header("Location: bookings.php?message=Booking deleted successfully");
    } catch (Exception $e) {
        $conn->rollback(); // Rollback on error
        header("Location: bookings.php?error=Failed to delete booking: " . urlencode($e->getMessage()));
    }
    exit;
}

include 'sidebar.php';

// Fetch bookings
$category_filter = isset($_GET['category']) ? filter_var($_GET['category'], FILTER_SANITIZE_STRING) : '';
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_STRING) : '';
$sort = isset($_GET['sort']) && in_array($_GET['sort'], ['order_id', 'recent']) ? $_GET['sort'] : 'order_id';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "1=1";
$params = [];
$types = "";
if ($category_filter) {
    $where .= " AND s.category = ?";
    $params[] = $category_filter;
    $types .= "s";
}
if ($search) {
    $where .= " AND (u.email LIKE ? OR o.order_id LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "ss";
}

$query = "SELECT o.order_id, u.email, o.status
          FROM orders o
          JOIN users u ON o.user_id = u.id
          JOIN order_items oi ON o.order_id = oi.order_id
          JOIN services s ON oi.service_id = s.id
          WHERE $where
          GROUP BY o.order_id
          ORDER BY " . ($sort === 'recent' ? 'o.created_at DESC' : 'o.order_id') . "
          LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

try {
    $stmt = $conn->prepare($query);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    $bookings = [];
    $error_message = "Failed to fetch bookings: " . $e->getMessage();
}

// Fetch categories
try {
    $result = $conn->query("SELECT DISTINCT category FROM services ORDER BY category");
    $categories = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $categories = [];
    $error_message = isset($error_message) ? $error_message : "Failed to fetch categories: " . $e->getMessage();
}

// Pagination
$count_query = "SELECT COUNT(DISTINCT o.order_id) as count
                FROM orders o
                JOIN users u ON o.user_id = u.id
                JOIN order_items oi ON o.order_id = oi.order_id
                JOIN services s ON oi.service_id = s.id
                WHERE $where";
try {
    $count_stmt = $conn->prepare($count_query);
    if ($types && strlen($types) > 2) { // Exclude 'ii' for LIMIT/OFFSET
        $count_types = substr($types, 0, -2);
        $count_params = array_slice($params, 0, -2);
        $count_stmt->bind_param($count_types, ...$count_params);
    }
    $count_stmt->execute();
    $total_bookings = $count_stmt->get_result()->fetch_assoc()['count'];
    $total_pages = ceil($total_bookings / $limit);
    $count_stmt->close();
} catch (Exception $e) {
    $total_bookings = 0;
    $total_pages = 1;
    $error_message = isset($error_message) ? $error_message : "Failed to calculate pagination: " . $e->getMessage();
}

?>

<style>
/* Reset and Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
        background-color: #f5f7fa;
        color: #202124;
        line-height: 1.5;
        font-size: 14px;
    }

    /* Container */
    .container-fluid {
        max-width: 1280px;
        margin: 0 auto;
        padding: 24px;
    }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        padding: 24px;
        transition: margin-left 0.3s ease;
    }

    .main-content.full {
        margin-left: 0;
    }

    h4 {
        font-size: 24px;
        font-weight: 500;
        color: #1a73e8;
        margin-bottom: 16px;
    }

    h6 {
        font-size: 14px;
        font-weight: 400;
        color: #5f6368;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    /* Controls Row */
    .controls-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
        margin-bottom: 24px;
    }

    /* Search Bar */
    .search-bar {
        display: flex;
        align-items: center;
        background-color: #fff;
        border: 1px solid #dadce0;
        border-radius: 24px;
        padding: 8px 16px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.2s ease;
        flex: 1;
        min-width: 250px;
        max-width: 400px;
    }

    .search-bar:focus-within {
        box-shadow: 0 1px 6px rgba(32, 33, 36, 0.28);
    }

    .search-bar input {
        border: none;
        outline: none;
        font-size: 14px;
        flex: 1;
        background: transparent;
        color: #202124;
    }

    .search-bar svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: #5f6368;
    }

    /* Buttons */
    .btn {
        background-color: #1a73e8;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .btn:hover {
        background-color: #185abc;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .btn.loading {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .badge-btn {
        padding: 6px 12px;
        font-size: 13px;
        margin-right: 8px;
    }

    .badge-btn:disabled {
        background-color: #dadce0;
        cursor: not-allowed;
    }

    /* Filters */
    .filters {
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .filters select {
        padding: 10px 16px;
        border: 1px solid #dadce0;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
        color: #202124;
        cursor: pointer;
        transition: border-color 0.2s ease;
        min-width: 150px;
    }

    .filters select:focus {
        outline: none;
        border-color: #1a73e8;
    }

    /* Table */
    .table-container {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
        font-size: 14px;
    }

    th {
        background-color: #f1f3f4;
        color: #202124;
        font-weight: 500;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    td {
        border-top: 1px solid #dadce0;
    }

    tr {
        transition: background-color 0.2s ease;
    }

    tr:hover {
        background-color: #f8f9fa;
    }

    /* Details Popup */
    .details-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .details-container.active {
        display: flex;
    }

    .details-box {
        background-color: #fff;
        padding: 24px;
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.3s ease;
        max-height: 80vh;
        overflow-y: auto;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .details-box h2 {
        font-size: 20px;
        font-weight: 500;
        color: #202124;
        margin-bottom: 16px;
    }

    .details-box p {
        margin: 8px 0;
        font-size: 14px;
        color: #3c4043;
    }

    .details-box img {
        max-width: 100%;
        border-radius: 8px;
        margin: 12px 0;
    }

    /* Pagination */
    .pagination {
        margin-top: 24px;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .pagination a {
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 8px;
        background: #f1f3f4;
        color: #202124;
        font-size: 14px;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .pagination a:hover {
        background: #e8f0fe;
        color: #1a73e8;
    }

    .pagination a.active {
        background: #1a73e8;
        color: #fff;
    }

    /* Alerts */
    .alert {
        padding: 12px 16px;
        margin-bottom: 16px;
        border-radius: 8px;
        position: relative;
        animation: slideIn 0.3s ease;
    }

    .alert-success {
        background-color: #e8f0fe;
        color: #174ea6;
        border: 1px solid #d2e3fc;
    }

    .alert-danger {
        background-color: #fce8e6;
        color: #a50e0e;
        border: 1px solid #fad2cf;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
            padding: 16px;
        }

        .controls-row {
            flex-direction: column;
            align-items: stretch;
        }

        .search-bar {
            max-width: 100%;
            min-width: auto;
        }

        .filters {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .filters select {
            flex: 1;
            min-width: 120px;
        }

        .details-box {
            margin: 16px;
            max-width: calc(100% - 32px);
        }
    }
</style>

<div class="main-content" id="main-content">
    <h4>Bookings</h4>
    <div class="container-fluid" role="main">
        <div class="row">
            <div class="col-12">
                <?php if (isset($_GET['message'])): ?>
                    <div class="alert alert-success" role="alert"><?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="controls-row">
            <form class="search-bar" id="search-form" method="GET" action="bookings.php" aria-label="Search bookings">
                <input type="text" id="search" name="search" placeholder="Search by email or order ID..." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Search input">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#6e42e5" stroke-width="2" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <button type="submit" class="btn" aria-label="Submit search">Search</button>
            </form>
            <div class="filters">
                <select id="category-filter" name="category" aria-label="Filter by category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['category'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $category_filter === $cat['category'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['category'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select id="sort" name="sort" aria-label="Sort bookings">
                    <option value="order_id" <?php echo $sort === 'order_id' ? 'selected' : ''; ?>>Sort by Order ID</option>
                    <option value="recent" <?php echo $sort === 'recent' ? 'selected' : ''; ?>>Sort by Recent Booking</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <table role="grid">
                <thead>
                    <tr>
                        <th scope="col">Registered Email</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr><td colspan="4">No bookings found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['order_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($booking['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <button class="btn badge-btn" data-order-id="<?php echo htmlspecialchars($booking['order_id'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="View details for order <?php echo htmlspecialchars($booking['order_id'], ENT_QUOTES, 'UTF-8'); ?>">View Details</button>
                                    <button class="btn badge-btn" data-order-id="<?php echo htmlspecialchars($booking['order_id'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Delete order <?php echo htmlspecialchars($booking['order_id'], ENT_QUOTES, 'UTF-8'); ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination" role="navigation" aria-label="Pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="bookings.php?page=<?php echo $i; ?>&category=<?php echo urlencode($category_filter); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo urlencode($sort); ?>" class="<?php echo $page === $i ? 'active' : ''; ?>" aria-current="<?php echo $page === $i ? 'page' : 'false'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>

        <div class="details-container" id="details-container" role="dialog" aria-labelledby="details-title" aria-modal="true">
            <div class="details-box">
                <h2 id="details-title">Booking Details</h2>
                <div id="details-content"></div>
                <button type="button" class="btn" aria-label="Close details">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
  
class Bookings {
  /**
   * Initialize the module
   * @static
   */
  static init() {
    this.cacheDOM();
    this.bindEvents();
  }

  /**
   * Cache DOM elements to minimize reflows
   * @static
   */
  static cacheDOM() {
    this.container = document.querySelector('.container-fluid');
    this.detailsContainer = document.getElementById('details-container');
    this.detailsContent = document.getElementById('details-content');
    this.searchForm = document.getElementById('search-form');
    this.searchInput = document.getElementById('search');
    this.categoryFilter = document.getElementById('category-filter');
    this.sortFilter = document.getElementById('sort');
    this.tableBody = document.querySelector('.table-container tbody');
    this.closeButton = this.detailsContainer?.querySelector('.btn');
  }

  /**
   * Bind event listeners for UI interactions
   * @static
   */
  static bindEvents() {
    // Event delegation for View Details and Delete buttons
    if (this.tableBody) {
      this.tableBody.addEventListener('click', this.handleTableActions.bind(this));
    }

    // Search input with debouncing
    if (this.searchInput) {
      this.searchInput.addEventListener('input', this.debounce(this.handleSearch.bind(this), 300));
    }

    // Category and sort filter changes
    if (this.categoryFilter) {
      this.categoryFilter.addEventListener('change', this.handleFilterChange.bind(this));
    }
    if (this.sortFilter) {
      this.sortFilter.addEventListener('change', this.handleFilterChange.bind(this));
    }

    // Close details popup
    if (this.closeButton) {
      this.closeButton.addEventListener('click', this.closeDetails.bind(this));
    }

    // Prevent form resubmission on refresh
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  }

  /**
   * Handle table button clicks (View Details, Delete)
   * @static
   * @param {Event} event - The click event
   */
  static handleTableActions(event) {
    const target = event.target;
    if (target.classList.contains('badge-btn')) {
      const orderId = target.getAttribute('data-order-id');
      if (target.textContent.includes('View Details')) {
        this.viewDetails(orderId);
      } else if (target.textContent.includes('Delete') && confirm('Are you sure you want to delete this booking?')) {
        window.location.href = `bookings.php?delete=${encodeURIComponent(orderId)}`;
      }
    }
  }

  /**
   * Handle search input
   * @static
   */
  static handleSearch() {
    if (this.searchForm) {
      this.searchForm.submit();
    }
  }

  /**
   * Handle filter changes (category or sort)
   * @static
   * @param {Event} event - The change event
   */
  static handleFilterChange(event) {
    const url = new URL(window.location);
    url.searchParams.set(event.target.id === 'category-filter' ? 'category' : 'sort', event.target.value);
    url.searchParams.set('page', '1');
    window.location.href = url.toString();
  }

  /**
   * Fetch and display booking details
   * @static
   * @param {string} orderId - The order ID
   */
  static async viewDetails(orderId) {
    try {
      this.toggleLoadingState(true, orderId);
      const response = await fetch(`bookings.php?get_details=${encodeURIComponent(orderId)}`, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const data = await response.json();

      if (data.error) {
        this.showError(data.error);
        return;
      }

      this.renderDetails(data);
      this.detailsContainer.classList.add('active');
    } catch (error) {
      this.showError(`Error fetching details: ${error.message}`);
    } finally {
      this.toggleLoadingState(false, orderId);
    }
  }

  /**
   * Render booking details in the popup
   * @static
   * @param {Object} data - The booking data
   */
  static renderDetails(data) {
    const safeData = this.sanitizeData(data);
    const content = `
      <p><strong>User ID:</strong> ${safeData.user_id}</p>
      <p><strong>Order ID:</strong> ${safeData.order_id}</p>
      <p><strong>Service Name:</strong> ${safeData.service_name}</p>
      <p><strong>Service Category:</strong> ${safeData.service_category}</p>
      <p><strong>Quantity:</strong> ${safeData.quantity || 'N/A'}</p>
      <p><strong>Booking Status:</strong> ${safeData.status}</p>
      <p><strong>Paid Amount:</strong> ₹${safeData.total_amount || 'N/A'}</p>
      <p><strong>Address:</strong> ${safeData.address}</p>
      <p><strong>Booking Time:</strong> ${new Date(safeData.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}</p>
      <p><strong>Email:</strong> ${safeData.email}</p>
      <p><strong>Contact:</strong> ${safeData.phone || 'Not provided'}</p>
      ${safeData.payment_id ? `<p><strong>Payment ID:</strong> ${safeData.payment_id}</p>` : ''}
      ${safeData.transaction_status ? `<p><strong>Transaction Status:</strong> ${safeData.transaction_status}</p>` : ''}
      ${safeData.service_image ? `<img src="/karfect/${safeData.service_image}" alt="Service Image" style="max-width: 200px;" loading="lazy">` : ''}
    `;
    this.detailsContent.innerHTML = content;
  }

  /**
   * Close the details popup
   * @static
   */
  static closeDetails() {
    if (this.detailsContainer) {
      this.detailsContainer.classList.remove('active');
      this.detailsContent.innerHTML = ''; // Clear content for security
    }
  }

  /**
   * Sanitize data to prevent XSS
   * @static
   * @param {Object} data - The data to sanitize
   * @returns {Object} - Sanitized data
   */
  static sanitizeData(data) {
    const sanitized = {};
    for (const [key, value] of Object.entries(data)) {
      sanitized[key] = this.escapeHTML(value);
    }
    return sanitized;
  }

  /**
   * Escape HTML to prevent XSS
   * @static
   * @param {string} str - The string to escape
   * @returns {string} - Escaped string
   */
  static escapeHTML(str) {
    if (typeof str !== 'string') return str;
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  /**
   * Show error message to user
   * @static
   * @param {string} message - The error message
   */
  static showError(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger';
    alertDiv.textContent = message;
    this.container.insertBefore(alertDiv, this.container.firstChild);
    setTimeout(() => alertDiv.remove(), 5000); // Auto-dismiss after 5 seconds
  }

  /**
   * Toggle loading state for buttons
   * @static
   * @param {boolean} isLoading - Whether to show loading state
   * @param {string} orderId - The order ID for specific button
   */
  static toggleLoadingState(isLoading, orderId) {
    const buttons = this.tableBody.querySelectorAll(`[data-order-id="${orderId}"]`);
    buttons.forEach(button => {
      if (button.textContent.includes('View Details') || button.textContent.includes('Loading...')) {
        button.disabled = isLoading;
        button.textContent = isLoading ? 'Loading...' : 'View Details';
        button.classList.toggle('loading', isLoading);
      }
    });
  }

  /**
   * Debounce function to limit rapid executions
   * @static
   * @param {Function} func - The function to debounce
   * @param {number} wait - The wait time in milliseconds
   * @returns {Function} - Debounced function
   */
  static debounce(func, wait) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Bookings.init());
</script>
