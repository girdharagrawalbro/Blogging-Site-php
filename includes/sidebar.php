    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <div class="sidebar">
    <form class="d-flex" action="./index.php" method="post">
            <input class="form-control me-2" type="search" placeholder="Search" list="datalistOptions" name="query" aria-label="Search">
            <datalist id="datalistOptions">
            <?php include "admin/database/queries.php";
            foreach($category_data as $row)
            { ?>

                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; }?></option>
                
            </datalist>
            <button class="btn btn-outline-success" type="submit" name="submit"><i class="fas fa-search"></i></button>
        </form>

                <div class="list">
                    <br>
                    <h3>Categories</h3>
                    <br>
                    <ul> <?php 
            foreach($category_data as $row)
            { ?>
                <li><a class="nav-link" href="index.php?category=<?php echo $row['name']; ?>"><?php echo $row['name']; }?></a></li>

                    </ul>
                </div>
                <div class="list">
                    <br>
                    <h3>Recent Post</h3>
                    <br>

                    <ul>
                    <?php 
                    
                    $res = mysqli_query($conn, "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY ID DESC LIMIT 4");


                    $post = mysqli_fetch_all($res, MYSQLI_ASSOC);


            foreach($post as $row)
            { ?>
                <li><a class="nav-link" href="post.php?id=<?php echo $row['ID']; ?>"><?php echo $row['post_title']; }?></a></li>

                    </ul>
                </div>
            </div>