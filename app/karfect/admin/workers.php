<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'includes/db_config.php'; // Database connection

// Fetch unique_id for credentials modal
if (isset($_GET['action']) && $_GET['action'] === 'fetch_unique_id') {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT unique_id FROM workers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode(['unique_id' => $result['unique_id'] ?? 'N/A']);
    $stmt->close();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $response = ['success' => false, 'message' => '', 'errors' => []];

    try {
        if ($action === 'add' || $action === 'edit') {
            // Validate inputs
            $id = $action === 'edit' ? (int)$_POST['id'] : 0;
            $name = trim($_POST['name'] ?? '');
            $categories = isset($_POST['categories']) ? implode(',', $_POST['categories']) : '';
            $dob = $_POST['dob'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $profession = trim($_POST['profession'] ?? '');
            $workzone = trim($_POST['workzone'] ?? '');
            $experience = (int)($_POST['experience'] ?? 0);
            $salary = (float)($_POST['salary'] ?? 0);
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $status = $_POST['status'] ?? '';

            // Validate required fields
            if (!$name) $response['errors']['name'] = 'Name is required';
            if (!$categories) $response['errors']['categories'] = 'Categories are required';
            if (!$dob) $response['errors']['dob'] = 'Date of Birth is required';
            if (!$gender) $response['errors']['gender'] = 'Gender is required';
            if (!$profession) $response['errors']['profession'] = 'Profession is required';
            if (!$workzone) $response['errors']['workzone'] = 'Workzone is required';
            if ($experience < 0) $response['errors']['experience'] = 'Experience cannot be negative';
            if ($salary < 0) $response['errors']['salary'] = 'Salary cannot be negative';
            if (!$phone) $response['errors']['phone'] = 'Phone is required';
            if (!$email) $response['errors']['email'] = 'Email is required';
            if (!$address) $response['errors']['address'] = 'Address is required';
            if (!$status) $response['errors']['status'] = 'Status is required';

            if (!empty($response['errors'])) {
                $response['message'] = 'Please fix the errors in the form';
                echo json_encode($response);
                exit;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Invalid email format';
                echo json_encode($response);
                exit;
            }

            // Check email uniqueness
            $email_check_query = $action === 'edit' ? "SELECT id FROM workers WHERE email = ? AND id != ?" : "SELECT id FROM workers WHERE email = ?";
            $stmt = $conn->prepare($email_check_query);
            if ($action === 'edit') {
                $stmt->bind_param("si", $email, $id);
            } else {
                $stmt->bind_param("s", $email);
            }
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $response['message'] = 'Email already exists';
                echo json_encode($response);
                exit;
            }

            // Validate phone
            if (!preg_match('/^\d{10}$/', $phone)) {
                $response['message'] = 'Phone number must be 10 digits';
                echo json_encode($response);
                exit;
            }

            // Handle image
            $image = $action === 'edit' ? ($_POST['existing_image'] ?? '') : '';
            if (isset($_FILES['image']) && $_FILES['image']['name']) {
                $allowed_types = ['image/jpeg', 'image/png'];
                $max_size = 5 * 1024 * 1024; // 5MB
                if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= $max_size) {
                    $image = 'admin/uploads/' . uniqid() . '-' . basename($_FILES['image']['name']);
                    $destination = $_SERVER['DOCUMENT_ROOT'] . '/karfect/' . $image;
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        $response['message'] = 'Failed to upload image';
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['message'] = 'Invalid image format or size';
                    echo json_encode($response);
                    exit;
                }
            }

            // Handle document
            $document = $action === 'edit' ? ($_POST['existing_document'] ?? '') : '';
            if (isset($_FILES['document']) && $_FILES['document']['name']) {
                $allowed_types = ['application/pdf'];
                $max_size = 10 * 1024 * 1024; // 10MB
                if (in_array($_FILES['document']['type'], $allowed_types) && $_FILES['document']['size'] <= $max_size) {
                    $document = 'admin/uploads/' . uniqid() . '-' . basename($_FILES['document']['name']);
                    $destination = $_SERVER['DOCUMENT_ROOT'] . '/karfect/' . $document;
                    if (!move_uploaded_file($_FILES['document']['tmp_name'], $destination)) {
                        $response['message'] = 'Failed to upload document';
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['message'] = 'Invalid document format or size';
                    echo json_encode($response);
                    exit;
                }
            }

            // Generate unique_id and password for add action
            $unique_id = $action === 'edit' ? ($_POST['existing_unique_id'] ?? '') : '';
            $password = '';
            $hashed_password = $action === 'edit' ? ($_POST['existing_password'] ?? '') : '';
            if ($action === 'add') {
                // Generate unique_id
                do {
                    $random_number = mt_rand(100000, 999999); // 6-digit random number
                    $unique_id = 'KARFECTWBSP' . $random_number;
                    $stmt = $conn->prepare("SELECT unique_id FROM workers WHERE unique_id = ?");
                    $stmt->bind_param("s", $unique_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } while ($result->num_rows > 0);

                // Generate password
                $name_lower = strtolower($name);
                $name_part = substr($name_lower, 0, 4);
                $dob_date = date('dm', strtotime($dob)); // e.g., 2407 for 24/07
                $password = $name_part . $dob_date;
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            }

            // Save to database
            if ($action === 'add') {
                $stmt = $conn->prepare("INSERT INTO workers (unique_id, name, categories, dob, gender, profession, workzone, experience, salary, phone, email, address, status, image, document, login_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssidsssssss", $unique_id, $name, $categories, $dob, $gender, $profession, $workzone, $experience, $salary, $phone, $email, $address, $status, $image, $document, $hashed_password);
            } else {
                $stmt = $conn->prepare("UPDATE workers SET name=?, categories=?, dob=?, gender=?, profession=?, workzone=?, experience=?, salary=?, phone=?, email=?, address=?, status=?, image=?, document=?, login_password=? WHERE id=?");
                $stmt->bind_param("sssssssidssssssi", $name, $categories, $dob, $gender, $profession, $workzone, $experience, $salary, $phone, $email, $address, $status, $image, $document, $hashed_password, $id);
            }

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = $action === 'add' ? "Worker added successfully. Unique ID: $unique_id, Login ID: $email, Password: $password" : 'Worker updated successfully';
            } else {
                $response['message'] = 'Database error: ' . $stmt->error;
            }
            $stmt->close();
        } elseif ($action === 'delete') {
            $id = (int)$_POST['id'];
            $stmt = $conn->prepare("DELETE FROM workers WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Worker deleted successfully';
            } else {
                $response['message'] = 'Database error: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Invalid action';
        }
    } catch (Exception $e) {
        $response['message'] = 'Server error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}

// Fetch workers
$status_filter = isset($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_STRING) : '';
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_STRING) : '';
$sort = isset($_GET['sort']) ? filter_var($_GET['sort'], FILTER_SANITIZE_STRING) : 'name';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "1=1";
$params = [];
$types = "";
if ($status_filter) {
    $where .= " AND status=?";
    $params[] = $status_filter;
    $types .= "s";
}
if ($search) {
    $where .= " AND (name LIKE ? OR email LIKE ? OR profession LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "sss";
}

$stmt = $conn->prepare("SELECT * FROM workers WHERE $where ORDER BY $sort LIMIT ? OFFSET ?");
$params[] = $limit;
$params[] = $offset;
$types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$workers = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Pagination
$count_stmt = $conn->prepare("SELECT COUNT(*) as count FROM workers WHERE $where");
if ($status_filter || $search) {
    $count_types = substr($types, 0, -2);
    $count_params = array_slice($params, 0, -2);
    if ($count_types) {
        $count_stmt->bind_param($count_types, ...$count_params);
    }
}
$count_stmt->execute();
$total_workers = $count_stmt->get_result()->fetch_assoc()['count'];
$total_pages = ceil($total_workers / $limit);
$count_stmt->close();

// Fetch categories from services
$categories_result = $conn->query("SELECT DISTINCT category FROM services");
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers Management</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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

/* Main Content */
.main-content {
    margin-left: 250px;
    padding: 24px;
    transition: margin-left 0.3s ease;
}

.main-content.full {
    margin-left: 0;
}

h5 {
    font-size: 24px;
    font-weight: 500;
    color: #1a73e8;
    margin-bottom: 16px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Search and Filters */
.search-filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.search-bar {
    display: flex;
    align-items: center;
    background-color: #fff;
    border: 1px solid #dadce0;
    border-radius: 24px;
    padding: 8px 16px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.2s ease;
    width: 100%;
    max-width: 400px;
    position: relative;
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
    stroke: #5f6368;
    margin-right: 8px;
}

.search-bar .btn {
    margin-left: 8px;
}

/* Select Inputs */
select {
    padding: 10px 16px;
    border: 1px solid #dadce0;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    color: #202124;
    cursor: pointer;
    transition: border-color 0.2s ease;
}

select:focus {
    outline: none;
    border-color: #1a73e8;
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
    transition: background-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.btn:hover {
    background-color: #185abc;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    transform: translateY(-1px);
}

.btn-danger {
    background-color: #d93025;
}

.btn-danger:hover {
    background-color: #b71c1c;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

#toggle-sidebar {
    display: none;
}

#toggle-sidebar svg {
    width: 24px;
    height: 24px;
}

/* Form Container */
.form-container {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
}

.form-container h2 {
    font-size: 20px;
    font-weight: 500;
    color: #202124;
    margin-bottom: 16px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 14px;
    font-weight: 500;
    color: #3c4043;
    margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px 12px;
    border: 1px solid #dadce0;
    border-radius: 8px;
    font-size: 14px;
    color: #202124;
    transition: border-color 0.2s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #1a73e8;
    outline: none;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

/* Select2 Custom Styling */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #dadce0;
    border-radius: 8px;
    padding: 4px;
}

.select2-container--default .select2-selection--multiple:focus {
    border-color: #1a73e8;
    outline: none;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e8f0fe;
    color: #202124;
    border: none;
    border-radius: 4px;
    padding: 4px 8px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #5f6368;
}

/* Table Container */
.table-container {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.table-container h2 {
    font-size: 20px;
    font-weight: 500;
    color: #202124;
    margin-bottom: 16px;
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
    background: #f1f3f4;
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

tr:nth-child(even) {
    background: #f8f9fa;
}

tr:hover {
    background: #e8f0fe;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    max-width: 700px;
    width: 90%;
    position: relative;
    animation: slideIn 0.3s ease;
}

.close {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 24px;
    cursor: pointer;
    color: #5f6368;
    transition: color 0.2s ease;
}

.close:hover {
    color: #202124;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

.details-grid div {
    font-size: 14px;
    color: #3c4043;
}

.details-grid strong {
    font-weight: 500;
    color: #202124;
}

.details-grid img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.details-grid a {
    color: #1a73e8;
    text-decoration: none;
}

.details-grid a:hover {
    text-decoration: underline;
}

/* Toast Notification */
.toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #202124;
    color: #fff;
    padding: 12px 24px;
    border-radius: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1100;
}

.toast.show {
    opacity: 1;
}

.toast.success {
    background: #34a853;
}

.toast.error {
    background: #d93025;
}

/* Pagination */
.table-container > div {
    margin-top: 24px;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
}

.table-container a.btn {
    padding: 8px 16px;
}

.table-container span {
    font-size: 14px;
    color: #5f6368;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 16px;
    }

    .search-filter {
        flex-direction: column;
        align-items: stretch;
    }

    .search-bar {
        max-width: 100%;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
        gap: 8px;
    }

    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    #toggle-sidebar {
        display: inline-block;
    }
}
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
         <h5>Workers Management</h5>
        <div class="container">
            <!-- Search and Filters -->
            <div class="search-filter">
                <form class="search-bar" id="search-form" method="GET">
                    <input type="text" id="search" name="search" placeholder="Search by name, email, profession..." value="<?php echo htmlspecialchars($search); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#6e42e5" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <button type="submit" class="btn" style="margin-left: 0.5rem;">Search</button>
                </form>
                <div>
                    <select id="status-filter" onchange="updateFilter('status', this.value)">
                        <option value="">All Status</option>
                        <option value="Active" <?php echo $status_filter === 'Active' ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo $status_filter === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="Suspended" <?php echo $status_filter === 'Suspended' ? 'selected' : ''; ?>>Suspended</option>
                    </select>
                    <select id="sort-filter" onchange="updateFilter('sort', this.value)">
                        <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Name</option>
                        <option value="experience" <?php echo $sort === 'experience' ? 'selected' : ''; ?>>Experience</option>
                        <option value="created_at" <?php echo $sort === 'created_at' ? 'selected' : ''; ?>>Recent Added</option>
                    </select>
                    <button id="toggle-sidebar" class="btn md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Add/Edit Worker Form -->
            <div class="form-container">
                <h2 id="form-title">Add Worker</h2>
                <form id="worker-form" enctype="multipart/form-data">
                    <input type="hidden" id="action" name="action" value="add">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="existing_image" name="existing_image">
                    <input type="hidden" id="existing_document" name="existing_document">
                    <input type="hidden" id="existing_password" name="existing_password">
                    <input type="hidden" id="existing_unique_id" name="existing_unique_id">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categories</label>
                            <select id="categories" name="categories[]" multiple required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat['category']); ?>"><?php echo htmlspecialchars($cat['category']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="profession">Profession</label>
                            <input type="text" id="profession" name="profession" placeholder="e.g., Hairdresser, Plumber" required>
                        </div>
                        <div class="form-group">
                            <label for="workzone">Workzone</label>
                            <input type="text" id="workzone" name="workzone" placeholder="e.g., Mumbai, Pune" required>
                        </div>
                        <div class="form-group">
                            <label for="experience">Experience (Years)</label>
                            <input type="number" id="experience" name="experience" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary (₹)</label>
                            <input type="number" id="salary" name="salary" min="0" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" pattern="\d{10}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Profile Image</label>
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png">
                        </div>
                        <div class="form-group">
                            <label for="document">Document (PDF)</label>
                            <input type="file" id="document" name="document" accept="application/pdf">
                        </div>
                    </div>
                    <button type="submit" class="btn" style="margin-top: 1.5rem;">Save Worker</button>
                </form>
            </div>

            <!-- Workers List -->
            <div class="table-container">
                <h2>Workers List</h2>
                <?php if (empty($workers)): ?>
                    <p>No workers found.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Unique ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Profession</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($workers as $worker): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($worker['unique_id']); ?></td>
                                    <td><?php echo htmlspecialchars($worker['name']); ?></td>
                                    <td><?php echo htmlspecialchars($worker['email']); ?></td>
                                    <td><?php echo htmlspecialchars($worker['profession']); ?></td>
                                    <td><?php echo htmlspecialchars($worker['status']); ?></td>
                                    <td class="action-buttons">
                                        <button class="btn" onclick="viewCredentials(<?php echo $worker['id']; ?>, '<?php echo htmlspecialchars($worker['email']); ?>', '<?php echo htmlspecialchars($worker['name']); ?>', '<?php echo htmlspecialchars($worker['dob']); ?>')" aria-label="View Credentials">Credentials</button>
                                        <button class="btn" onclick="viewDetails(<?php echo htmlspecialchars(json_encode($worker, JSON_HEX_QUOT | JSON_HEX_TAG)); ?>)" aria-label="View Details">Details</button>
                                        <button class="btn" onclick="editWorker(<?php echo htmlspecialchars(json_encode($worker, JSON_HEX_QUOT | JSON_HEX_TAG)); ?>)" aria-label="Edit Worker">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteWorker(<?php echo $worker['id']; ?>)" aria-label="Delete Worker">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div style="margin-top: 1.5rem; text-align: center;">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>&status=<?php echo urlencode($status_filter); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo urlencode($sort); ?>" class="btn">Previous</a>
                        <?php endif; ?>
                        <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&status=<?php echo urlencode($status_filter); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo urlencode($sort); ?>" class="btn">Next</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Credentials Modal -->
            <div id="credentials-modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('credentials-modal')">×</span>
                    <h2>Login Credentials</h2>
                    <p><strong>Unique ID:</strong> <span id="cred-unique-id"></span></p>
                    <p><strong>Login ID:</strong> <span id="cred-email"></span></p>
                    <p><strong>Password:</strong> <span id="cred-password"></span></p>
                </div>
            </div>

            <!-- Details Modal -->
            <div id="details-modal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('details-modal')">×</span>
                    <h2>Worker Details</h2>
                    <div class="details-grid">
                        <div><strong>Unique ID:</strong> <span id="detail-unique-id"></span></div>
                        <div><strong>Name:</strong> <span id="detail-name"></span></div>
                        <div><strong>Categories:</strong> <span id="detail-categories"></span></div>
                        <div><strong>DOB:</strong> <span id="detail-dob"></span></div>
                        <div><strong>Gender:</strong> <span id="detail-gender"></span></div>
                        <div><strong>Profession:</strong> <span id="detail-profession"></span></div>
                        <div><strong>Workzone:</strong> <span id="detail-workzone"></span></div>
                        <div><strong>Experience:</strong> <span id="detail-experience"></span></div>
                        <div><strong>Salary:</strong> <span id="detail-salary"></span></div>
                        <div><strong>Phone:</strong> <span id="detail-phone"></span></div>
                        <div><strong>Email:</strong> <span id="detail-email"></span></div>
                        <div><strong>Address:</strong> <span id="detail-address"></span></div>
                        <div><strong>Status:</strong> <span id="detail-status"></span></div>
                        <div><strong>Image:</strong> <img id="detail-image" src="/karfect/admin/uploads/default.jpg" alt="Profile Image" style="max-width: 200px;"></div>
                        <div><strong>Document:</strong> <a id="detail-document" href="#" target="_blank">Download PDF</a></div>
                    </div>
                </div>
            </div>

            <!-- Toast Notification -->
            <div id="toast" class="toast"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Initialize select2
        $(document).ready(function() {
            $('#categories').select2({
                placeholder: 'Select categories',
                allowClear: true
            });
        });

        // Form submission
        document.getElementById('worker-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('Form submitted'); // Debug
            const form = this;
            const toast = document.getElementById('toast');
            toast.className = 'toast show';
            toast.textContent = 'Processing...';

            const formData = new FormData(form);
            console.log('Form data:', Object.fromEntries(formData)); // Debug

            try {
                const response = await fetch('workers.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                console.log('Server response:', data); // Debug

                toast.textContent = data.message;
                toast.className = 'toast show ' + (data.success ? 'success' : 'error');

                if (data.success) {
                    form.reset();
                    $('#categories').val(null).trigger('change');
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    if (data.errors) {
                        toast.textContent = 'Validation errors: ' + Object.values(data.errors).join(', ');
                    }
                    setTimeout(() => toast.classList.remove('show'), 5000);
                }
            } catch (error) {
                console.error('Fetch error:', error); // Debug
                toast.textContent = 'Error processing request: ' + error.message;
                toast.className = 'toast show error';
                setTimeout(() => toast.classList.remove('show'), 5000);
            }
        });

        // Update filters
        function updateFilter(key, value) {
            const params = new URLSearchParams(window.location.search);
            if (value) {
                params.set(key, value);
            } else {
                params.delete(key);
            }
            window.location.search = params.toString();
        }

        // View credentials
        function viewCredentials(id, email, name, dob) {
            console.log('Viewing credentials for ID:', id); // Debug
            const nameLower = name.toLowerCase().slice(0, 4);
            const dobDate = new Date(dob).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' }).replace(/\//g, '');
            const password = nameLower + dobDate;
            fetch(`workers.php?action=fetch_unique_id&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched unique_id:', data); // Debug
                    document.getElementById('cred-unique-id').textContent = data.unique_id || 'N/A';
                    document.getElementById('cred-email').textContent = email;
                    document.getElementById('cred-password').textContent = password;
                    document.getElementById('credentials-modal').style.display = 'flex';
                })
                .catch(error => {
                    console.error('Error fetching unique_id:', error);
                    document.getElementById('cred-unique-id').textContent = 'Error';
                    document.getElementById('cred-email').textContent = email;
                    document.getElementById('cred-password').textContent = password;
                    document.getElementById('credentials-modal').style.display = 'flex';
                });
        }

        // View details
        function viewDetails(worker) {
            console.log('Viewing details:', worker); // Debug
            document.getElementById('detail-unique-id').textContent = worker.unique_id || 'N/A';
            document.getElementById('detail-name').textContent = worker.name || 'N/A';
            document.getElementById('detail-categories').textContent = worker.categories || 'N/A';
            document.getElementById('detail-dob').textContent = worker.dob || 'N/A';
            document.getElementById('detail-gender').textContent = worker.gender || 'N/A';
            document.getElementById('detail-profession').textContent = worker.profession || 'N/A';
            document.getElementById('detail-workzone').textContent = worker.workzone || 'N/A';
            document.getElementById('detail-experience').textContent = worker.experience ? worker.experience + ' years' : 'N/A';
            document.getElementById('detail-salary').textContent = worker.salary ? '₹' + worker.salary : 'N/A';
            document.getElementById('detail-phone').textContent = worker.phone || 'N/A';
            document.getElementById('detail-email').textContent = worker.email || 'N/A';
            document.getElementById('detail-address').textContent = worker.address || 'N/A';
            document.getElementById('detail-status').textContent = worker.status || 'N/A';
            const imagePath = (worker.image && typeof worker.image === 'string' && worker.image.trim().length > 0) 
                ? '/karfect/' + worker.image.trim() 
                : '/karfect/admin/uploads/default.jpg';
            document.getElementById('detail-image').src = imagePath;
            const documentPath = (worker.document && typeof worker.document === 'string' && worker.document.trim().length > 0) 
                ? '/karfect/' + worker.document.trim() 
                : '#';
            document.getElementById('detail-document').href = documentPath;
            document.getElementById('details-modal').style.display = 'flex';
        }

        // Edit worker
        function editWorker(worker) {
            console.log('Editing worker:', worker); // Debug
            document.getElementById('form-title').textContent = 'Edit Worker';
            document.getElementById('action').value = 'edit';
            document.getElementById('id').value = worker.id;
            document.getElementById('name').value = worker.name || '';
            const selectedCategories = worker.categories ? worker.categories.split(',') : [];
            $('#categories').val(selectedCategories).trigger('change');
            document.getElementById('dob').value = worker.dob || '';
            document.getElementById('gender').value = worker.gender || '';
            document.getElementById('profession').value = worker.profession || '';
            document.getElementById('workzone').value = worker.workzone || '';
            document.getElementById('experience').value = worker.experience || 0;
            document.getElementById('salary').value = worker.salary || 0;
            document.getElementById('phone').value = worker.phone || '';
            document.getElementById('email').value = worker.email || '';
            document.getElementById('address').value = worker.address || '';
            document.getElementById('status').value = worker.status || '';
            document.getElementById('existing_image').value = worker.image || '';
            document.getElementById('existing_document').value = worker.document || '';
            document.getElementById('existing_password').value = worker.login_password || '';
            document.getElementById('existing_unique_id').value = worker.unique_id || '';
            document.getElementById('image').required = false;
            document.getElementById('document').required = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Delete worker
        async function deleteWorker(id) {
            console.log('Deleting worker ID:', id); // Debug
            if (!confirm('Are you sure you want to delete this worker?')) return;
            const toast = document.getElementById('toast');
            toast.className = 'toast show';
            toast.textContent = 'Deleting...';

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            try {
                const response = await fetch('workers.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                console.log('Delete response:', data); // Debug
                toast.textContent = data.message;
                toast.className = 'toast show ' + (data.success ? 'success' : 'error');
                if (data.success) {
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    setTimeout(() => toast.classList.remove('show'), 3000);
                }
            } catch (error) {
                console.error('Delete error:', error); // Debug
                toast.textContent = 'Error deleting worker';
                toast.className = 'toast show error';
                setTimeout(() => toast.classList.remove('show'), 3000);
            }
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal on outside click
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });

        // Sidebar toggle
        document.getElementById('toggle-sidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('full');
        });
    </script>
</body>
</html>