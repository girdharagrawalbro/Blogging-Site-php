<?php include "links.php"; ?>

<br>

<div class="iframe">
    <div class="btn-section">
        <button class="btn btn-primary" onclick="show('addpost')">
            <!-- Pass 'addpost' as an argument -->
            Add Post
        </button>

        <button class="btn btn-primary" onclick="show('allpost')">
            Manage Post </button>

    </div>


    <?php
// Assuming your form submits to this PHP script

$errors = []; // Array to store validation errors
$msg ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Check if the form is submitted
    if (isset($_POST["upload-post"])) {

    // Validate form fields
    if (empty($_POST['title'])) {
        $errors[] = "Title is required";
    }
    if (empty($_POST['body'])) {
        $errors[] = "Body is required";
    }
    if (empty($_POST['category'])) {
        $errors[] = "Seletc Category";
    }
    if (empty($_POST['author'])) {
        $errors[] = "Select Author";
    }

    // If there are no validation errors, proceed with database operation
    if (empty($errors)) {
        
        // Set parameters and execute
        $title = $_POST['title']; // Assuming the input name is 'title'
        $body = $_POST['body']; // Assuming the textarea name is 'body'
        $category = $_POST['category']; // Assuming the select name is 'category'
        $author = $_POST['author']; // Assuming the select name is 'author'
        $publish = isset($_POST['publish']) ? "Published" : "Not-published"; // Assuming the checkbox name is 'publish'
        $slug = createSlug($title); // Function assumed to be defined elsewhere

            $link = "http://localhost/blogging_site/post.php?slug=".$slug;
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO post (title, body, category, author, `status` ,slug, link) VALUES (?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("sssssss", $title, $body, $category, $author, $publish,$slug,$link);


        
        if ($stmt->execute()=== true) {
            $msg = "New post uploaded successfully";
        }else {
            // Execution failed, add an error message to $errors array
            $errors[] = "Error: " . $stmt->error;
        }
    

        $stmt->close();
        $conn->close();
        
    }   
    if (isset($_POST["update-post"])) {
        // Validate form fields
        if (empty($_POST['title'])) {
            $errors[] = "Title is required";
        }
        if (empty($_POST['body'])) {
            $errors[] = "Body is required";
        }
        if (empty($_POST['category'])) {
            $errors[] = "Select Category";
        }
        if (empty($_POST['author'])) {
            $errors[] = "Select Author";
        }
    
        // If there are no validation errors, proceed with database operation
        if (empty($errors)) {
            // Set parameters
            $title = $_POST['title'];
            $body = $_POST['body'];
            $category = $_POST['category'];
            $author = $_POST['author'];
            $publish = isset($_POST['publish']) ? "Published" : "Not-published";
            $slug = createSlug($title); // Function assumed to be defined elsewhere
            $link = "http://localhost/blogging_site/post.php?slug=" . $slug;
            $post_id = $_POST['post_id']; // Assuming you have a hidden input field named 'post_id' in your form
    
            // Prepare and bind the SQL statement for updating the post
            $stmt = $conn->prepare("UPDATE post SET title = ?, body = ?, category = ?, author = ?, status = ?, slug = ?, link = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $title, $body, $category, $author, $publish, $slug, $link, $post_id);
    
            // Execute the update statement
            if ($stmt->execute()) {
                $msg = "Post updated successfully";
            } else {
                // Execution failed, add an error message to $errors array
                $errors[] = "Error: " . $stmt->error;
            }
    
            // Close the statement
            $stmt->close();
        }
    }
}
}
function createSlug($title) {
    // Convert title to lowercase
    $slug = strtolower($title);
    
    // Replace spaces with hyphens
    $slug = str_replace(' ', '-', $slug);
    
    // Remove special characters
    $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
    
    // Remove consecutive hyphens
    $slug = preg_replace('/-+/', '-', $slug);
    
    return $slug;
}
?>

    <!-- HTML Form -->
    <div class="add content" id="addpost">
        <div class="heading">
            <h2>ADD POST</h2>
        </div>
        <div class="form">
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert"
                style="position: fixed; top: 20px; right: 20px;padding-bottom:0;">
                <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-success" role="alert"
                style="position: fixed; top: 20px; right: 20px;padding-bottom:0;      ">
                <p><?php echo $msg; ?></p>
            </div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-floating">
                    <input type="text" class="form-control" name="title" id="floatingInput" placeholder="title">
                    <label for="floatingInput">Title</label>
                </div>
                <br>
                <div class="form-floating">
                    <textarea class="form-control" name="body" placeholder="Leave a comment here" id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Body</label>
                </div>
                <br>
                <select class="form-select" name="category" aria-label="Default select example">

                    <option selected>Select Category</option>
                    <?php 
                foreach($category_data as $row)
                { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name'];} ?></option>

                </select>
                <br>
                <select class="form-select" name="author" aria-label="Default select example">
                    <option selected>Select Author</option>
                    <option value="Girdhar Agrawal">Girdhar Agrawal</option>
                </select>
                <br>
                <input class="form-check-input" type="checkbox" value="1" name="publish" id="flexCheckChecked" checked>
                <label class="form-check-label" for="flexCheckChecked"> Publish
                </label>
                <br>
                <br>
                <button type="submit" class="btn btn-success" name="upload-post">Add Post</button>
            </form>
        </div>
    </div>


    <div class="all content post" id="allpost">
        <div class="heading">
            <h2>MANAGE POST</h2>
        </div>
        <div class="table">
            <table class="table table-hover">

                <caption>Total Post <span><?php echo $num_post; ?></span></caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col"> <input class="form-check-input" type="checkbox" value="" id=""></th>

                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Created</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                 
                 foreach ($post_data as $row) {
                    echo "<tr>
                              <th scope='row'><input class='form-check-input' type='checkbox'></th>
                              <td>" . $row['title'] . "</td>
                              <td>" . $row['author']."</td>
                              <td>".$row['created']."</td>
                              <td>" . $row['status'] . " </td>
                               <td>
                               <button class='btn btn-info edit-btn' data-post-id='".$row['id']."' data-title='".$row['title']."' data-body='".$row['body']."' data-category='".$row['category']."' data-author='".$row['author']."' data-publish='".$row['status'] ."'>Edit</button>

                                  <button class='btn btn-danger'>Delete</button>
                                  <button class='btn btn-warning'>Unpublish</button>
                                  <button class='btn btn-success'>View</button>
                              </td>
                          </tr>";
                }
?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="edit content post" id="editpost">

        <div class="heading">
            <h2>EDIT POST</h2>
        </div>
        <div class="form">
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert"
                style="position: fixed; top: 20px; right: 20px;padding-bottom:0;">
                <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-success" role="alert"
                style="position: fixed; top: 20px; right: 20px;padding-bottom:0;      ">
                <p><?php echo $msg; ?></p>
            </div>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-floating">
                    <input type="text" class="form-control" name="title" id="title" placeholder="title">
                    <label for="floatingInput">Title</label>
                </div>
                <br>
                <div class="form-floating">
                    <textarea class="form-control" name="body" placeholder="Leave a comment here" id="body"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Body</label>
                </div>
                <br>
                <select class="form-select" name="category">

                    <option id="category" selected></option>
                    <?php 
                foreach($category_data as $row)
                { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name'];} ?></option>

                </select>
                <br>
                <select class="form-select" name="author">
                    <option id="author" selected></option>
                    <option value="Girdhar Agrawal">Girdhar Agrawal</option>
                </select>
                <br>
                <input class="form-check-input" type="checkbox" value="1" name="publish" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheck" id="publish"> Publish
                </label>
                <br>
                <br>
                <button type="submit" class="btn btn-success" name="update-post">Update Post</button>
            </form>
        </div>

    </div>


</div>
<script>
function show(contentId) {
    var contents = document.querySelectorAll('.content');
    contents.forEach(function(content) {
        if (content.id === contentId) {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    });
}
</script>
<!-- 
<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
  <div class="btn-group me-2" role="group" aria-label="First group">
    <button type="button" class="btn btn-primary">1</button>
    <button type="button" class="btn btn-primary">2</button>
    <button type="button" class="btn btn-primary">3</button>
    <button type="button" class="btn btn-primary">4</button>
  </div>
  <div class="btn-group me-2" role="group" aria-label="Second group">
    <button type="button" class="btn btn-secondary">5</button>
    <button type="button" class="btn btn-secondary">6</button>
    <button type="button" class="btn btn-secondary">7</button>
  </div>
  <div class="btn-group" role="group" aria-label="Third group">
    <button type="button" class="btn btn-info">8</button>
  </div>
</div> -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all "Edit" buttons
    const editButtons = document.querySelectorAll(".edit-btn");

    // Loop through each "Edit" button and attach click event listener
    editButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            const postId = this.getAttribute("data-post-id");
            const title = this.getAttribute("data-title");
            const body = this.getAttribute("data-body");
            const category = this.getAttribute("data-category");
            const author = this.getAttribute("data-author");
            const publish = this.getAttribute("data-publish");
            // Show the edit form
            document.getElementById("title").value = title;
            document.getElementById("body").value = body;
            document.getElementById("category").value = category;
            document.getElementById("category").innerHTML = category;
            document.getElementById("author").value = author;
            document.getElementById("author").innerHTML = author;

            if (publish === "Published") {
                document.getElementById("publish").checked = true;
            } else {
                document.getElementById("publish").checked = false;
            }

            document.getElementById("editpost").style.display = "block";

            // Hide the code showing all posts
            document.getElementById("allpost").style.display = "none";
        });
    });
});
</script>