<?php
global $conn;
require_once '../includes/header.php';
include_once '../config/db.php';

// Initialize a variable to hold messages
$messages = '';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if required fields are filled
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        // Collect and sanitize user input
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try {
            // Prepare SQL query to check if the user exists based on email
            $loginQuery = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $loginQuery->execute([':email' => $email]);

            // Check if any user is found with this email
            $user = $loginQuery->fetch(PDO::FETCH_ASSOC);
            $rowCount = $loginQuery->rowCount();

            // Provide feedback based on the user search result
            if ($rowCount != 1) {
                $messages = "Account not found for $email";
                header('location: login.php?error=' . $messages);
            } else {
                // Verify the password using password_verify() with hashed password
                if (password_verify($password, $user['password'])) {
                    $messages = "Logged in successfully!";

                    // Redirect to index.php after successful login
                    header("Location: /index.php?auth=1");
                    exit();
                } else {
                    $messages = "Incorrect password!";
                    header('location: login.php?error=' . $messages);
                }
            }
        } catch (PDOException $e) {
            // Handle any database connection errors
            $messages = "<div class='alert alert-danger'>Login failed: " . htmlspecialchars($e->getMessage()) . "</div>";
            header('location: login.php?error=' . $messages);
        }
    } else {
        $messages = "<div class='alert alert-danger'>All fields are required!</div>";
        header('location: login.php?error=' . $messages);
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
        // Clear params: I did some query params trickery. Might not be the best approach but it works lol
        echo '<script>
                    window.history.pushState(null, "", window.location.href.substring(window.location.href.lastIndexOf("/")+1).split("?")[0]);
                  </script>';
        ?>
    </div>
    <!-- Form -->
    <form method="POST" action="login.php">
        <!-- Email Input -->
        <div class="form-outline mb-4">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
        </div>

        <!-- Password Input -->
        <div class="form-outline mb-4">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required />
        </div>

        <!-- Submit Button -->
        <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Login</button>

        <!-- Register Link -->
        <div class="text-center">
            <p>Create an account <a href="register.php">Sign up!</a></p>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
