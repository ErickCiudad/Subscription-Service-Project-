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
                    <li><a href="addRecipe.php" style="color:white;">Submit Achievement <span class="sr-only">(current)</span></a></li>
                    <li><a style="color: white;" href="signup.php"> Sign Up</a></li>
                    <li  class="active"><a style="color: #36407F;" href="login.php">Login</a></li>

                </ul>


            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>


<?php
//Clear error message
$error_msg = "";

//Try to log user in
if (!isset($_COOKIE['user_id'])) {

    if (@($_POST['submit'])) {
        echo 'got here';

        // Grab the user-entered log-in data
        $user_username = trim($_POST['email']);
        $user_password = trim($_POST['password']);


        if (!empty($user_username) && !empty($user_password)) {
            echo 'got here now elephant';

// Look up the username and password in the database
            $query = "SELECT id, email FROM account_list WHERE email = '$user_username' AND " .
                "password = SHA('$user_password')";
            echo 'got here now penguin';
            $stmt = $dbh->prepare($query);
            $stmt->execute(
                array(
                    'email' => $user_username,
                    'password' => $user_password
                )
            );

            $data = $stmt->fetch();
            $count = $stmt->rowCount();

            echo 'got here now monkey';


//            if ($count == 1) {
// The log-in is OK so set the user ID and username cookies, and redirect to the home page

                $row = $data;
                $name =$row['email'];
                $id = $row['id'];


                setcookie('id', $id);
                setcookie('email', $name);
                $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                header('Location: ' . $home_url);
            echo 'got here now parrot';


//            }
//            else {
//                // The username/password are incorrect so set an error message
//                $error_msg = 'Sorry, you must enter a valid username and password to log in.';
//            }
        } else {
            // The username/password weren't entered so set an error message
            $error_msg = 'Sorry, you must enter your username and password to log in. This one';
        }
    }
}
?>


<?php
// If the cookie is empty, show any error message and the log-in form; otherwise confirm the log-in
if (empty($_COOKIE['id'])) {
echo '<p class="error">' . $error_msg . '</p>';

?>


<div class="content">
    <h3>Login</h3>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <label for="email">Username:</label>
        <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>"/><br/>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"
               value="<?php if (!empty($password)) echo '<strong> PASSWORD </strong>'; ?>"/><br/>
        <input type="submit" value="Login" name="submit" />
    </form>
    <?php
    }

    ?>

    <?php
    if (isset($_COOKIE['email'])) {
        echo '<a href="logout.php" <p style="color: white; font-size: 200%;">Logout</p></a>'
    ?>

    <?php
    }
    ?>


</div>


</body>
</html>