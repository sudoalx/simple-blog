<?php require_once '../includes/header.php'; ?>
<?php require_once '../config/db.php'; ?>

<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if fields are empty
    if (empty($email) || empty($username) || empty($password)) {
        echo '<div class="alert alert-danger">All fields are required!</div>';
    } else {
        try {
            // Check if the email exists
            $emailCheck = $conn->prepare("SELECT 1 FROM users WHERE email = :email");
            $emailCheck->execute([':email' => $email]);

            // Check if the username exists
            $usernameCheck = $conn->prepare("SELECT 1 FROM users WHERE username = :username");
            $usernameCheck->execute([':username' => $username]);

            if ($emailCheck->fetch()) {
                echo '<div class="alert alert-danger">Email is already in use. Please choose another.</div>';
            } elseif ($usernameCheck->fetch()) {
                echo '<div class="alert alert-danger">Username is already in use. Please choose another.</div>';
            } else {
                // Insert new user if no duplicates are found
                $insert = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
                $insert->execute([
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => password_hash($password, PASSWORD_DEFAULT)
                ]);

                if ($insert) {
                    echo '<div class="alert alert-success">User registered successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger">Failed to register user!</div>';
                }
                header("Location: login.php");
            }
        } catch (PDOException $e) {
            echo "Registration failed: " . $e->getMessage();
        }
    }
}
?>

<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <form method="POST" action="register.php">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="email" name="email" maxlength="100" id="email-address" class="form-control"
                placeholder="Email" />

        </div>

        <div class="form-outline mb-4">
            <input type="text" maxlength="20" name="username" minlength="3" id="username" class="form-control"
                placeholder="Username" />
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <input type="password" maxlength="50" minlength="8" name="password" id="passwor" placeholder="Password"
                class="form-control" />

        </div>



        <!-- Submit button -->
        <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Register</button>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Already a member? <a href="login.php">Login</a></p>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>