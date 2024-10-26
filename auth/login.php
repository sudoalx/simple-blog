<?php require_once '../includes/header.php'; ?>

<?php
    include_once '../config/db.php'; 
    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        if(!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $POST['email'];
            $password = $POST['password'];

            $login = $conn -> query("SELECT * FROM users WHERE email = '$email'")

            $login->execute()

            $row = $login -> FETCH(PDO::F)
        }
    }

    // Get the data from the form

    // Write the SQL query to check if the user exists in the database

    // Execute the query

    // Fetch the data from the database

    // Verify the password (hashed password) with the password_verify() function -> redirect to the index.php page
?>

<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <form method="POST" action="login.php">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="username" name="username" id="form2Example1" class="form-control" placeholder="Email" />

        </div>


        <!-- Password input -->
        <div class="form-outline mb-4">
            <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />

        </div>



        <!-- Submit button -->
        <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Create an acount<a href="register.php"> Register</a></p>



        </div>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>