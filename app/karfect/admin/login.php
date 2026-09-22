<?php
session_start();
require_once 'includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Karfect</title>
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
            background: #f5f7fa;
            color: #202124;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Login Card */
        .login-card {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .login-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .login-card h2 {
            font-size: 20px;
            font-weight: 500;
            color: #202124;
            text-align: center;
            margin-bottom: 24px;
        }

        /* Logo */
        .logo {
            display: block;
            margin: 0 auto 16px;
            max-width: 150px;
            height: auto;
        }

        /* Form */
        .mb-4 {
            margin-bottom: 16px;
        }

        .mb-6 {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #3c4043;
            margin-bottom: 8px;
        }

        /* Input Group */
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group input {
            width: 100%;
            padding: 10px 12px 10px 36px; /* Adjusted padding for icon */
            border: 1px solid #dadce0;
            border-radius: 8px;
            font-size: 14px;
            color: #202124;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-group input:focus {
            border-color: #1a73e8;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
        }

        .input-group svg {
            position: absolute;
            left: 12px;
            width: 16px;
            height: 16px;
            stroke: #5f6368;
        }

        /* Button */
        .btn {
            background-color: #1a73e8;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #1557b0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        /* Error Message */
        .error {
            color: #d93025;
            font-size: 14px;
            text-align: center;
            margin-bottom: 16px;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .login-card {
                max-width: 90%;
                padding: 16px;
            }

            .login-card h2 {
                font-size: 18px;
            }

            .input-group input {
                padding: 8px 10px 8px 32px; /* Adjusted for smaller screens */
                font-size: 13px;
            }

            .input-group svg {
                left: 10px;
                width: 14px;
                height: 14px;
            }

            .btn {
                padding: 8px;
                font-size: 13px;
            }

            .logo {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card animate-fade-in">
        <img src="logo1.png" alt="Karfect Logo" class="logo">
        <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="input-group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <input type="email" id="email" name="email" required class="mt-1 w-full border rounded-md focus:ring focus:ring-var(--primary)">
                </div>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="input-group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M12 17v-4m0 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-1.1-2-2-2zm0-7c-3.3 0-6 2.7-6 6s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6z"/>
                        <path d="M12 3v2"/>
                        <path d="M12 19v2"/>
                        <path d="M5 12H3"/>
                        <path d="M21 12h-2"/>
                    </svg>
                    <input type="password" id="password" name="password" required class="mt-1 w-full border rounded-md focus:ring focus:ring-var(--primary)">
                </div>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
