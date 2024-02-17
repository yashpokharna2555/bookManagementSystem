<?php
    // Include database functions
    require_once "./functions/database_functions.php";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST['inputName'];
        $email = $_POST['inputEmail'];
        $message = $_POST['textArea'];

        // Validate data (you may want to add more validation)
        if (empty($name) || empty($email) || empty($message)) {
            echo "Please fill in all the fields.";
            exit;
        }

        // Connect to the database
        $conn = db_connect();

        // Sanitize data to prevent SQL injection
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $message = mysqli_real_escape_string($conn, $message);

        // Insert data into the database
        $query = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $contact_id = mysqli_insert_id($conn); // Get the auto-generated contact_id
            echo "Data inserted successfully. Contact ID: $contact_id";
        } else {
            echo "Error inserting data: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }

    // Display the form
    $title = "Contact";
    require_once "./template/header.php";
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 text-center">
        <form class="form-horizontal" method="post" action="">
            <fieldset>
                <legend>Contact</legend>
                <p class="lead">I’d love to hear from you! Complete the form to send me an email.</p>
                <div class="form-group">
                    <label for="inputName" class="col-lg-2 control-label">Name</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">Textarea</label>
                    <div class="col-lg-10">
                        <textarea class="form-control" rows="3" id="textArea" name="textArea"></textarea>
                        <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="reset" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>

<?php
    require_once "./template/footer.php";
?>
