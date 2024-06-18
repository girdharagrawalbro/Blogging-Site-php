    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <title>Contact Learn Coding</title>

    </head>

    <body>
        <?php include "includes/header.php"; ?>
        <div class="bg-image">
            <h1 class="text-center text-white" id="head-text">
                Contact Us

            </h1>
        </div>


        <div class="contain p-5">
            <div class="container">
                <h4>Send your query to us..</h4>
                <form id="contactForm" action="#" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>
                <?php
include "admin/database/queries.php"; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $message = mysqli_real_escape_string($conn, $message);
    
    $sql = "INSERT INTO queries (`name`, `email`, `message`) VALUES ('$name', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
echo '<script>alert("Query Sended Successfuly")</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



?>

                        </div>

        </div>

        <?php include "includes/footer.php"; ?>

    </body>

    </html>
  
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>