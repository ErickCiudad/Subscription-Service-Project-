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
                <a class="navbar-brand" href="#" style="color:#36407F; background-color: white">Brag Chef</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="addRecipe.php" style="color:white;">Submit Achievement <span class="sr-only">(current)</span></a></li>
                    <li><a style="color: white;" href="signup.php">Sign Up</a></li>
                    <li><a style="color: white;" href="login.php">Login</a></li>
                </ul>


            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>

<div class="content">

    <?php

    $query = "SELECT * FROM doughnutUsers ORDER BY date ASC";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();

    echo '<br>';

    // Loop through the array of score data, formatting it as HTML
    echo '<table border="1px" style="margin-left: auto; margin-right: auto">';
    $i = 0;
    // Display the score data

    foreach ($result as $row) {

        $filepath = GW_UPLOADPATH . $row['image'];

        if ($i == 0) {
            echo '<tr><td colspan=“2” class=“topscoreheader” id="thisDiv">Top Chef:' . $row['name']. ' with a ' .$row['recipe'].'</td></tr><br>';
        }

        echo '<tr><td class="scoreinfo">';
        echo '<span class="recipe">' . $row['recipe'] . '</span><br />';
        echo '<strong>Name:</strong> ' . $row['name'] . '<br />';
        echo '<strong>Date:</strong> ' . $row['date'] . '</td>';

        if(is_file($filepath) && filesize($filepath) > 0){
            echo '<td> <img class="food" src="'.$filepath .'" alt="Score image" /> </td></tr>';
        } else {
            echo '<td><img src="images/utensils.png" alt="Unverified score" /></td></tr>';
        }
        $i++;
    }
    echo '</table>';

    ?>
</div>




</body>
</html>