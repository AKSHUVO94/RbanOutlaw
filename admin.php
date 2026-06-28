<?php
session_start();
include('db.php'); // Uses your active connection variable $conn

// =========================================================================
// 1. SECURE CREDENTIAL & RECOVERY CONFIGURATION
// =========================================================================
// ⚠️ IMPORTANT: In a production environment, these should eventually be stored in your database.
$admin_user = "admin";
$admin_pass = "password123"; 

// --- RESET & RECOVERY CONFIGURATION VALUES ---
$recovery_birthdate = "1994-01-09";       // Format: YYYY-MM-DD
$secret_question    = "What was the name of your first street apparel brand?";
$secret_answer      = "vagabond";           // System checks this using lowercase comparison

// Handle Logging Out
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Handle Logging In
if (isset($_POST['login'])) {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['admin_logged'] = true;
    } else {
        $error = "Invalid username or password.";
    }
}

// Handle Password Recovery Verification and Reset Execution
if (isset($_POST['execute_reset'])) {
    $input_dob  = $_POST['recovery_dob'];
    $input_ans  = strtolower(trim($_POST['recovery_answer']));
    $new_pass1  = $_POST['new_password'];
    $new_pass2  = $_POST['confirm_new_password'];

    if ($input_dob !== $recovery_birthdate || $input_ans !== strtolower($secret_answer)) {
        $reset_error = "Security validation failed. Birthdate or secret answer is incorrect.";
    } elseif ($new_pass1 !== $new_pass2) {
        $reset_error = "Password mismatch. The two passwords entered do not match.";
    } elseif (strlen($new_pass1) < 6) {
        $reset_error = "Security baseline rejected: Password must be at least 6 characters long.";
    } else {
        // Validation Passed! Update your $admin_pass value
        $admin_pass = $new_pass1; 
        $reset_success = "Password successfully changed! Use your new credentials to log in below.";
        
        // Dynamic file writer mechanism (Optional helper logic context)
        // If you want this change to be permanent inside this file automatically, uncomment below:
        /*
        $file_contents = file_get_contents(__FILE__);
        $file_contents = preg_replace('/\$admin_pass\s*=\s*".*?";/', '$admin_pass = "' . addslashes($new_pass1) . '";', $file_contents);
        file_put_contents(__FILE__, $file_contents);
        */
    }
}

// Block entry if the admin session isn't active
if (!isset($_SESSION['admin_logged'])) {
    // Determine whether to display the standard login card or toggle over to recovery interface view
    $view = isset($_GET['forgot']) ? 'recovery' : 'login';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Portal Authentication</title>
        <style>
            body { background: #0b0b0b; color: #fff; font-family: system-ui, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; }
            .login-card { background: #111; padding: 2.5rem; border-radius: 8px; border: 1px solid #222; width: 100%; max-width: 360px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
            h2 { margin-top: 0; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 0.5rem; text-align: center; text-transform: uppercase; }
            .subtitle { text-align: center; font-size: 0.8rem; color: #555; margin-bottom: 1.5rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
            label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #777; font-weight: 700; display: block; margin-bottom: 5px; }
            input { width: 100%; padding: 12px; margin-bottom: 1.2rem; background: #1a1a1a; border: 1px solid #333; color: #fff; border-radius: 4px; box-sizing: border-box; font-size: 0.9rem; }
            input:focus { border-color: #f4c430; outline: none; }
            button { width: 100%; padding: 12px; background: #f4c430; color: #000; font-weight: 700; text-transform: uppercase; border: none; border-radius: 4px; cursor: pointer; transition: background 0.2s; letter-spacing: 0.5px; }
            button:hover { background: #dfb226; }
            .err { background: rgba(255, 77, 77, 0.1); border: 1px solid rgba(255, 77, 77, 0.2); color: #ff4d4d; font-size: 0.85rem; text-align: center; margin-bottom: 1.2rem; padding: 10px; border-radius: 4px; font-weight: 600; }
            .success-msg { background: rgba(46, 196, 182, 0.1); border: 1px solid rgba(46, 196, 182, 0.2); color: #2ec4b6; font-size: 0.85rem; text-align: center; margin-bottom: 1.2rem; padding: 10px; border-radius: 4px; font-weight: 600; }
            .footer-links { display: flex; justify-content: space-between; margin-top: 1.5rem; font-size: 0.8rem; }
            .footer-links a { color: #888; text-decoration: none; font-weight: 600; transition: color 0.2s; }
            .footer-links a:hover { color: #f4c430; }
            .question-box { background: #161616; padding: 10px; border: 1px solid #262626; border-radius: 4px; color: #ccc; font-size: 0.85rem; font-style: italic; margin-bottom: 1.2rem; line-height: 1.4; }
        </style>
    </head>
    <body>
        
        <?php if ($view === 'login'): ?>
        <!-- ================= STANDARD AUTHENTICATION VIEW ================= -->
        <div class="login-card">
            <h2>BRAND ADMIN</h2>
            <div class="subtitle">Console Login Access</div>
            
            <?php if(isset($error)) echo "<div class='err'>$error</div>"; ?>
            <?php if(isset($reset_success)) echo "<div class='success-msg'>$reset_success</div>"; ?>
            
            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off" placeholder="Username">
                
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
                
                <button type="submit" name="login">Access Console</button>
            </form>
            
            <div class="footer-links">
                <a href="index.php">← Back to Store</a>
                <a href="?forgot=1">Forgot Password?</a>
            </div>
        </div>

        <?php elseif ($view === 'recovery'): ?>
        <!-- ================= PASSWORD RECOVERY SYSTEM VIEW ================= -->
        <div class="login-card" style="max-width: 400px;">
            <h2>Reset Credentials</h2>
            <div class="subtitle">Security Identification Check</div>
            
            <?php if(isset($reset_error)) echo "<div class='err'>$reset_error</div>"; ?>
            
            <form method="POST" action="admin.php">
                <label>Verification Birthdate</label>
                <input type="date" name="recovery_dob" required>
                
                <label>Security Question</label>
                <div class="question-box"><?php echo $secret_question; ?></div>
                
                <label>Your Secret Answer</label>
                <input type="text" name="recovery_answer" required placeholder="Type answer here" autocomplete="off">
                
                <hr style="border: 0; border-top: 1px solid #222; margin: 1.5rem 0;">
                
                <label>Set New Password</label>
                <input type="password" name="new_password" required placeholder="Minimum 6 characters">
                
                <label>Confirm New Password</label>
                <input type="password" name="confirm_new_password" required placeholder="Repeat new password">
                
                <button type="submit" name="execute_reset">Override &amp; Save Password</button>
            </form>
            
            <div class="footer-links" style="justify-content: center;">
                <a href="admin.php">← Return to Login Screen</a>
            </div>
        </div>
        <?php endif; ?>

    </body>
    </html>
    <?php
    exit;
}

// ==========================================
// 2. DYNAMIC CONTROLLER ACTIONS (Toggles)
// ==========================================
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($_GET['action'] === 'toggle_status') {
        $conn->query("UPDATE products SET status = IF(status='active', 'inactive', 'active') WHERE id = $id");
    } 
    elseif ($_GET['action'] === 'toggle_stock') {
        $conn->query("UPDATE products SET stock = IF(stock='instock', 'soldout', 'instock') WHERE id = $id");
    } 
    elseif ($_GET['action'] === 'delete') {
        $conn->query("DELETE FROM products WHERE id = $id");
    }
    
    header("Location: admin.php");
    exit;
}

// ==========================================
// 3. PRODUCT CREATION ENGINE WITH IMAGE UPLOAD
// ==========================================
if (isset($_POST['add_product'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['desc']);
    $price = floatval($_POST['price']);
    $usd = floatval($_POST['usd']);
    $cat = $conn->real_escape_string($_POST['cat']);
    
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) { 
        mkdir($target_dir, 0755, true); 
    }
    
    $file_name = time() . '_' . basename($_FILES["img"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (in_array($imageFileType, $allowed_extensions)) {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO products (title, price, usd, cat, `desc`, img, status, stock) VALUES (?, ?, ?, ?, ?, ?, 'active', 'instock')");
            $stmt->bind_param("sddsss", $title, $price, $usd, $cat, $desc, $target_file);
            
            if ($stmt->execute()) {
                $success = "Drop successfully published to live catalog!";
            } else {
                $error = "Database Error: " . $conn->error;
            }
            $stmt->close();
        } else {
            $error = "Error uploading image file to server folder.";
        }
    } else {
        $error = "Invalid file type. Only JPG, JPEG, PNG, WEBP, and GIF are allowed.";
    }
}

$all_products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Studio Console</title>
    <style>
        body { background: #0a0a0a; color: #d4d4d4; font-family: system-ui, sans-serif; padding: 2rem; margin: 0; }
        .container { max-width: 1300px; margin: 0 auto; }
        header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #222; padding-bottom: 1.5rem; margin-bottom: 2rem; }
        h2 { margin: 0; font-weight: 900; letter-spacing: -1px; color: #fff; text-transform: uppercase; }
        
        /* Navigation Home Link Styles */
        .header-left { display: flex; flex-direction: column; }
        .navigation-row { display: flex; gap: 15px; margin-top: 8px; }
        .nav-link-btn { display: inline-flex; align-items: center; gap: 6px; color: #888; text-decoration: none; font-size: 0.8rem; font-weight: 700; transition: color 0.2s; text-transform: uppercase; }
        .nav-link-btn:hover { color: #f4c430; }

        .grid-split { display: grid; grid-template-columns: 400px 1fr; gap: 2.5rem; align-items: start; }
        .panel-card { background: #111; border: 1px solid #1c1c1c; padding: 1.8rem; border-radius: 8px; }
        .panel-card h3 { margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 800; color: #fff; border-bottom: 1px solid #222; padding-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
        
        label { display: block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; color: #888; }
        input, textarea, select { width: 100%; padding: 0.75rem; background: #161616; border: 1px solid #262626; color: #fff; border-radius: 4px; margin-bottom: 1.2rem; box-sizing: border-box; font-size: 0.9rem; }
        input:focus, textarea:focus, select:focus { border-color: #f4c430; outline: none; }
        
        .btn { background: #222; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-block; text-align: center; text-transform: uppercase; }
        .btn-logout { background: #da3636; color: #fff; }
        .btn-logout:hover { background: #bd2a2a; }
        .btn-submit { background: #f4c430; color: #000; width: 100%; font-size: 0.9rem; padding: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        .btn-submit:hover { background: #dfb226; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 1rem; border-bottom: 1px solid #1c1c1c; vertical-align: middle; }
        th { background: #161616; color: #666; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        
        .badge { padding: 4px 8px; font-size: 0.65rem; font-weight: 900; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .badge-active { background: rgba(46, 196, 182, 0.15); color: #2ec4b6; border: 1px solid rgba(46, 196, 182, 0.3); }
        .badge-inactive { background: rgba(231, 29, 54, 0.15); color: #e71d36; border: 1px solid rgba(231, 29, 54, 0.3); }
        .badge-instock { background: rgba(58, 125, 68, 0.15); color: #53d769; }
        .badge-soldout { background: rgba(255, 77, 77, 0.15); color: #ff4d4d; }
        
        .action-btn { font-size: 0.75rem; text-decoration: none; font-weight: 700; display: block; margin: 4px 0; padding: 4px 8px; border-radius: 3px; text-align: center; border: 1px solid #333; color: #ccc; background: #161616; }
        .action-btn:hover { background: #222; color: #fff; }
        .btn-delete { color: #ff4d4d; border-color: rgba(255,77,77,0.2); }
        .btn-delete:hover { background: #ff4d4d; color: #fff; }
        
        .msg { padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem; }
        .msg-success { background: rgba(46, 196, 182, 0.1); color: #2ec4b6; border: 1px solid rgba(46, 196, 182, 0.2); }
        .msg-error { background: rgba(231, 29, 54, 0.1); color: #e71d36; border: 1px solid rgba(231, 29, 54, 0.2); }
    </style>
</head>
<body>

<div class="container">
    <header>
        <div class="header-left">
            <h2>Manage System Inventory</h2>
            <div class="navigation-row">
                <span style="font-size: 0.85rem; color: #555;">Live Catalog Sync Engine</span>
                <span style="color:#222;">|</span>
                <!-- Home Page Link Integration -->
                <a href="index.php" class="nav-link-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-bottom:-1px;">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    View Storefront
                </a>
            </div>
        </div>
        <a href="?logout=1" class="btn btn-logout">Exit Session</a>
    </header>

    <?php if(isset($success)) echo "<div class='msg msg-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='msg msg-error'>$error</div>"; ?>

    <div class="grid-split">
        
        <div class="panel-card">
            <h3>Upload New Drop</h3>
            <form method="POST" enctype="multipart/form-data">
                <label>Product Title</label>
                <input type="text" name="title" required placeholder="e.g., Outlaw Heavyweight Men's Hoodie">

                <label>Description</label>
                <textarea name="desc" rows="4" required placeholder="e.g., 450GSM drop-shoulder luxury terry cotton..."></textarea>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Price (BDT ৳)</label>
                        <input type="number" name="price" required placeholder="3500">
                    </div>
                    <div>
                        <label>Price (USD $)</label>
                        <input type="number" step="0.01" name="usd" required placeholder="110.00">
                    </div>
                </div>

                <label>Category Placement Mapping</label>
                <select name="cat">
                    <option value="new">New Arrival</option>
                    <option value="top">Top</option>
                    <option value="bottom">Bottom</option>
                </select>

                <label>Product Image File</label>
                <input type="file" name="img" accept="image/*" required style="padding: 5px;">

                <button type="submit" name="add_product" class="btn btn-submit">Publish Live</button>
            </form>
        </div>

        <div class="panel-card">
            <h3>System Inventory Database Matrix</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Product Context Details</th>
                        <th style="width: 100px;">Placement</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 100px;">Stock</th>
                        <th style="width: 140px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($all_products && $all_products->num_rows > 0): ?>
                        <?php while($row = $all_products->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $row['img']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; background: #1a1a1a; display: block; border: 1px solid #222;">
                                </td>
                                <td>
                                    <strong style="color: #fff; font-size: 0.95rem; display: block; margin-bottom: 4pxStream;"><?php echo $row['title']; ?></strong>
                                    <span style="color: #f4c430; font-size: 0.85rem; font-weight: 700; margin-right: 8px;">৳<?php echo number_format($row['price']); ?></span>
                                    <span style="color: #666; font-size: 0.8rem;">$<?php echo number_format($row['usd'], 2); ?> USD</span>
                                    <p style="color: #777; font-size: 0.75rem; margin: 6px 0 0 0; line-height: 1.3; max-width: 400px;"><?php echo substr($row['desc'], 0, 75) . (strlen($row['desc']) > 75 ? '...' : ''); ?></p>
                                </td>
                                <td>
                                    <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #aaa;"><?php echo $row['cat']; ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $row['stock']; ?>"><?php echo $row['stock'] == 'instock' ? 'In Stock' : 'Sold Out'; ?></span>
                                </td>
                                <td>
                                    <a href="?action=toggle_status&id=<?php echo $row['id']; ?>" class="action-btn">🔄 Status Toggle</a>
                                    <a href="?action=toggle_stock&id=<?php echo $row['id']; ?>" class="action-btn">📦 Stock Toggle</a>
                                    <a href="?action=delete&id=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to completely erase this product from your database?')">❌ Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #555; padding: 3rem 0;">No catalog entries found in system database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>