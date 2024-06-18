<?php include "links.php"; ?>

<br>

<div class="iframe">
    <div class="btn-section">
        <button class="btn btn-primary" onclick="show('addpost')">
            <!-- Pass 'addpost' as an argument -->
            Not Processed Queries
        </button>
        <button class="btn btn-primary" onclick="show('editpost')">
            <!-- Pass 'editpost' as an argument -->
            Processed Queries
        </button>
    </div>

    <br>

    <div class="add content" id="addpost">
        <div class="heading">
            <h2>NOT PROCESSED QUERIES</h2>
        </div>
        <div class="alert alert-danger" role="alert" id="msg" style="position: fixed; top: 20px; right: 20px;display:none;"></div>
        <div class="table">
            <table class="table table-hover">
                <caption>Total Queries <span><?php echo $num_np_queries; ?></span></caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message</th>
                        <th scope="col">Created</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($queries_np_data as $row) { ?>
                        <tr>
                            <th scope='row'><?php echo $row['id']; ?></th>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                            <td><?php echo $row['dt']; ?></td>
                            <td id='pro-status'><?php echo $row['status']; ?></td>
                            <td>
                                <button class='btn btn-sm <?php echo ($row['status'] == 'Not_Processed' ? 'btn-warning' : 'btn-danger'); ?>' id='approve-btn-<?php echo $row['id']; ?>' onclick='process_query(<?php echo $row["id"]; ?>)'><?php echo ($row['status'] == 'Not_Processed' ? 'Process' : 'Un-Process'); ?></button>
                                <a href='#' class='view-query-btn' data-id='<?php echo $row['id']; ?>' data-name='<?php echo htmlspecialchars($row['name']); ?>' data-email='<?php echo htmlspecialchars($row['email']); ?>' data-message='<?php echo htmlspecialchars($row['message']); ?>' data-status='<?php echo $row['status']; ?>'><button class='btn btn-success btn-sm'>View</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="edit content post" id="editpost">
        <div class="heading">
            <h2>PROCESSED QUERIES</h2>
        </div>
        <div class="alert alert-danger" role="alert" id="msg" style="position: fixed; top: 20px; right: 20px;display:none;"></div>

        <div class="table">
            <table class="table table-hover">
                <caption>Total Queries <span><?php echo $num_p_queries; ?></span></caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message</th>
                        <th scope="col">Created</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($queries_p_data as $row) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                            <td><?php echo $row['dt']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href='#' class='view-query-btn' data-id='<?php echo $row['id']; ?>' data-name='<?php echo htmlspecialchars($row['name']); ?>' data-email='<?php echo htmlspecialchars($row['email']); ?>' data-message='<?php echo htmlspecialchars($row['message']); ?>' data-status='<?php echo $row['status']; ?>'><button class='btn btn-success btn-sm'>View</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="edit content post" id="editcategory">
        <div class="heading">
            <h2>Query</h2>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">ID</span>
            <input type="int" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" id="id" readonly>
        </div>
        <div class="form">
            <div class="form-floating">
                <input type="text" class="form-control" id="u-cat-name" placeholder="title" readonly>
                <label for="floatingInput">Name</label>
            </div>
            <br>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="u-cat-desc" style="height: 100px" readonly></textarea>
                <label for="floatingTextarea2">Message</label>
            </div>
            <br>
            <div class="form-floating">
                <input type="text" class="form-control" id="u-cat-author" placeholder="Author" readonly>
                <label for="floatingInput">Email</label>
            </div>
        </div>
    </div>
</div>


<script>
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
   
        const viewButtons = document.querySelectorAll('.view-query-btn');
        viewButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const message = this.getAttribute('data-message');
                const status = this.getAttribute('data-status');

                // Populate the editcategory section with query details
                document.querySelector("#editcategory #id").value = id;
                document.querySelector("#editcategory #u-cat-name").value = name;
                document.querySelector("#editcategory #u-cat-desc").value = message;
                document.querySelector("#editcategory #u-cat-author").value = email;

                // Make inputs read-only
                document.querySelector("#editcategory #u-cat-name").readOnly = true;
                document.querySelector("#editcategory #u-cat-desc").readOnly = true;
                document.querySelector("#editcategory #u-cat-author").readOnly = true;

                // Show the editcategory section
                show("editcategory");
            });
        });
    });

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
    function process_query(id) {
    var status= document.getElementById('pro-status').textContent;
    var formData = new FormData();
    formData.append('apr-id', id);
    formData.append('status', status);

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
                    window.location.href= window.location.pathname + '?msg=' + encodeURIComponent(data.msg);

          
                }
            } else {
                console.error("Error in AJAX request:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open('POST', 'ajax/query-process.php', true);
    xhr.send(formData);
}
    </script>
