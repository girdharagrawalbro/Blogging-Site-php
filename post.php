<!DOCTYPE html>
<html lang="en">
<?php include "admin/database/queries.php"; 
$id = $_GET['id'];
$result_s_post = mysqli_query($conn, "SELECT * FROM posts WHERE ID = '$id' and post_status = 'Published'");
$result_comments = mysqli_query($conn, "SELECT * FROM comments WHERE comment_post_ID = '$id'  and comment_approved='Approved' ORDER BY comment_date DESC");

$post = mysqli_fetch_array($result_s_post);
$result_response = mysqli_query($conn, "SELECT * FROM comment_response");
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>Learn Coding - <?php echo $post['post_title']; ?></title>
    <style>
    .comment {
        margin-bottom: 20px;
    }

    .response {
        margin-left: 20px;
        padding-left: 20px;
        border-left: 1px solid #ccc;
    }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <div class="bg-image">
        <h1 class="text-center text-white" id="head-text">
            <?php echo $post['post_title']; ?>
        </h1>
    </div>
    <div class="contain d-flex">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="post-content">
                            <h2><?php echo $post['post_title']; ?></h2>
                            <p class="post-body"><?php echo $post['post_content']; ?></p>
                            <h5>By <span><?php echo $post['post_author']; ?></span> On
                                <span><?php echo $post['post_date']; ?></span>
                            </h5>
                            <hr>
                            <?php while($comment = mysqli_fetch_array($result_comments)) { ?>
                            <div class="comment">
                                <!-- Comment content -->
                                <div id="comment-<?php echo $comment['comment_ID']; ?>"></div>
                                <div class="d-flex">
                                    <h5 class="card-subtitle mb-2 text-muted"><?php echo $comment['comment_author']; ?>
                                    </h5>
                                    <h7 class="card-subtitle ms-3 mt-1 text-muted">
                                        <?php echo $comment['comment_date']; ?></h7>
                                </div>
                                <p class="card-text"><?php echo $comment['comment_content']; ?></p>
                                <button class="btn-sm btn btn-primary"
                                    onclick="show_reply('<?php echo $comment['comment_ID']; ?>')" type="button"
                                    id="reply-btn-<?php echo $comment['comment_ID']; ?>">Reply</button>


                                <div class="response mt-3" id="reply-sec-<?php echo $comment['comment_ID']; ?>"
                                    style="display: none;">
                                    <form action="#" method="post">
                                        <input type="hidden" value="<?php echo $comment['comment_ID']; ?>"
                                            name="comment-id">
                                        <input type="text" class="form-control" name="response-author"
                                            placeholder="Enter Your Name">
                                        <textarea name="response" rows="2" class="form-control"
                                            placeholder="Write your reply here..."></textarea>
                                        <button class="btn-sm btn btn-success mt-1" type="submit"
                                            name="reply-submit">Submit Reply</button>
                                    </form>
                                </div>
                                <!-- Display responses -->
                                <?php
        // Fetch and display responses for this comment
        $comment_id = $comment['comment_ID'];
        $response_query = mysqli_query($conn, "SELECT * FROM comment_response WHERE comment_id = '$comment_id'");
        while ($response = mysqli_fetch_array($response_query)) {
            ?>
                                <div class="response mt-3">
                                    <div class="d-flex">
                                        <h5 class="card-subtitle mb-2 text-muted"><?php echo $response['author']; ?>
                                        </h5>
                                        <h7 class="card-subtitle ms-3 mt-1 text-muted">
                                            <?php echo $response['response_date']; ?></h7>
                                    </div>
                                    <p><?php echo $response['response']; ?></p>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="m-auto">
                            <h4>Add a Comment</h4>
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label for="cmterName">Your Name</label>
                                    <input type="text" class="form-control" name="cmt-name">
                                </div>
                                <div class="form-group">
                                    <label for="cmteremail">Your Email</label>
                                    <input type="email" class="form-control" name="cmt-email">
                                </div>
                                <div class="form-group">
                                    <label for="cmtContent">Your Comment</label>
                                    <textarea class="form-control" name="comment" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="cmt-submit">Submit</button>
                            </form>
                            <div class="alert alert-danger mt-3" role="alert" id="u-msg" style="display: none;">
                                <?php 
                        if(isset($_POST['cmt-submit'])){
                            $email = $_POST['cmt-email'];
                            $comment = $_POST['comment'];
                            $author= $_POST['cmt-name'];
                            mysqli_query($conn, "INSERT INTO `comments`(`comment_content`, `comment_author`, `comment_author_email`,comment_post_ID) VALUES ('$comment','$author','$email','$id')");    
                            echo "<script>window.location.href = window.location.href;</script>";
                        }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
        <div>
            <?php include "includes/sidebar.php"; ?>

        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>

<script>
function show_reply(commentID) {
    var replySection = document.getElementById('reply-sec-' + commentID);
    var replyButton = document.querySelector('button[name="' + commentID + '"]');

    if (replySection.style.display === 'none') {
        replySection.style.display = 'block';
        replyButton.style.display = 'none';
    } else {
        replySection.style.display = 'none';
        replyButton.style.display = 'block';
    }
}
</script>

<?php 
if(isset($_POST['reply-submit'])){
    $response = $_POST['response'];
    $commentid = $_POST['comment-id'];
    $author= $_POST['response-author'];
    mysqli_query($conn, "INSERT INTO `comment_response`(`response`, `author`, `comment_id`) VALUES ('$response','$author',$commentid)");    
    echo "<script>window.location.href = window.location.href;</script>";
}
?>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>