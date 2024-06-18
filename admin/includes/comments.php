<?php include "links.php"; ?>

<br>

<div class="iframe">
    <div class="btn-section">
    
       
        <button class="btn btn-primary">   Manage Comments </button>
    </div>




    <div class="all content" id="allpost">
        <div class="heading">
            <h2>COMMENTS</h2>
        </div>
        <div class="alert alert-danger" role="alert" id="msg"
            style="position: fixed; top: 20px; right: 20px;display:none;">

        </div>

        <div class="table">
            <table class="table table-hover">

                <caption>Total Comments <span><?php echo $num_comment; ?></span></caption>
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>

                        <th scope="col">Name</th>
                        <th scope="col">E-Mail</th>

                        <th scope="col">Comment</th>
                        <th scope="col">Response</th>
                        <th scope="col">Created</th>

                        <th scope="col">Status</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                <?php 
                 
                 foreach ($comment_data as $row) {
                    echo "<tr>
                              <td>".$row['comment_ID']."</td>
                              <td>".$row['comment_author']."</td>
                              <td>".$row['comment_author_email']."</td>

                              <td>" . $row['comment_content'] . "</td>
                              <td></td>
                              <td>".$row['comment_date']."</td>
                              <td id='apr-status'>" . $row['comment_approved'] . "</td>
                              <td>
                                  <button class='btn btn-sm " . ($row['comment_approved'] == 'Un-Approved' ? 'btn-warning' : 'btn-danger') . " approve-btn' id='approve-btn-" . $row['comment_ID'] . "' onclick='approve_comment(" . $row['comment_ID'] . ")'>" . ($row['comment_approved'] == 'Un-Approved' ? 'Approve' : 'Unapprove') . "</button>
                              
                    <a href='http://localhost/blogging_site/post.php?id=".$row['comment_post_ID']."#comment-".$row['comment_ID']."' 
                    target='_blank' 
                    rel='noopener noreferrer'>

                    <button class='btn btn-success btn-sm'>View</button>
                 </a>
                 
                    </td></tr>"; }?>
                 
                </tbody>
            </table>
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
});

function approve_comment(id) {
    var status= document.getElementById('apr-status').textContent;
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
                    window.location.href = window.location.pathname + '?msg=' + encodeURIComponent(data.msg);

          
                }
            } else {
                console.error("Error in AJAX request:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open('POST', 'ajax/comment-approve.php', true);
    xhr.send(formData);
}
</script>
