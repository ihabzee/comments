<?php
include ("vendor/autoload.php");
?>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

</head>
<body>
<?php

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-header">Comments</h2>
            <div class="col-md-12">
                <?php
                $block = new \App\blocks();
                echo $block->get_comment_form();
                ?>
            </div>
            <section class="comment-list">

            </section>
        </div>
    </div>
</div>

</body>
</html>