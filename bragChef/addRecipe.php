<?php
require_once('connect.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brag Chef</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div id="navbar">
    <nav class="navbar navbar-default" style="background-color: #36407F; color: white;">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="color: white;">Brag Chef</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#" style="color:#36407F;">Submit Achievement <span class="sr-only">(current)</span></a></li>
                    <li><a style="color: white;" href="signup.php"> Sign Up</a></li>
                    <li><a style="color: white;" href="login.php">Login</a></li>
                </ul>


            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<?php
if (isset($_POST['submit'])) {
    // Grab the score data from the POST
    $name = $_POST['name'];
    $recipe = $_POST['recipe'];
    $image = $_FILES['image']['name'];
    $screenshot_type = $_FILES['image']['type'];
    $screenshot_size = $_FILES['image']['size'];
    //fix this
    if (!empty($name) && !empty($recipe) && !empty($image)) {
        if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png'))
            && ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE)) {
            if ($_FILES['image']['error'] == 0) {
                echo '1';
                // Move file to the target upload folder
                $target = GW_UPLOADPATH . $image;
                echo '2';
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    // Write the data to the database
                    echo '3';
                    $query = "INSERT INTO doughnutUsers (date, name, recipe, image) VALUES (NOW(), :name, :recipe, :image)";
                    $stmt = $dbh->prepare($query);
                    $result = $stmt->execute(
                        array(
                            'name' => $name,
                            'recipe' => $recipe,
                            'image' => $image
                        )
                    );
                    // Confirm success with the user
                    echo '<div class="content"><p>Thanks for adding your new submission!</p>';
                    echo '<p><strong>Name:</strong> ' . $name . '<br />';
                    echo '<strong>Recipe:</strong> ' . $recipe . '</p>';
                    echo '<img src="'. GW_UPLOADPATH . $image .'" alt="Score image"/></p>';
                    echo '<p><a href="index.php">&lt;&lt; Back to main page</a></p></div>';
                    // Clear the score data to clear the form
                    $name = "";
                    $recipe = "";
                    $image = "";
                }
                else {
                    echo '<p class="error">Sorry, there was a problem uploading your screen shot image.</p>';
                }
            }
        } else {
            echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) .' KB in size.</p>';
        }
        // Try to delete the temp screenshot file
        @unlink($_FILES['image']['tmp_name']);
    } else {
        echo '<p class="error">Please enter all of the information to add your recipe.</p>';
    }
}
?>

<div class="content">

    <?php
    if (isset($_COOKIE['email'])) {
    ?>

    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="addForm">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>"/>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>"/><br/>
        <label for="recipe">Recipe:</label>
        <input type="text" id="recipe" name="recipe" value="<?php if (!empty($recipe)) echo $recipe; ?>"/><br/>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image"/>

        <input type="submit" value="Add" name="submit"/>
    </form>


<?php
}
?>

<?php
if (empty($_COOKIE['email'])) {
    ?>

    <p style="font-size: 200%; color:#36407F;">Not logged in, please sign up or login to participate!</p>

    <?php
}
?>

<!--<div class="makeAccount">-->
<!--    <button style="font-size: 200%"><a href="signup.php">Subscribe</button>-->
<!---->
<!--    <button style="font-size: 200%"><a href="login.php" onclick="document.getElementById('addForm').style.display='block">Login</button>-->
<!---->
<!--</div>-->


</div>
</body>
</html>