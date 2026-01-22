<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Campus Lost & Found</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo BASE_URL; ?>index.php">
                    <h2>🔍 Campus Lost & Found</h2>
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="<?php echo BASE_URL; ?>index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?php echo BASE_URL; ?>items/post_item.php">Post Item</a></li>
                    <li><a href="<?php echo BASE_URL; ?>user/dashboard.php">Dashboard</a></li>
                    <?php if (isAdmin()): ?>
                        <li><a href="<?php echo BASE_URL; ?>admin/dashboard.php">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo BASE_URL; ?>logout.php">Logout (<?php echo $_SESSION['full_name']; ?>)</a></li>
                <?php else: ?>
                    <li><a href="<?php echo BASE_URL; ?>login.php">Login</a></li>
                    <li><a href="<?php echo BASE_URL; ?>register.php" class="btn-register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    
    <main class="main-content">
