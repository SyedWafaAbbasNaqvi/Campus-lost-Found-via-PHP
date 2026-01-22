<?php
require_once 'config.php';

$page_title = 'Home';

// Get filter parameters
$type_filter = isset($_GET['type']) ? cleanInput($_GET['type']) : 'all';
$category_filter = isset($_GET['category']) ? cleanInput($_GET['category']) : 'all';
$search = isset($_GET['search']) ? cleanInput($_GET['search']) : '';

// Build SQL query
$sql = "SELECT i.*, u.full_name, u.phone as user_phone 
        FROM items i 
        JOIN users u ON i.user_id = u.user_id 
        WHERE 1=1";

if ($type_filter !== 'all') {
    $sql .= " AND i.type = '$type_filter'";
}

if ($category_filter !== 'all') {
    $sql .= " AND i.category = '$category_filter'";
}

if (!empty($search)) {
    $sql .= " AND (i.title LIKE '%$search%' OR i.description LIKE '%$search%' OR i.location LIKE '%$search%')";
}

$sql .= " ORDER BY i.posted_at DESC";

$result = mysqli_query($conn, $sql);

// Get statistics
$stats_sql = "SELECT 
                COUNT(*) as total_items,
                SUM(CASE WHEN type = 'lost' THEN 1 ELSE 0 END) as lost_items,
                SUM(CASE WHEN type = 'found' THEN 1 ELSE 0 END) as found_items,
                SUM(CASE WHEN status = 'returned' THEN 1 ELSE 0 END) as returned_items
              FROM items";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

include 'includes/header.php';
?>

<div class="hero">
    <div class="container">
        <h1>Campus Lost & Found Portal</h1>
        <p>Lost something? Found something? We help reunite students with their belongings!</p>
        
        <?php if (isLoggedIn()): ?>
            <a href="items/post_item.php" class="btn btn-primary btn-large">Post an Item</a>
        <?php else: ?>
            <a href="register.php" class="btn btn-primary btn-large">Get Started</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <!-- Statistics -->
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
    </div>
    
    <!-- Search and Filter -->
    <div class="search-filter-section">
        <form method="GET" action="" class="search-form">
            <input type="text" name="search" placeholder="Search items..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        
        <div class="filter-buttons">
            <a href="?type=all&category=<?php echo $category_filter; ?>" 
               class="btn btn-filter <?php echo $type_filter == 'all' ? 'active' : ''; ?>">All</a>
            <a href="?type=lost&category=<?php echo $category_filter; ?>" 
               class="btn btn-filter <?php echo $type_filter == 'lost' ? 'active' : ''; ?>">Lost</a>
            <a href="?type=found&category=<?php echo $category_filter; ?>" 
               class="btn btn-filter <?php echo $type_filter == 'found' ? 'active' : ''; ?>">Found</a>
        </div>
        
        <div class="category-filter">
            <label>Category:</label>
            <select name="category" onchange="window.location.href='?type=<?php echo $type_filter; ?>&category=' + this.value">
                <option value="all" <?php echo $category_filter == 'all' ? 'selected' : ''; ?>>All Categories</option>
                <option value="Electronics" <?php echo $category_filter == 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                <option value="Documents" <?php echo $category_filter == 'Documents' ? 'selected' : ''; ?>>Documents</option>
                <option value="Personal Items" <?php echo $category_filter == 'Personal Items' ? 'selected' : ''; ?>>Personal Items</option>
                <option value="Accessories" <?php echo $category_filter == 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
                <option value="Other" <?php echo $category_filter == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
    </div>
    
    <!-- Items Grid -->
    <h2 class="section-title">Recent Items</h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="items-grid">
            <?php while ($item = mysqli_fetch_assoc($result)): ?>
                <div class="item-card">
                    <div class="item-badge <?php echo $item['type']; ?>">
                        <?php echo ucfirst($item['type']); ?>
                    </div>
                    
                    <?php if ($item['status'] == 'returned'): ?>
                        <div class="item-badge returned">Returned</div>
                    <?php endif; ?>
                    
                    <div class="item-image">
                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $item['image_path']; ?>" 
                             alt="<?php echo htmlspecialchars($item['title']); ?>"
                             onerror="this.src='<?php echo BASE_URL; ?>uploads/default.jpg'">
                    </div>
                    
                    <div class="item-content">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p class="item-category">📂 <?php echo htmlspecialchars($item['category']); ?></p>
                        <p class="item-description"><?php echo substr(htmlspecialchars($item['description']), 0, 100); ?>...</p>
                        <p class="item-location">📍 <?php echo htmlspecialchars($item['location']); ?></p>
                        <p class="item-date">📅 <?php echo formatDate($item['date_lost_found']); ?></p>
                        <p class="item-posted">Posted <?php echo timeAgo($item['posted_at']); ?></p>
                        
                        <a href="items/view_item.php?id=<?php echo $item['item_id']; ?>" 
                           class="btn btn-secondary btn-block">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-items">
            <p>😔 No items found matching your criteria.</p>
            <?php if (isLoggedIn()): ?>
                <a href="items/post_item.php" class="btn btn-primary">Post the First Item</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
