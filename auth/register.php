<?php
global $conn;
// Include header and database connection files
require_once '../includes/header.php';
require_once '../config/db.php';

// Initialize a variable to hold messages
$messages = '';

// Handle form submission
if (isset($_POST['submit'])) {
    // Collect and sanitize user input
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if any required fields are empty
    if (empty($email) || empty($username) || empty($password)) {
        $messages = 'All fields are required!';
        header("location: register.php?error=$messages");
    } else {
        try {
            // Check if the email already exists in the database
            $emailCheck = $conn->prepare("SELECT 1 FROM users WHERE email = :email");
            $emailCheck->execute([':email' => $email]);

            // Check if the username already exists in the database
            $usernameCheck = $conn->prepare("SELECT 1 FROM users WHERE username = :username");
            $usernameCheck->execute([':username' => $username]);

            // Handle validation feedback for duplicate email or username
            if ($emailCheck->fetch()) {
                $messages = 'Email is already in use. Please choose another.';
                header("Location: register.php?error=$messages");
            } elseif ($usernameCheck->fetch()) {
                $messages = '<div class="alert alert-danger">Username is already in use. Please choose another.</div>';
                header("Location: register.php?error=$messages");
            } else {
                // Encrypt password and insert new user data
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insert = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
                $insert->execute([
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => $hashedPassword
                ]);

                // Confirm registration success
                if ($insert) {
                    $messages = 'User registered successfully!';
                    header("Location: login.php?success=$messages");
                    exit();
                } else {
                    $messages = 'Failed to register user!';
                    header("Location: register.php?error=$messages");
                }
            }
        } catch (PDOException $e) {
            // Handle database errors
            $messages = '<div class="alert alert-danger">Registration failed: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}
?>

<!-- Main Content -->
<div class="container px-4 px-lg-5">
    <!-- Messages container -->
    <div id="messages">
        <!-- Get query message from params -->
        <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
            }
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">' . $_GET['success'] . '</div>';
            }
            // Clear params
            echo '<script>
                    window.history.pushState(null, "", window.location.href.substring(window.location.href.lastIndexOf("/")+1).split("?")[0]);
                  </script>';
        ?>

    </div>

    <form method="POST" action="register.php">
        <!-- Username Input -->
        <div class="form-outline mb-4">
            <label for="username">Username</label>
            <input type="text" maxlength="20" name="username" minlength="3" id="username" class="form-control"
                   placeholder="Username" required />
        </div>

        <!-- Email Input -->
        <div class="form-outline mb-4">
            <label for="email-address">Email address</label>
            <input type="email" name="email" maxlength="100" id="email-address" class="form-control"
                   placeholder="Email" required />
        </div>

        <!-- Password Input -->
        <div class="form-outline mb-4">
            <label for="password">Password</label>
            <input type="password" maxlength="50" minlength="8" name="password" id="password" placeholder="Password"
                   class="form-control" required />
        </div>

        <!-- Submit Button -->
        <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Register</button>

        <!-- Login Link -->
        <div class="text-center">
            <p>Already a member? <a href="login.php">Login</a></p>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
