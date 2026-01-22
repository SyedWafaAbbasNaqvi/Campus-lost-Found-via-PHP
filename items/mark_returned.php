<?php
require_once '../config.php';
requireLogin();

// Get item ID
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($item_id == 0) {
    header("Location: ../index.php");
    exit();
}

// Check if user owns this item
$sql = "SELECT * FROM items WHERE item_id = $item_id AND user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../index.php");
    exit();
}

// Update status to returned
$update_sql = "UPDATE items SET status = 'returned' WHERE item_id = $item_id";

if (mysqli_query($conn, $update_sql)) {
    $_SESSION['message'] = 'Item marked as returned successfully!';
} else {
    $_SESSION['error'] = 'Failed to update item status!';
}

header("Location: view_item.php?id=$item_id");
exit();
?>
