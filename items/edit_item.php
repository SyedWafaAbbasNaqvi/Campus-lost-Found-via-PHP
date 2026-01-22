<?php
require_once '../config.php';
requireLogin();

$page_title = 'Edit Item';
$error = '';
$success = '';

// Get item ID
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($item_id == 0) {
    header("Location: ../index.php");
    exit();
}

// Fetch item details
$sql = "SELECT * FROM items WHERE item_id = $item_id AND user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../index.php");
    exit();
}

$item = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = cleanInput($_POST['title']);
    $description = cleanInput($_POST['description']);
    $category = cleanInput($_POST['category']);
    $type = cleanInput($_POST['type']);
    $location = cleanInput($_POST['location']);
    $date_lost_found = cleanInput($_POST['date_lost_found']);
    $contact_name = cleanInput($_POST['contact_name']);
    $contact_phone = cleanInput($_POST['contact_phone']);
    $contact_email = cleanInput($_POST['contact_email']);
    
    // Validation
    if (empty($title) || empty($description) || empty($category) || empty($type) || empty($location) || empty($date_lost_found)) {
        $error = 'Please fill all required fields!';
    } else {
        // Handle image upload
        $image_update = '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            if (in_array($file_ext, $allowed_types) && $file_size < 5000000) {
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = '../uploads/' . $new_file_name;
                
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Delete old image if not default
                    if ($item['image_path'] != 'default.jpg') {
                        @unlink('../uploads/' . $item['image_path']);
                    }
                    $image_update = ", image_path = '$new_file_name'";
                }
            }
        }
        
        // Update item
        $update_sql = "UPDATE items SET 
                       title = '$title',
                       description = '$description',
                       category = '$category',
                       type = '$type',
                       location = '$location',
                       date_lost_found = '$date_lost_found',
                       contact_name = '$contact_name',
                       contact_phone = '$contact_phone',
                       contact_email = '$contact_email'
                       $image_update
                       WHERE item_id = $item_id";
        
        if (mysqli_query($conn, $update_sql)) {
            $success = 'Item updated successfully!';
            header("refresh:2;url=view_item.php?id=$item_id");
        } else {
            $error = 'Failed to update item: ' . mysqli_error($conn);
        }
    }
}

include '../includes/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Edit Item</h1>
        <p>Update your item information</p>
    </div>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label for="title">Item Title *</label>
                    <input type="text" id="title" name="title" required 
                           value="<?php echo htmlspecialchars($item['title']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="type">Type *</label>
                    <select id="type" name="type" required>
                        <option value="lost" <?php echo $item['type'] == 'lost' ? 'selected' : ''; ?>>Lost</option>
                        <option value="found" <?php echo $item['type'] == 'found' ? 'selected' : ''; ?>>Found</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" required>
                        <option value="Electronics" <?php echo $item['category'] == 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                        <option value="Documents" <?php echo $item['category'] == 'Documents' ? 'selected' : ''; ?>>Documents</option>
                        <option value="Personal Items" <?php echo $item['category'] == 'Personal Items' ? 'selected' : ''; ?>>Personal Items</option>
                        <option value="Accessories" <?php echo $item['category'] == 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
                        <option value="Other" <?php echo $item['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date_lost_found">Date Lost/Found *</label>
                    <input type="date" id="date_lost_found" name="date_lost_found" required 
                           value="<?php echo $item['date_lost_found']; ?>" max="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($item['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="location">Location *</label>
                <input type="text" id="location" name="location" required 
                       value="<?php echo htmlspecialchars($item['location']); ?>">
            </div>
            
            <div class="form-group">
                <label>Current Image</label>
                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $item['image_path']; ?>" 
                     alt="Current image" style="max-width: 200px; display: block; margin: 10px 0;"
                     onerror="this.src='<?php echo BASE_URL; ?>uploads/default.jpg'">
                
                <label for="image">Upload New Image (optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Leave empty to keep current image. Max size: 5MB</small>
            </div>
            
            <h3>Contact Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contact_name">Contact Name</label>
                    <input type="text" id="contact_name" name="contact_name" 
                           value="<?php echo htmlspecialchars($item['contact_name']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="contact_phone">Contact Phone</label>
                    <input type="tel" id="contact_phone" name="contact_phone" 
                           value="<?php echo htmlspecialchars($item['contact_phone']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="contact_email">Contact Email</label>
                <input type="email" id="contact_email" name="contact_email" 
                       value="<?php echo htmlspecialchars($item['contact_email']); ?>">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Item</button>
                <a href="view_item.php?id=<?php echo $item_id; ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
