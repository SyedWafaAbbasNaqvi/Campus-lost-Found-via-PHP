<?php
require_once '../config.php';
requireLogin();

// Check if user is admin
if (!isAdmin()) {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

$page_title = 'Admin Dashboard';

// Get all statistics
$stats_sql = "SELECT 
                (SELECT COUNT(*) FROM items) as total_items,
                (SELECT COUNT(*) FROM items WHERE type = 'lost') as lost_items,
                (SELECT COUNT(*) FROM items WHERE type = 'found') as found_items,
                (SELECT COUNT(*) FROM items WHERE status = 'returned') as returned_items,
                (SELECT COUNT(*) FROM users) as total_users,
                (SELECT COUNT(*) FROM users WHERE role = 'admin') as admin_users";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

// Get recent items
$recent_items_sql = "SELECT i.*, u.full_name 
                     FROM items i 
                     JOIN users u ON i.user_id = u.user_id 
                     ORDER BY i.posted_at DESC 
                     LIMIT 10";
$recent_items = mysqli_query($conn, $recent_items_sql);

// Get recent users
$recent_users_sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT 5";
$recent_users = mysqli_query($conn, $recent_users_sql);

include '../includes/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>🛡️ Admin Dashboard</h1>
        <p>Manage the Campus Lost & Found Portal</p>
    </div>
    
    <!-- Admin Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-number"><?php echo $stats['total_items']; ?></div>
            <div class="stat-label">Total Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔍</div>
            <div class="stat-number"><?php echo $stats['lost_items']; ?></div>
            <div class="stat-label">Lost Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-number"><?php echo $stats['found_items']; ?></div>
            <div class="stat-label">Found Items</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎉</div>
            <div class="stat-number"><?php echo $stats['returned_items']; ?></div>
            <div class="stat-label">Returned</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-number"><?php echo $stats['total_users']; ?></div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🛡️</div>
            <div class="stat-number"><?php echo $stats['admin_users']; ?></div>
            <div class="stat-label">Admins</div>
        </div>
    </div>
    
    <div class="dashboard-actions">
        <a href="manage_items.php" class="btn btn-primary">Manage Items</a>
        <a href="manage_users.php" class="btn btn-secondary">Manage Users</a>
    </div>
    
    <!-- Recent Items -->
    <h2 class="section-title">Recent Items</h2>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Posted By</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($recent_items)): ?>
                    <tr>
                        <td><?php echo $item['item_id']; ?></td>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $item['type']; ?>">
                                <?php echo ucfirst($item['type']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo $item['status']; ?>">
                                <?php echo ucfirst($item['status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($item['full_name']); ?></td>
                        <td><?php echo timeAgo($item['posted_at']); ?></td>
                        <td class="action-buttons">
                            <a href="../items/view_item.php?id=<?php echo $item['item_id']; ?>" 
                               class="btn btn-sm btn-info">View</a>
                            <a href="../items/delete_item.php?id=<?php echo $item['item_id']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this item?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Recent Users -->
    <h2 class="section-title">Recent Users</h2>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Student ID</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($recent_users)): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['student_id']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $user['role']; ?>">
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                        <td><?php echo timeAgo($user['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>




<!-- testing -->