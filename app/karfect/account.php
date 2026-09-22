<<<<<<< HEAD
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'includes/check_login.php';
require 'includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_PATH . 'login.php');
    exit;
}

$stmt = $conn->prepare("SELECT name, email, address FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE users SET name = :name, address = :address WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'address' => $address,
        'id' => $_SESSION['user_id']
    ]);

    $_SESSION['user_name'] = $name;

    $cookie_value = $_SESSION['user_id'] . '|' . $name;
    $cookie_expiry = time() + (30 * 24 * 60 * 60);
    setcookie('user_login', $cookie_value, $cookie_expiry, BASE_PATH);

    header('Location: ' . BASE_PATH . 'account.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="account-container">
        <h1>Account Details</h1>
        <form method="POST" class="account-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email (Cannot be changed)</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
            </div>
            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</body>
=======
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'includes/check_login.php';
require 'includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_PATH . 'login.php');
    exit;
}

$stmt = $conn->prepare("SELECT name, email, address FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE users SET name = :name, address = :address WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'address' => $address,
        'id' => $_SESSION['user_id']
    ]);

    $_SESSION['user_name'] = $name;

    $cookie_value = $_SESSION['user_id'] . '|' . $name;
    $cookie_expiry = time() + (30 * 24 * 60 * 60);
    setcookie('user_login', $cookie_value, $cookie_expiry, BASE_PATH);

    header('Location: ' . BASE_PATH . 'account.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Karfect</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="account-container">
        <h1>Account Details</h1>
        <form method="POST" class="account-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email (Cannot be changed)</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
            </div>
            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</body>
>>>>>>> 06bb5e3e5c2a2925aea4806216dde7237ed907e0
</html>