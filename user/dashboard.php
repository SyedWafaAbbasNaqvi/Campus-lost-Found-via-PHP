<?php
require_once '../config.php';
requireLogin();

$page_title = 'Dashboard';
$user_id = $_SESSION['user_id'];

// Get user's items
$sql = "SELECT * FROM items WHERE user_id = $user_id ORDER BY posted_at DESC";
$result = mysqli_query($conn, $sql);

// Get user statistics
$stats_sql = "SELECT 
                COUNT(*) as total_posts,
                SUM(CASE WHEN type = 'lost' THEN 1 ELSE 0 END) as lost_posts,
                SUM(CASE WHEN type = 'found' THEN 1 ELSE 0 END) as found_posts,
                SUM(CASE WHEN status = 'returned' THEN 1 ELSE 0 END) as returned_posts
              FROM items 
              WHERE user_id = $user_id";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

include '../includes/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Welcome, <?php echo $_SESSION['full_name']; ?>! 👋</h1>
        <p>Manage your posted items</p>
    </div>
    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    
    <!-- User Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-number"><?php echo $stats['total_posts']; ?></div>
            <div class="stat-label">Total Posts</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔍</div>
            <div class="stat-number"><?php echo $stats['lost_posts']; ?></div>
            <div class="stat-label">Lost Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-number"><?php echo $stats['found_posts']; ?></div>
            <div class="stat-label">Found Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎉</div>
            <div class="stat-number"><?php echo $stats['returned_posts']; ?></div>
            <div class="stat-label">Returned</div>
        </div>
    </div>
    
    <div class="dashboard-actions">
        <a href="../items/post_item.php" class="btn btn-primary">📝 Post New Item</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Browse All Items</a>
    </div>
    
    <h2 class="section-title">Your Posted Items</h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $item['image_path']; ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                     class="table-image"
                                     onerror="this.src='<?php echo BASE_URL; ?>uploads/default.jpg'">
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($item['title']); ?></strong><br>
                                <small><?php echo timeAgo($item['posted_at']); ?></small>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $item['type']; ?>">
                                    <?php echo ucfirst($item['type']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($item['category']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $item['status']; ?>">
                                    <?php echo ucfirst($item['status']); ?>
                                </span>
                            </td>
                            <td><?php echo formatDate($item['date_lost_found']); ?></td>
                            <td class="action-buttons">
                                <a href="../items/view_item.php?id=<?php echo $item['item_id']; ?>" 
                                   class="btn btn-sm btn-info" title="View">👁️</a>
                                <a href="../items/edit_item.php?id=<?php echo $item['item_id']; ?>" 
                                   class="btn btn-sm btn-primary" title="Edit">✏️</a>
                                
                                <?php if ($item['status'] == 'active'): ?>
                                    <a href="../items/mark_returned.php?id=<?php echo $item['item_id']; ?>" 
                                       class="btn btn-sm btn-success" title="Mark Returned"
                                       onclick="return confirm('Mark as returned?')">✓</a>
                                <?php endif; ?>
                                
                                <a href="../items/delete_item.php?id=<?php echo $item['item_id']; ?>" 
                                   class="btn btn-sm btn-danger" title="Delete"
                                   onclick="return confirm('Delete this item?')">🗑️</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="no-items">
            <p>😔 You haven't posted any items yet.</p>
            <a href="../items/post_item.php" class="btn btn-primary">Post Your First Item</a>
        </div>
    <?php endif; ?>
</div>

