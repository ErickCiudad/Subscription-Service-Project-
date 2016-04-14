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
                    <li ><a href="addRecipe.php" style="color:white;">Submit Achievement <span class="sr-only">(current)</span></a></li>
                    <li class="active"><a style="color: #36407F;" href="signup.php"> Sign Up</a></li>
                    <li><a style="color: white;" href="login.php">Login</a></li>

                </ul>


            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<?php
if (isset($_POST['submit'])) {


$email = $_POST['email'];
$password = sha1($_POST['password']);

    $query = "SELECT * FROM doughnutUsers WHERE email = '$email'";
    $stmt = $dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $count =$stmt->rowCount();

    if (empty($email) || empty($password))
{
    echo '<p class="error">Please fill out all of the form</p>';
}
else if ($count != 0){
echo "<p class='error'> This email is not unique, please put in another one</p>";
}

else {
    $query = "INSERT INTO account_list (email, password)  VALUES ('$email', '$password')";
    $stmt = $dbh->prepare($query);
    $result = $stmt->execute(
        array(
            'email' => $email,
            'password' => $password
        )

    );

    echo '<div class="content"><p>Thanks for subscribing</p>';
    echo '<p><strong>Email:</strong> ' . $email . '<br />';
    echo '<strong>Password:</strong> ' . '*****' . '</p>';
    echo '<p><a href="index.php">&lt;&lt; Back to main page</a></p></div>';
    // Clear the score data to clear the form
    $username = "";
    $password = "";
    }
}
?>

<div class="content">
    <h3>Sign Up</h3>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php if (!empty($password)) echo '<strong> PASSWORD </strong>'; ?>" /><br />
        <input type="submit" value="Subscribe" name="submit" />
    </form>


</div>
</body>
</html>