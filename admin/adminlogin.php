<?php
// include function file
require_once('../functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

//Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //Check if username is empty
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter username.";
    }
    else
    {
        $username = trim($_POST["username"]);
    }

    //check if password is empty
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your password.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    //validate credentials
    if(empty($username_err) && empty($password_err))
    {
        //prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = :username AND password = :password";

        $stmt = $db_connect->Select($sql, ['username' => $username, 'password' => $password]);
        if ($stmt)
        {
            session_start();
            // Store data in session
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $stmt['id'];

            // Redirect user to home page
            header("location: posts.php");
        }
        else
        {
            // Display an error message if username doesn't exist
            $password_err = "Invalid username / password combination.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <!-- Site Metas -->
        <title>Jofedo</title>  
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Site Icons -->
        <link rel="shortcut icon" href="../images/logo_3.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="../images/logo_2.png">

        <title>Jofedo.com</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">    
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        
        <link href="../css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/animate.css" />
        <link href="../fonts/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/owl.carousel.min.css" />
        <link rel="stylesheet" href="../css/owl.theme.default.min.css" />
        <link rel="stylesheet" href="style.css" />
    

        <script src="../js/jquery-1.8.3.min.js"></script>

        <script src="../owl-carousel/owl-carousel.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
            <!-- LOADER -->
            <div id="preloader">
                <div id="main-ld">
                    <div id="loader"></div>  
                </div>
            </div><!-- end loader -->
            <!-- END LOADER -->


            <div class="center-block" style="margin: 100px auto; width: 70%;">
                <div class="container">
                    <div class="row">
                            <div class="col-sm-12 col-md-6 col-md-6" style="padding: 10px;">
                                <h4><span style="color: #7386D5;">JOFEDO</span> | Admin Login</h4>
                            </div>
                            <div class="col-sm-12 col-md-6 col-md-6" style="background-color: white; padding: 10px;">
                                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required/>
                                        <span class="help-block" style="color:red;"><?php echo $username_err; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" required/>
                                        <span class="help-block" style="color:red;"><?php echo $password_err; ?></span>
                                    </div>
                                    <button type="submit" style="background-color: #7386D5; border-color: #7386D5" class="btn btn-warning btn-block">Submit</button>
                                    <a href="" class="pull-left" style="color: red;">Forgot Password?</a>
                                </form>
                            </div>
                    </div>
                </div>    
            </div>

        <div class="copyrights">
            <div class="container">
                <div class="row">
                <div style="text-align: center; width: 100%;">
                    <p>All Rights Reserved. &copy; 2020 <b><a href="#">JOFEDO   </a></b> Developed by : <a href=""><b>Idowu Joseph</b></a></p>
                </div>
                </div>
            </div><!-- end container -->
        </div><!-- end copyrights -->
    
        <script src="../js/custom.js"></script>
    </body>
</html>