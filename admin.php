<?php
include('db.php');

// Handle New Item Submission
if (isset($_POST['add_product'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $usd = $_POST['usd'];
    $cat = $_POST['cat'];
    $desc = $_POST['desc'];
    $status = $_POST['status'];
    $stock = $_POST['stock'];

    // Handle Image Upload File Check
    $target_dir = "images/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $img_name = time() . '_' . basename($_FILES["img"]["name"]);
    $target_file = $target_dir . $img_name;

    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        // Prepare Statement to safe-inject into database
        $stmt = $conn->prepare("INSERT INTO products (title, price, usd, cat, `desc`, img, status, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissssss", $title, $price, $usd, $cat, $desc, $target_file, $status, $stock);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle Direct Quick Updates (Sold out / Inactive toggles)
if (isset($_GET['action'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] == 'toggle_stock') {
        $conn->query("UPDATE products SET stock = IF(stock='instock', 'soldout', 'instock') WHERE id = $id");
    } elseif ($_GET['action'] == 'toggle_status') {
        $conn->query("UPDATE products SET status = IF(status='active', 'inactive', 'active') WHERE id = $id");
    }
    header("Location: admin.php");
    exit();
}

$all_products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streetwear Inventory Manager</title>
    <style>
        body { background: #0a0a0a; color: #fff; font-family: sans-serif; padding: 2rem; margin: 0; }
        
        /* ================= NAVIGATION BAR WITH HOME ICON ================= */
        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #111;
            padding: 1rem 2rem;
            border: 1px solid #222;
            border-radius: 6px;
            margin-bottom: 2rem;
        }
        .home-icon-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            background: #222;
            padding: 8px 16px;
            border-radius: 4px;
            border: 1px solid #333;
            transition: 0.3s;
        }
        .home-icon-btn:hover {
            background: #f4c430;
            color: #000;
            border-color: #f4c430;
        }

        input, textarea, select { width: 100%; padding: 10px; margin: 8px 0; background: #111; border: 1px solid #333; color: #fff; box-sizing: border-box; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
        th, td { padding: 12px; border: 1px solid #222; text-align: left; }
        th { background: #111; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        .btn { background: #f4c430; color: #000; font-weight: bold; border: none; padding: 12px 20px; cursor: pointer; text-decoration: none; display: inline-block; border-radius: 4px; }
        .btn:hover { opacity: 0.9; }
        .btn-sub { background: #222; color: #aaa; font-size: 0.8rem; padding: 6px 12px; border: 1px solid #444; text-decoration: none; margin-right: 5px; display: inline-block; border-radius: 2px; }
        .btn-sub:hover { background: #333; color: #fff; }
    </style>
</head>
<body>

    <!-- ================= TOP NAVIGATION BAR ================= -->
    <div class="admin-nav">
        <span style="font-weight: bold; letter-spacing: 1px; color: #aaa;">RBAN OUTLAW CONTROL PANEL</span>
        
        <!-- Premium SVG Home Icon Link returning back to index.php -->
        <a href="index.php" class="home-icon-btn" title="Return to Store Home">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Go to Home
        </a>
    </div>

    <h1>Upload & Manage Drops</h1>
    
    <form method="POST" enctype="multipart/form-data" style="max-width: 500px; background: #111; padding: 2rem; border-radius: 8px; border: 1px solid #222;">
        <label>Product Title</label><input type="text" name="title" required>
        <label>Price (BDT)</label><input type="number" name="price" required>
        <label>Price (USD)</label><input type="text" name="usd" required>
        <label>Category Tag</label>
        <select name="cat">
            <option value="new">New Arrival</option>
            <option value="top">Top</option>
            <option value="bottom">Bottom</option>
        </select>
        <label>Description</label><textarea name="desc" rows="3" required></textarea>
        <label>Product Image</label><input type="file" name="img" accept="image/*" required>
        <label>Initial Status</label>
        <select name="status">
            <option value="active">Active (Visible)</option>
            <option value="inactive">Inactive (Hidden)</option>
        </select>
        <label>Initial Stock Status</label>
        <select name="stock">
            <option value="instock">In Stock</option>
            <option value="soldout">Sold Out</option>
        </select>
        <button type="submit" name="add_product" class="btn" style="margin-top:10px;">Upload Drop Item</button>
    </form>

    <h2>Active Store Catalog List</h2>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Stock Control</th>
                <th>Visibility Control</th>
            </tr>
        </thead>
        <tbody>
            <?php if($all_products && $all_products->num_rows > 0): ?>
                <?php while($row = $all_products->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($row['img']); ?>" width="50" style="object-fit:cover; aspect-ratio:1; border-radius: 4px;"></td>
                    <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                    <td>৳<?php echo number_format($row['price']); ?> / $<?php echo htmlspecialchars($row['usd']); ?></td>
                    <td>
                        <span style="color:<?php echo $row['stock'] == 'instock' ? '#4da6ff':'#ff4d4d'; ?>; font-weight: bold; font-size: 0.85rem;"><?php echo strtoupper($row['stock']); ?></span><br><br>
                        <a href="admin.php?action=toggle_stock&id=<?php echo $row['id']; ?>" class="btn-sub">Toggle Status</a>
                    </td>
                    <td>
                        <span style="color:<?php echo $row['status'] == 'active' ? '#4dff4d':'#888'; ?>; font-weight: bold; font-size: 0.85rem;"><?php echo strtoupper($row['status']); ?></span><br><br>
                        <a href="admin.php?action=toggle_status&id=<?php echo $row['id']; ?>" class="btn-sub">Toggle Visibility</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #666; padding: 2rem;">No drop items available in the catalog database yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>