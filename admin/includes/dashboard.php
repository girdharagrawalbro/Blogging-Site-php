<?php include "links.php"; ?>
<br>

<div class="iframe">
    <h2>DASHBOARD</h2>
    <br>
    <br>
    <br>
    <div class="container flex">
        <div class="container bg-light box">
            <h2>
                <span>
                    <?php echo $num_post; ?>
                </span>
            </h2>
            <h5>
                Total Posts
            </h5>
        </div>
        <div class="container bg-light box">
            <h2>
                <span>
                <?php echo $num_category; ?>

                </span>
            </h2>
            <h5>
                Total Categories
            </h5>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="container flex">
        <div class="container bg-light box">
            <h2>
                <span>
                <?php echo $num_comment; ?>

                </span>
            </h2>
            <h5>
                Total Comments
            </h5>
        </div>
        <div class="container bg-light box">
            <h2>
                <span>
                <?php echo $num_queries; ?>

                </span>
            </h2>
            <h5>
                Total Queries
            </h5>
        </div>
    </div>
</div>