<?php 
include('header.php'); 

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if ($email && strlen($password) >= 6) {
        // In full deployment, your password hash and database entry execution lives here:
        // $hashed = password_hash($password, PASSWORD_BCRYPT);
        $message = "<p style='color: #34c759; margin-bottom: 1rem;'>Account created successfully! Welcome to the Outlaws.</p>";
    } else {
        $message = "<p style='color: #ff3b30; margin-bottom: 1rem;'>Please provide a valid email and minimum 6 character password.</p>";
    }
}
?>

<main class="container">
    <div class="auth-box">
        <h2 style="font-size: 1.8rem; margin-bottom: 0.5rem; text-align: center;">Join the Order</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; margin-bottom: 2rem;">Unlock priority drop access and community events.</p>
        
        <?php echo $message; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@domain.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary">Create Account</button>
        </form>
    </div>
</main>

<?php include('footer.php'); ?>