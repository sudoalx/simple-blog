<?php require_once '../includes/header.php'; ?>
<?php require_once '../config/db.php'; ?>
<!-- Main Content-->
<div class="container px-4 px-lg-5">
    <form method="POST" action="">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="text" name="email" id="form2Example1" class="form-control" placeholder="title" />

        </div>

        <div class="form-outline mb-4">
            <input type="text" name="email" id="form2Example1" class="form-control" placeholder="subtitle" />
        </div>

        <div class="form-outline mb-4">
            <textarea type="text" name="email" id="form2Example1" class="form-control" placeholder="body"
                rows="8"></textarea>
        </div>


        <div class="form-outline mb-4">
            <input type="file" name="email" id="form2Example1" class="form-control" placeholder="image" />
        </div>


        <!-- Submit button -->
        <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


    </form>
</div>
<?php require_once '../includes/footer.php'; ?>