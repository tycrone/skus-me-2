<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="SKU Lookup">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Tyler Crone">
</head>

<body>

<?php
    $comment = ' ';
    if (isset($_POST) && !empty($_POST['skus'])) {
        $comment = $_POST['skus'];
    }
    ?>

    <form name = "SKU inputs" method = "POST" action='skuprocessing.php'>
    SKUs:<br/> <textarea name ="skus" rows = "10" cols = "50"><?php if(!empty($comment)) { echo $comment; } ?></textarea>
    <input type= "submit" value = "Submit" name = "btn1">
    </form>
    <?php if (!empty($comment)) { echo $comment; } ?>


</body>
<footer>
</footer>

</html>