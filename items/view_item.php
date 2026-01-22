<?php
require_once '../config.php';

$page_title = 'Item Details';

// Get item ID
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($item_id == 0) {
    header("Location: ../index.php");
    exit();
}

// Fetch item details
$sql = "SELECT i.*, u.full_name, u.email as user_email, u.phone as user_phone 
        FROM items i 
        JOIN users u ON i.user_id = u.user_id 
        WHERE i.item_id = $item_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../index.php");
    exit();
}

$item = mysqli_fetch_assoc($result);
$is_owner = isLoggedIn() && $_SESSION['user_id'] == $item['user_id'];

include '../includes/header.php';
?>

<div class="container">
    <div class="item-detail-container">
        <div class="item-detail-image">
            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $item['image_path']; ?>" 
                 alt="<?php echo htmlspecialchars($item['title']); ?>"
                 onerror="this.src='<?php echo BASE_URL; ?>uploads/default.jpg'">
        </div>
        
        <div class="item-detail-info">
            <div class="item-badges">
                <span class="badge badge-<?php echo $item['type']; ?>">
                    <?php echo ucfirst($item['type']); ?>
                </span>
                <span class="badge badge-<?php echo $item['status']; ?>">
                    <?php echo ucfirst($item['status']); ?>
                </span>
            </div>
            
            <h1><?php echo htmlspecialchars($item['title']); ?></h1>
            
            <div class="item-meta">
                <p><strong>📂 Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
                <p><strong>📍 Location:</strong> <?php echo htmlspecialchars($item['location']); ?></p>
                <p><strong>📅 Date:</strong> <?php echo formatDate($item['date_lost_found']); ?></p>
                <p><strong>⏰ Posted:</strong> <?php echo timeAgo($item['posted_at']); ?></p>
                <p><strong>👤 Posted by:</strong> <?php echo htmlspecialchars($item['full_name']); ?></p>
            </div>
            
            <div class="item-description">
                <h3>Description</h3>
                <p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
            </div>
            
            <?php if (isLoggedIn() && !$is_owner && $item['status'] == 'active'): ?>
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <?php if (!empty($item['contact_name'])): ?>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($item['contact_name']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($item['contact_phone'])): ?>
                        <p><strong>Phone:</strong> <a href="tel:<?php echo $item['contact_phone']; ?>"><?php echo htmlspecialchars($item['contact_phone']); ?></a></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($item['contact_email'])): ?>
                        <p><strong>Email:</strong> <a href="mailto:<?php echo $item['contact_email']; ?>"><?php echo htmlspecialchars($item['contact_email']); ?></a></p>
                    <?php endif; ?>
                </div>
            <?php elseif (!isLoggedIn()): ?>
                <div class="alert alert-info">
                    <p>Please <a href="<?php echo BASE_URL; ?>login.php">login</a> to view contact information</p>
                </div>
            <?php endif; ?>
            
            <?php if ($is_owner): ?>
                <div class="owner-actions">
                    <h3>Your Actions</h3>
                    <a href="edit_item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-primary">Edit Item</a>
                    
                    <?php if ($item['status'] == 'active'): ?>
                        <a href="mark_returned.php?id=<?php echo $item['item_id']; ?>" 
                           class="btn btn-success"
                           onclick="return confirm('Mark this item as returned/claimed?')">Mark as Returned</a>
                    <?php endif; ?>
                    
                    <a href="delete_item.php?id=<?php echo $item['item_id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this item?')">Delete Item</a>
                </div>
            <?php endif; ?>
            
            <div class="back-button">
                <a href="<?php echo BASE_URL; ?>index.php" class="btn btn-secondary">← Back to Items</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
