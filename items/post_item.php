<?php
require_once '../config.php';
requireLogin();

$page_title = 'Post Item';
$error = '';
$success = '';

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
    
    $user_id = $_SESSION['user_id'];
    
    // Validation
    if (empty($title) || empty($description) || empty($category) || empty($type) || empty($location) || empty($date_lost_found)) {
        $error = 'Please fill all required fields!';
    } else {
        // Handle image upload
        $image_path = 'default.jpg';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            if (in_array($file_ext, $allowed_types) && $file_size < 5000000) { // 5MB max
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = '../uploads/' . $new_file_name;
                
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $image_path = $new_file_name;
                }
            }
        }
        
        // Insert item
        $sql = "INSERT INTO items (user_id, title, description, category, type, location, date_lost_found, image_path, contact_name, contact_phone, contact_email) 
                VALUES ('$user_id', '$title', '$description', '$category', '$type', '$location', '$date_lost_found', '$image_path', '$contact_name', '$contact_phone', '$contact_email')";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'Item posted successfully!';
            header("refresh:2;url=../user/dashboard.php");
        } else {
            $error = 'Failed to post item: ' . mysqli_error($conn);
        }
    }
}

include '../includes/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Post an Item</h1>
        <p>Help reunite lost items with their owners</p>
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
                           placeholder="e.g., Black iPhone 13">
                </div>
                
                <div class="form-group">
                    <label for="type">Type *</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="lost">Lost</option>
                        <option value="found">Found</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Documents">Documents</option>
                        <option value="Personal Items">Personal Items</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date_lost_found">Date Lost/Found *</label>
                    <input type="date" id="date_lost_found" name="date_lost_found" required max="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="5" required 
                          placeholder="Provide detailed description to help identify the item"></textarea>
            </div>
            
            <div class="form-group">
                <label for="location">Location *</label>
                <input type="text" id="location" name="location" required 
                       placeholder="e.g., Main Library, 2nd Floor">
            </div>
            
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Max size: 5MB. Supported formats: JPG, PNG, GIF</small>
            </div>
            
            <h3>Contact Information</h3>
            <p class="form-note">This information will be shown to interested users</p>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contact_name">Contact Name</label>
                    <input type="text" id="contact_name" name="contact_name" 
                           value="<?php echo $_SESSION['full_name']; ?>">
                </div>
                
                <div class="form-group">
                    <label for="contact_phone">Contact Phone</label>
                    <input type="tel" id="contact_phone" name="contact_phone" 
                           placeholder="0300-1234567">
                </div>
            </div>
            
            <div class="form-group">
                <label for="contact_email">Contact Email</label>
                <input type="email" id="contact_email" name="contact_email" 
                       value="<?php echo $_SESSION['email']; ?>">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Post Item</button>
                <a href="../index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
