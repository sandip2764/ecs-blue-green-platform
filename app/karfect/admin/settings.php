<?php
session_start();
require_once 'includes/db_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$admin_email = $_SESSION['admin_email'];
$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admins SET email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssi", $email, $hashed_password, $admin_id);
        } else {
            $stmt = $conn->prepare("UPDATE admins SET email = ? WHERE id = ?");
            $stmt->bind_param("si", $email, $admin_id);
        }
        if ($stmt->execute()) {
            $success = "Settings updated successfully";
            $_SESSION['admin_email'] = $email;
        } else {
            $error = "Error updating settings";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Karfect Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Sidebar */
.sidebar {
    width: 250px;
    height: 100vh;
    background: #fff;
    position: fixed;
    left: 0;
    top: 0;
    border-right: 1px solid #dadce0;
    transition: transform 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
}

.sidebar.hidden {
    transform: translateX(-250px);
}

.sidebar .p-0.border-b {
    padding: 16px;
    border-bottom: 1px solid #dadce0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sidebar img {
    max-width: 140px;
    height: auto;
    transition: transform 0.2s ease;
}

.sidebar img:hover {
    transform: scale(1.02);
}

.sidebar nav {
    padding: 8px;
}

.sidebar nav a {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    color: #5f6368;
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 4px;
    transition: background-color 0.2s ease, color 0.2s ease;
    position: relative;
}

.sidebar nav a:hover {
    background-color: #e8f0fe;
    color: #202124;
}

.sidebar nav a.active {
    background: #e8f0fe;
    color: #1a73e8;
    font-weight: 500;
}

.sidebar nav a.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #1a73e8;
    border-radius: 0 4px 4px 0;
}

.sidebar nav a svg {
    width: 20px;
    height: 20px;
    margin-right: 12px;
    stroke: #5f6368;
    stroke-width: 1.5;
}

.sidebar nav a.active svg {
    stroke: #1a73e8;
}

.sidebar nav a:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.3);
}

.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: #f5f7fa;
}

.sidebar::-webkit-scrollbar-thumb {
    background: #dadce0;
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #5f6368;
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
    color: #202124;
    margin-bottom: 16px;
}

/* Card */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card h3 {
    font-size: 20px;
    font-weight: 500;
    color: #202124;
    margin-bottom: 16px;
}

/* Form */
.mb-4 {
    margin-bottom: 16px;
}

label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #3c4043;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #dadce0;
    border-radius: 8px;
    font-size: 14px;
    color: #202124;
    transition: border-color 0.2s ease;
}

input:focus {
    border-color: #1a73e8;
    outline: none;
    box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
}

/* Button */
.btn {
    background-color: #1a73e8;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
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

/* Messages */
.error {
    color: #d93025;
    font-size: 14px;
    margin-bottom: 16px;
}

.success {
    color: #34a853;
    font-size: 14px;
    margin-bottom: 16px;
}

/* Active Account Section */
.mt-6 {
    margin-top: 24px;
}

.mt-6 h5 {
    font-size: 18px;
    font-weight: 500;
    color: #202124;
    margin-bottom: 8px;
}

.mt-6 p {
    font-size: 14px;
    color: #5f6368;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-250px);
    }

    .sidebar.active {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
        padding: 16px;
    }

    .card {
        max-width: 100%;
        padding: 16px;
    }
}
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="p-0 border-b">
            <img src="logo1.png" alt="Logo" class="img-fluid" style="margin: 0px 5px 5px 5px; max-width: 150px">
            <!--<h6 class="text-2xl font-bold text-var(--primary)"> Admin</h6>-->
        </div>
        <nav class="mt-3">
            <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'services.php' ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Services
            </a>
            <a href="workers.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'workers.php' ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Workers
            </a>
            <a href="bookings.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'bookings.php' ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Bookings
            </a>
            <a href="payments.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'payments.php' ? 'active' : ''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a4 4 0 00-8 0v2H5v10h14V9h-2zM9 7a2 2 0 114 0v2H9V7z" />
                </svg>
                Payments
            </a>
            <a href="settings.php" class="active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
            <a href="logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </a>
        </nav>
    </div>

    <div class="main-content" id="main-content">
        <div class="flex justify-between items-center mb-6">
            <h5 class="font-bold">Settings</h5>
            <!--<button id="toggle-sidebar" class="btn md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>-->
        </div>

        <div class="card max-w-lg">
            <h3 class="text-xl font-semibold mb-4">Update Account</h3>
            <?php if ($error): ?>
                <p class="error mb-4"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="success mb-4"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin_email); ?>" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-var(--primary)">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-var(--primary)">
                </div>
                <button type="submit" class="btn">Save Changes</button>
            </form>
            <div class="mt-6">
                <b><h5 class="text">Active Account</h5></b>
                <p class="text-gray-600">Email: <?php echo htmlspecialchars($admin_email); ?></p>
            </div>
        </div>
    </div>

    <!--<script>
        document.getElementById('toggle-sidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('full');
        });
    </script>-->
</body>
</html>