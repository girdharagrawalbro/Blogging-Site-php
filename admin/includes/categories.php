<?php include "links.php"; ?>

<br>

<div class="iframe">
    <div class="btn-section">
        <button class="btn btn-primary" onclick="show('addcat')">
            <!-- Pass 'addpost' as an argument -->
            Add Category
        </button>

        <button class="btn btn-primary" onclick="show('allcat')">
            Manage Category </button>
    </div>

    <br>
    <div class="add content" id="addcat">
        <div class="heading">
            <h2>ADD CATEGORY</h2>
        </div>
        <div class="alert alert-danger" role="alert" id="msg"
            style="position: fixed; top: 20px; right: 20px;display:none;">

        </div>
        <div class="form">
            <div class="form-floating">
                <input type="text" class="form-control" id="cat-name" placeholder="title">
                <label for="floatingInput">Category Name</label>
            </div>
            <br>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="cat-desc"
                    style="height: 100px"></textarea>
                <label for="floatingTextarea2">Description</label>
            </div>
            <br>

            <div class="form-floating">
                <select class="form-select" id="cat-author" aria-label="Floating label select example">
                    <option selected>Select Author</option>

                    <option value="Girdhar Agrawal">Girdhar Agrawal</option>

                </select>
                <label for="floatingSelect">Author</label>
            </div>
            <br>

            <br>

            <button type="submit" class="btn btn-success" onclick="add_category()">Add Category</button>
        </div>
    </div>

    <div class="all content post" id="allcat">
        <div class="heading">
            <h2>MANAGE CATEGORIES</ h2>
        </div>
        <div class="alert alert-success" role="alert" id="d-msg"
            style="position: fixed; top: 20px; right: 20px;display:none;">

        </div>
        <div class="table">
            <table class="table table-hover" id="dataTable">

                <caption>Total Categories <span id="category-count"></span></caption>
                <thead class="table-dark">
                    <tr>
                        <!-- <th scope="col"> <input class="form-check-input" type="checkbox" value="" id=""></th> -->
                        <th scope="col"> #</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>

                        <th scope="col">Author</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="edit content post" id="editcategory">

        <div class="heading">
            <h2>EDIT CATEGORY</h2>
        </div>
        <div class="alert alert-danger" role="alert" id="u-msg"
            style="position: fixed; top: 20px; right: 20px;display:none;">

        </div><div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">ID</span>
  <input type="int" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" id="id" readonly>
</div>
        <div class="form">
            <div class="form-floating">
                <input type="text" class="form-control" id="u-cat-name" placeholder="title">
                <label for="floatingInput">Category Name</label>
            </div>
            <br>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="u-cat-desc"
                    style="height: 100px"></textarea>
                <label for="floatingTextarea2">Description</label>
            </div>
            <br>

            <div class="form-floating">
                <select class="form-select" id="u-cat-author" aria-label="Floating label select example">
                    <option selected>Select Author</option>

                    <option value="Girdhar Agrawal">Girdhar Agrawal</option>

                </select>
                <label for="floatingSelect">Author</label>
            </div>
            <br>

            <br>

            <button type="submit" class="btn btn-success" onclick="update_category()">Update Category</button>
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

function add_category() {
    var name = document.getElementById('cat-name').value;
    var desc = document.getElementById('cat-desc').value;
    var author = document.getElementById('cat-author').value;
    var msg = document.getElementById('msg');
    if (!name) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a name.';

    } else if (!desc) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a desc';
    } else if (!author) {
        msg.style.display = "block";
        msg.innerHTML = 'Select any author';
    } else {
        msg.style.display = "none";

        var formData = new FormData();
        formData.append('name', name);
        formData.append('desc', desc);
        formData.append('author', author);


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

        xhr.open('POST', 'ajax/category-add.php', true);
        xhr.send(formData);
    }
}


function update_category() {
    var name = document.getElementById('u-cat-name').value;
    var desc = document.getElementById('u-cat-desc').value;
    var author = document.getElementById('u-cat-author').value;
    var id = document.getElementById('id').value;

    var msg = document.getElementById('u-msg');

    if (!name) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a name.';

    } else if (!desc) {
        msg.style.display = "block";
        msg.innerHTML = 'Please give a desc';
    } else if (!author) {
        msg.style.display = "block";
        msg.innerHTML = 'Select any author';
    } else {    
        msg.style.display = "none";

        var formData = new FormData();
        formData.append('name', name);
        formData.append('desc', desc);
        formData.append('author', author);
        formData.append('id', id);



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

        xhr.open('POST', 'ajax/category-update.php', true);
        xhr.send(formData);
    }
}

function delete_category(id) {
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

    xhr.open('POST', 'ajax/category-delete.php', true);
    xhr.send(formData);
}
function displayMessage(msgBox,msg) {
    msgBox.style.display = "block";
    msgBox.innerHTML = msg;
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');
    if (message) {
        // Display the message
        const msgBox = document.getElementById('msg');
        msgBox.style.display = "block";
        msg.className = 'alert alert-success';
        msgBox.innerHTML = decodeURIComponent(message);
    }
    // Attach event listener for "Edit" buttons
    function attachEditListener(catId) {
        const editButton = document.getElementById(`edit-btn-${catId}`);

        if (editButton) {
            editButton.addEventListener("click", function() {
                const name = this.getAttribute("data-name");
                const desc = this.getAttribute("data-desc");
                const author = this.getAttribute("data-author");

                // Populate the edit form with data
                document.querySelector("#editcategory #id").value = catId;
                document.querySelector("#editcategory #u-cat-name").value = name;
                document.querySelector("#editcategory #u-cat-desc").value = desc;
                document.querySelector("#editcategory #u-cat-author").value = author;

                // Show the edit form
                show("editcategory");
            });
        }
    }
    fetch('ajax/category-fetch.php')
        .then(response => response.json())
        .then(data => {
            const categories = data.category; // Corrected variable name
            const categoryCount = data.count; // Corrected variable name

            // Display category count
            document.getElementById('category-count').textContent = categoryCount;

            // Display categories in the table
            const tableBody = document.querySelector('#dataTable tbody');
            categories.forEach(category => { // Corrected variable name
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${category.ID}</td>
                <td>${category.name}</td>
                <td>${category.desc}</td>
                <td>${category.author}</td>
                <td>${category.dt}</td>
                <td>
                    <button class='btn btn-info edit-btn' id='edit-btn-${category.ID}' data-name='${category.name}' data-desc='${category.desc}'data-author='${category.author}'>Edit</button>
                    <button class='btn btn-danger' id='delete-btn-${category.ID}' onclick='delete_category(${category.ID})'>Delete</button>
                </td>
            `;
                tableBody.appendChild(row);

                // Attach event listener for this edit button
                attachEditListener(category.ID);
            });
        })  
        .catch(error => {
            console.error('Error fetching categories:', error);
        });

});
</script>