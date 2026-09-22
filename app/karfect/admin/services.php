<?php
require_once 'includes/db_config.php'; // Database connection

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Secure input sanitization
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $original_price = filter_var($_POST['original_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $discounted_price = filter_var($_POST['discounted_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $duration = filter_var($_POST['duration'], FILTER_SANITIZE_STRING);
    $rating = filter_var($_POST['rating'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $reviews = filter_var($_POST['reviews'], FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    // Image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= $max_size) {
            $image = 'Uploads/' . uniqid() . '-' . basename($_FILES['image']['name']);
            $destination = $_SERVER['DOCUMENT_ROOT'] . '/karfect/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        } else {
            echo json_encode(['error' => 'Invalid image or size too large']);
            exit;
        }
    }

    // Add or Update
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $stmt = $conn->prepare("INSERT INTO services (title, original_price, discounted_price, image, category, duration, rating, reviews, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddssssis", $title, $original_price, $discounted_price, $image, $category, $duration, $rating, $reviews, $description);
        $stmt->execute();
        echo json_encode(['success' => 'Service added']);
        $stmt->close();
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("UPDATE services SET title=?, original_price=?, discounted_price=?, image=?, category=?, duration=?, rating=?, reviews=?, description=? WHERE id=?");
        $stmt->bind_param("sddssssisi", $title, $original_price, $discounted_price, $image, $category, $duration, $rating, $reviews, $description, $id);
        $stmt->execute();
        echo json_encode(['success' => 'Service updated']);
        $stmt->close();
    }
    exit;
}

// Delete service
if (isset($_GET['delete'])) {
    $id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("DELETE FROM services WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: services.php");
    exit;
}

// Fetch services
$category_filter = isset($_GET['category']) ? filter_var($_GET['category'], FILTER_SANITIZE_STRING) : '';
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_STRING) : '';
$sort = isset($_GET['sort']) ? filter_var($_GET['sort'], FILTER_SANITIZE_STRING) : 'title';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "1=1";
$params = [];
$types = "";
if ($category_filter) {
    $where .= " AND category=?";
    $params[] = $category_filter;
    $types .= "s";
}
if ($search) {
    $where .= " AND title LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}

$stmt = $conn->prepare("SELECT * FROM services WHERE $where ORDER BY $sort LIMIT ? OFFSET ?");
$params[] = $limit;
$params[] = $offset;
$types .= "ii";
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$services = $result->fetch_all(MYSQLI_ASSOC);

// Fetch categories
$categories = $conn->query("SELECT DISTINCT category FROM services")->fetch_all(MYSQLI_ASSOC);

// Pagination
$count_stmt = $conn->prepare("SELECT COUNT(*) as count FROM services WHERE $where");
if ($category_filter || $search) {
    $count_types = substr($types, 0, -2); // Remove 'ii' for LIMIT and OFFSET
    $count_params = array_slice($params, 0, -2); // Remove LIMIT and OFFSET params
    if ($count_types) {
        $count_stmt->bind_param($count_types, ...$count_params);
    }
}
$count_stmt->execute();
$total_services = $count_stmt->get_result()->fetch_assoc()['count'];
$total_pages = ceil($total_services / $limit);
$count_stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Admin Panel</title>
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
            stroke: #5f6368;
            margin-right: 8px;
        }

        .search-bar .btn {
            margin-left: 8px;
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

        /* Add Category */
        .add-category {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .add-category input {
            padding: 10px 16px;
            border: 1px solid #dadce0;
            border-radius: 8px;
            font-size: 14px;
            width: 100%;
            max-width: 200px;
            color: #202124;
        }

        .add-category input:focus {
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

        /* Service Cards */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .service-card {
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .service-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .service-card h3 {
            font-size: 16px;
            font-weight: 500;
            color: #202124;
            margin-bottom: 8px;
        }

        .service-card p {
            font-size: 13px;
            color: #5f6368;
            margin-bottom: 8px;
        }

        .service-card .price {
            color: #1a73e8;
            font-weight: 500;
            font-size: 14px;
        }

        .service-card .price span {
            color: #5f6368;
            font-weight: normal;
            font-size: 12px;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .actions .btn {
            flex: 1;
            text-align: center;
        }

        /* Form Container */
        .form-container {
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

        .form-container.active {
            display: flex;
        }

        .form-box {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
        }

        .form-box h2 {
            font-size: 20px;
            font-weight: 500;
            color: #202124;
            margin-bottom: 16px;
        }

        .form-box input,
        .form-box textarea,
        .form-box select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 12px;
            border: 1px solid #dadce0;
            border-radius: 8px;
            font-size: 14px;
            color: #202124;
            transition: border-color 0.2s ease;
        }

        .form-box input:focus,
        .form-box textarea:focus,
        .form-box select:focus {
            border-color: #1a73e8;
            outline: none;
        }

        .form-box textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-box button {
            margin-right: 8px;
        }

        /* Loader */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #1a73e8;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin: 16px auto;
            display: none;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination a {
            padding: 8px 16px;
            border: 1px solid #dadce0;
            border-radius: 8px;
            text-decoration: none;
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
            border-color: #1a73e8;
        }

        /* Animations */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

            .add-category {
                flex-direction: column;
                align-items: flex-start;
            }

            .add-category input {
                max-width: 100%;
            }

            .form-box {
                max-width: 90%;
                margin: 16px;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .search-bar {
                max-width: 100%;
            }

            .service-card img {
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <h5>Service Management</h5><br>
        <div class="container">
             <div class="controls-row">
                <form class="search-bar" id="search-form" method="GET">
                    <input type="text" id="search" name="search" placeholder="Search services..." value="<?php echo htmlspecialchars($search); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#6e42e5" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <button type="submit" class="btn">Search</button>
                </form>
                <div class="filters">
                    <select id="category-filter">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo $category_filter === $cat['category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select id="sort">
                        <option value="title" <?php echo $sort === 'title' ? 'selected' : ''; ?>>Sort by Title</option>
                        <option value="original_price" <?php echo $sort === 'original_price' ? 'selected' : ''; ?>>Sort by Price</option>
                        <option value="rating" <?php echo $sort === 'rating' ? 'selected' : ''; ?>>Sort by Rating</option>
                    </select>
                </div>
                <button class="btn" onclick="openForm('add')">Add Service</button>
            </div>
            <div class="filters">
                <select id="category-filter">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo $category_filter === $cat['category'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['category']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select id="sort">
                    <option value="title" <?php echo $sort === 'title' ? 'selected' : ''; ?>>Sort by Title</option>
                    <option value="original_price" <?php echo $sort === 'original_price' ? 'selected' : ''; ?>>Sort by Price</option>
                    <option value="rating" <?php echo $sort === 'rating' ? 'selected' : ''; ?>>Sort by Rating</option>
                </select>
            </div>

            <div class="add-category">
                <input type="text" id="new-category" placeholder="Add new category">
                <button class="btn" onclick="addCategory()">Add Category</button>
            </div>

            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <img src="/karfect/<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
                        <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                        <p class="price">₹<?php echo number_format($service['discounted_price'], 2); ?> <span style="text-decoration: line-through; color: #999;">₹<?php echo number_format($service['original_price'], 2); ?></span></p>
                        <p>Category: <?php echo htmlspecialchars($service['category']); ?></p>
                        <p>Duration: <?php echo htmlspecialchars($service['duration']); ?></p>
                        <p>Rating: <?php echo number_format($service['rating'], 1); ?> (<?php echo $service['reviews']; ?> reviews)</p>
                        <p><?php echo htmlspecialchars(substr($service['description'], 0, 100)); ?>...</p>
                        <div class="actions">
                            <button class="btn" onclick='editService(<?php echo json_encode($service); ?>)'>Edit</button>
                            <button class="btn" onclick="if(confirm('Delete this service?')) window.location.href='services.php?delete=<?php echo $service['id']; ?>'">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="services.php?page=<?php echo $i; ?>&category=<?php echo urlencode($category_filter); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>" class="<?php echo $page === $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>

            <div class="form-container" id="form-container">
                <div class="form-box">
                    <h2 id="form-title">Add Service</h2>
                    <form id="service-form" enctype="multipart/form-data">
                        <input type="hidden" id="action" name="action" value="add">
                        <input type="hidden" id="id" name="id">
                        <input type="text" id="title" name="title" placeholder="Service Title" required>
                        <input type="number" id="original_price" name="original_price" placeholder="Original Price" step="0.01" required>
                        <input type="number" id="discounted_price" name="discounted_price" placeholder="Discounted Price" step="0.01" required>
                        <input type="file" id="image" name="image" accept="image/*">
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['category']); ?>"><?php echo htmlspecialchars($cat['category']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" id="duration" name="duration" placeholder="Duration (e.g., 1 hour)">
                        <input type="number" id="rating" name="rating" placeholder="Rating (0-5)" step="0.1" min="0" max="5">
                        <input type="number" id="reviews" name="reviews" placeholder="Reviews" min="0">
                        <textarea id="description" name="description" placeholder="Description" rows="4"></textarea>
                        <button type="submit" class="btn">Save</button>
                        <button type="button" class="btn" onclick="document.getElementById('form-container').classList.remove('active')">Cancel</button>
                        <div class="loader" id="form-loader"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openForm(action, service = null) {
            const form = document.getElementById('service-form');
            const formTitle = document.getElementById('form-title');
            const formContainer = document.getElementById('form-container');
            const actionInput = document.getElementById('action');

            if (action === 'add') {
                formTitle.textContent = 'Add Service';
                actionInput.value = 'add';
                form.reset();
            } else {
                formTitle.textContent = 'Edit Service';
                actionInput.value = 'update';
                document.getElementById('id').value = service.id;
                document.getElementById('title').value = service.title;
                document.getElementById('original_price').value = service.original_price;
                document.getElementById('discounted_price').value = service.discounted_price;
                document.getElementById('category').value = service.category;
                document.getElementById('duration').value = service.duration;
                document.getElementById('rating').value = service.rating;
                document.getElementById('reviews').value = service.reviews;
                document.getElementById('description').value = service.description;
            }

            formContainer.classList.add('active');
        }

        function editService(service) {
            openForm('edit', service);
        }

        function addCategory() {
            const newCategory = document.getElementById('new-category').value;
            if (!newCategory) {
                alert('Please enter a category name');
                return;
            }

            const categorySelect = document.getElementById('category-filter');
            const formCategorySelect = document.getElementById('category');
            const option1 = new Option(newCategory, newCategory);
            const option2 = new Option(newCategory, newCategory);
            categorySelect.add(option1);
            formCategorySelect.add(option2);
            document.getElementById('new-category').value = '';
            alert('Category added');
        }

        document.getElementById('service-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const originalPrice = parseFloat(document.getElementById('original_price').value);
            const discountedPrice = parseFloat(document.getElementById('discounted_price').value);

            // Validate that discounted price is less than original price
            if (discountedPrice >= originalPrice) {
                alert('Discounted price must be less than original price');
                return;
            }

            const formData = new FormData(this);
            const loader = document.getElementById('form-loader');
            loader.style.display = 'block';

            fetch('services.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                loader.style.display = 'none';
                if (data.success) {
                    alert(data.success);
                    location.reload();
                } else {
                    alert(data.error || 'Something went wrong');
                }
            })
            .catch(() => {
                loader.style.display = 'none';
                alert('Error submitting form');
            });
        });

        document.getElementById('search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const searchInput = document.getElementById('search').value;
            const params = new URLSearchParams(window.location.search);
            params.set('search', searchInput);
            window.location.search = params.toString();
        });

        document.getElementById('category-filter').addEventListener('change', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('category', this.value);
            window.location.search = params.toString();
        });

        document.getElementById('sort').addEventListener('change', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('sort', this.value);
            window.location.search = params.toString();
        });
    </script>
</body>
</html>