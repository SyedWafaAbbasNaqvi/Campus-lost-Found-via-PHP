<?php
require_once '../config.php';
requireLogin();

// Get item ID
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($item_id == 0) {
    header("Location: ../index.php");
    exit();
}

// Check if user owns this item or is admin
$sql = "SELECT * FROM items WHERE item_id = $item_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../index.php");
    exit();
}

$item = mysqli_fetch_assoc($result);

// Check ownership
if ($item['user_id'] != $_SESSION['user_id'] && !isAdmin()) {
    header("Location: ../index.php");
    exit();
}

// Delete the item
$delete_sql = "DELETE FROM items WHERE item_id = $item_id";

if (mysqli_query($conn, $delete_sql)) {
    // Delete image file if not default
    if ($item['image_path'] != 'default.jpg') {
        @unlink('../uploads/' . $item['image_path']);
    }
    
    $_SESSION['message'] = 'Item deleted successfully!';
    header("Location: ../user/dashboard.php");
} else {
    $_SESSION['error'] = 'Failed to delete item!';
    header("Location: view_item.php?id=$item_id");
}

exit();
?>
