<?php include "links.php"; ?>

<br>

<div class="iframe">
    <div class="btn-section">
        <button class="btn btn-primary" onclick="show('addpost')">
            <!-- Pass 'addpost' as an argument -->
            Add Post
        </button>

        <button class="btn btn-primary" onclick="show('allpost')">
            Manage Post
        </button>
    </div>

    <!-- HTML Form -->
    <div class="add content" id="addpost">
        <div class="heading">
            <h2>ADD POST</h2>
        </div>
        <div class="form">
            <div class="alert alert-danger" role="alert" id="msg" style="position: fixed; top: 20px; right: 20px;display:none;"></div>
            <div class="form-floating">
                <input type="text" class="form-control" id="title" placeholder="title">
                <label for="floatingInput">Title</label>
            </div>
            <br>
            <div class="form-floating">
                <textarea class="form-control" id="body" placeholder="Leave a comment here" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Body</label>
            </div>
            <br>
            <select class="form-select" id="category" aria-label="Default select example">
                <option value="" selected>Select Category</option>
                <?php foreach($category_data as $row) { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
            <br>
            <select class="form-select" id="author" aria-label="Default select example">
                <option value="" selected>Select Author</option>
                <?php foreach($author_data as $row) { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
            <br>
            <input class="form-check-input" type="checkbox" value="1" id="publish" checked>
            <label class="form-check-label" for="flexCheckChecked"> Publish </label>
            <br>
            <br>
            <button type="submit" class="btn btn-success" onclick="add_post()">Add Post</button>
        </div>
    </div>

    <div class="all content post" id="allpost">
        <div class="heading">
            <h2>MANAGE POST</h2>
        </div>
        <div class="alert alert-success" role="alert" id="d-msg" style="position: fixed; top: 20px; right: 20px;display:none;"></div>
        <div class="table">
            <table class="table table-hover" id="dataTable">
                <caption>Total Post <span id="post-count"></span></caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Author</th>
                        <th scope="col">Created</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Your table rows will be added dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="edit content post" id="editpost">
        <div class="heading">
            <h2>EDIT POST</h2>
        </div>
        <div class="alert alert-danger" role="alert" id="u-msg" style="position: fixed; top: 20px; right: 20px;display:none;"></div>
        <div class="form">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">ID</span>
                <input type="text" class="form-control" placeholder="Post ID" aria-label="Post ID" aria-describedby="basic-addon1" id="id" readonly>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="u-title" placeholder="Title">
                <label for="floatingInput">Title</label>
            </div>
            <br>
            <div class="form-floating">
                <textarea class="form-control" id="u-body" placeholder="Leave a comment here" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Body</label>
            </div>
            <br>
            <select class="form-select" id="u-category" aria-label="Default select example">
                <option value="" selected>Select Category</option>
                <?php foreach($category_data as $row) { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
            <br>
            <select class="form-select" id="u-author" aria-label="Default select example">
                <option value="" selected>Select Author</option>
                <?php foreach($author_data as $row) { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
            <br>
            <input class="form-check-input" type="checkbox" value="1" id="u-publish" checked>
            <label class="form-check-label" for="flexCheckChecked"> Publish </label>
            <br>
            <br>
            <button type="submit" class="btn btn-success" onclick="update_post()">Update Post</button>
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

    function add_post() {
        var title = document.getElementById('title').value;
    var body = document.getElementById('body').value;
    var category = document.getElementById('category').value;
    var author = document.getElementById('author').value;
    var publish = document.getElementById('publish').checked;
    var msg = document.getElementById('msg');
    if (!title) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a title.';
    } else if (title.length < 3) {
        msg.style.display = "block";
        msg.innerHTML = 'Title must be more than 3 characters.';
    } else if (!body) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a body.';
    } else if (body.length < 50) {
        msg.style.display = "block";
        msg.innerHTML = 'Body is too short';
    } else if (!category) {
        msg.style.display = "block";
        msg.innerHTML = 'Select any category';
    } else if (!author) {
        msg.style.display = "block";
        msg.innerHTML = 'Select any author';
    } else {
        msg.style.display = "none";

    var formData = new FormData();
    formData.append('title', title);
    formData.append('body', body);
    formData.append('category', category);
    formData.append('author', author);
    formData.append('publish', publish);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.hasOwnProperty('error')) {
                    console.log(data.error);
                    msg.style.display = "block";
                    msg.innerHTML = data.error;
                } else {
                    console.log(data);
                    window.location.href = window.location.pathname + '?msg=' + encodeURIComponent(data.msg);

                }
            } else {
                console.error("Error in AJAX request:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open('POST', 'ajax/post-add.php', true);
    xhr.send(formData);
}
}
function update_post() {
    var title = document.getElementById('u-title').value;
    var body = document.getElementById('u-body').value;
    var category = document.getElementById('u-category').value;
    var author = document.getElementById('u-author').value;
    var postid = document.getElementById('id').value;
    var publish = document.getElementById('u-publish').checked;
    var msg = document.getElementById('u-msg');

    if (!title) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a title.';
    } else if (title.length < 5) {
        msg.style.display = "block";
        msg.innerHTML = 'Title must be more than 5 characters.';
    } else if (!body) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a body.';
    } else if (body.length < 50) {
        msg.style.display = "block";
        msg.innerHTML = 'Body is too short';
    } else if (!category) {
        msg.style.display = "block";
        msg.innerHTML = 'Select any category';
    } else if (!author) {
        msg.style.display = "block";
        msg.innerHTML = 'Select any author';
    } else {
        msg.style.display = "none";

    var formData = new FormData();
    formData.append('title', title);
    formData.append('body', body);
    formData.append('category', category);
    formData.append('author', author);
    formData.append('publish', publish);
    formData.append('post_id', postid);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                if (data.hasOwnProperty('error')) {
                    console.log(data.error);
                    msg.style.display = "block";
                    msg.innerHTML = data.error;
                } else {
                    console.log(data);
                    window.location.href = window.location.pathname + '?msg=' + encodeURIComponent(data.msg);

                }
            } else {
                console.error("Error in AJAX request:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open('POST', 'ajax/post-update.php', true);
    xhr.send(formData);
    }
}

    function delete_post(id) {
        var formData = new FormData();
    formData.append('del-id', id);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                
                if (data.hasOwnProperty('error')) {
                    console.log(data.error);
                    msgBox.style.display = "block";
                    msgBox.innerHTML = data.error;
                } else {
                    console.log(data);
                    window.location.href = window.location.pathname + '?msg=' + encodeURIComponent(data.msg);

                }
            } else {
                console.error("Error in AJAX request:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open('POST', 'ajax/post-delete.php', true);
    xhr.send(formData);
    }
    document.addEventListener("DOMContentLoaded", function() {
    // Attach event listener for "Edit" buttons
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');
    if (message) {
        // Display the message
        const msgBox = document.getElementById('msg');
        msgBox.style.display = "block";
        msg.className = 'alert alert-success';
        msgBox.innerHTML = decodeURIComponent(message);
    }
        function attachEditListener(postId) {
            const editButton = document.getElementById(`edit-btn-${postId}`);

            if (editButton) {
                editButton.addEventListener("click", function() {
                    const title = this.getAttribute("data-title");
                    const body = this.getAttribute("data-body");
                    const category = this.getAttribute("data-category");
                    const author = this.getAttribute("data-author");
                    const publish = this.getAttribute("data-publish");

                    // Populate the edit form with data
                    document.querySelector("#editpost #id").value = postId;
                    document.querySelector("#editpost #u-title").value = title;
                    document.querySelector("#editpost #u-body").value = body;
                    document.querySelector("#editpost #u-category").value = category;
                    document.querySelector("#editpost #u-author").value = author;
                    document.querySelector("#editpost #u-publish").checked = publish === "Published";

                    // Show the edit form
                    show("editpost");
                });
            }
        }

        // Fetch posts from server
        fetch('ajax/post-fetch.php')
            .then(response => response.json())
            .then(data => {
                const posts = data.posts;
                const postCount = data.count;

                // Display post count
                document.getElementById('post-count').textContent = postCount;

                // Display posts in the table
                const tableBody = document.querySelector('#dataTable tbody');
                posts.forEach(post => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${post.ID}</td>
                        <td>${post.post_title}</td>
                        <td>${post.post_category}</td>
                        <td>${post.post_author}</td>
                        <td>${post.post_date}</td>
                        <td>${post.post_status}</td>
                        <td>
                            <button class='btn btn-info edit-btn btn-sm' id='edit-btn-${post.ID}' 
                                    data-title='${post.post_title}' 
                                    data-body='${post.post_content}' 
                                    data-category='${post.post_category}' 
                                    data-author='${post.post_author}' 
                                    data-publish='${post.post_status}'>
                                Edit
                            </button>
                            <button class='btn btn-danger delete-btn btn-sm' onclick='delete_post(${post.ID})' data-id='${post.ID}'>Delete</button>
                            <a href='http://localhost/blogging_site/post.php?id=${post.ID}' 
                               target='_blank' 
                               rel='noopener noreferrer'>
                               <button class='btn btn-success btn-sm'>View</button>
                            </a> 
                        </td>
                    `;
                    tableBody.appendChild(row);

                    // Attach event listener for this edit button
                    attachEditListener(post.ID);
                });
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
            });
    });
</script>
<!-- 
<form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> -->