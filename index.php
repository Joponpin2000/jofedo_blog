<?php
// include function file
require_once('functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");


$msg = "";
$name = $email = $phone = $message = "";
$name_err = $email_err = $phone_err = $message_err = "";

if ($_SERVER["REQUEST_METHOD"] =="POST")
{
    if (isset($_POST['submit']))
    {
        if (empty(trim($_POST["name"])))
        {
            $name_err = "Please enter your name.";
        }
        else {
            $name = trim($_POST["name"]);
        }
    
        if (empty(trim($_POST["phone"])))
        {
            $phone_err = "Please enter your phone.";
        }
        else {
            $phone = trim($_POST["phone"]);
        }
    
        //validate email
        if (empty(trim($_POST["email"])))
        {
            $email_err = "Please enter your email.";
        }
        else {
            //SANITIZE EMAIL
            $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        }
    
        //validate password
        if(empty(trim($_POST["message"])))
        {
            $message_err = "Please enter your message.";
        }
        else {
            $message = trim($_POST["message"]);
        }
    
        //Check input errors before inserting in databse
        if((empty($name_err) && empty($phone_err)) && (empty($message_err) && empty($email_err)))
        {
            $sql = "INSERT INTO contact_us (name, email, phone, comment) VALUES (:name, :email, :phone, :message)";
            $stmt = $db_connect->Insert($sql, ['name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message]);
    
            if ($stmt)
            {
                echo "<script>alert('Thanks for contacting us! \n Your comment has been sent.')</script>";
            }
            unset($stmt);
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
        <link rel="shortcut icon" href="images/logo_3.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="images/logo_2.png">

        <title>Jofedo.com</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">    
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/animate.css" />
        <link href="fonts/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/owl.carousel.min.css" />
        <link rel="stylesheet" href="css/owl.theme.default.min.css" />
        <link rel="stylesheet" href="css/style.css" />
    

        <script src="js/jquery-1.8.3.min.js"></script>

        <script src="owl-carousel/owl-carousel.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <!-- LOADER -->
        <div id="preloader">
            <div id="main-ld">
                <div id="loader"></div>  
            </div>
        </div><!-- end loader -->
        <!-- END LOADER -->

        <div class="bg">
            <header id="sticker">
                <div class="container">
                    <div class="navbar-brand">
                        <a href="index.html">JOFEDO</a>
                    </div>
                    <nav>
                        <ul>
                            <li><a class="active" href="index.php">Home</a></li>
                            <li><a href="#news">News</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </nav>    
                </div>
            </header>
    
    
            <!-- CONTENT -->
            <section class="onboard">
                <div class="container">
                    <h1>Today's <span>Inspiration</span></h1>
                    <h2>Lorem ipsum dolor, sit amet consectetur adipisicing elit.<br>
                         Sunt maxime debitis ex magni quisquam<br></h3>
                    <h4><span> - John Doe</h4><span></h4>
                </div>
            </section>
        </div>
        
        <section class="about" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-6">
                        <img src="images/slider-01.jpg" alt="">
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <?php
                            $sql = "SELECT * FROM about_us";
                            $result = $db_connect->Select($sql);
                            if($result)
                            {
                        ?>
                                <h3><?php echo $result[0]['heading']; ?></h3>
                                <p><?php echo $result[0]['body']; ?></p>
                        <?php
                            }
                        ?>
                        <hr>
                    </div>
                </div>
            </div>
        </section>

        <section class="news" id="news">
            <div class="container">
                <div class="row">
                    <?php
                        // Populate data from the database
                        $sql = "SELECT * FROM posts ORDER BY id DESC";
                        $stmt = $db_connect->Select($sql);
                        foreach ($stmt as $post)
                        {
                            $ano_sql = "SELECT COUNT(*) FROM reply WHERE post_id = :post_id";
                            $num_comment = $db_connect->Select($ano_sql, ["post_id" => $post['id']]);
                    
                    ?>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="news-item">
                                <div class="thumbnail">
                                    <img src="<?php echo "images/" . $post["image"]; ?>"/>
                                </div>
                                <div class="caption">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <p><i class="fa fa-comment"></i> <?php echo $num_comment[0]["COUNT(*)"]; ?> comments</p>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <p><?php echo date("F j, Y ", strtotime($post['created_at'])); ?></p>
                                        </div>
                                    </div>
                                    <h4><a href="single_post.php?title=<?php echo $post['slug']?>" style="color: #40c4ff">
                                    <?php
                                    $limit = 23;
                                    if (strlen($post['title']) <= $limit)
                                    {
                                        echo $post['title'];
                                    }
                                    else
                                    {
                                        echo substr_replace($post['title'], "..", $limit);
                                    }
                                    ?>
                                    </a></h4>
                                    <div><?php echo substr_replace($post['body'], "...", 90); ?></div>
                                    <a href="single_post.php?title=<?php echo $post['slug']?>" class="btn">Read more</a>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>

        <section class="contact" id="contact">
            <div class="container">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="form" onsubmit="return(validate(this))">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input class="form-control" name="name" value="<?php echo $name; ?>" type="text" placeholder="Your Name">
                                <span class="help-block"><?php echo $name_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="email" type="text" value="<?php echo $email; ?>" placeholder="Your Email">
                                <span class="help-block"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="phone" type="text" value="<?php echo $phone; ?>" placeholder="Your Phone">
                                <span class="help-block"><?php echo $phone_err; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <textarea class="form-control" name="message" value="<?php echo $message; ?>" placeholder="Your Message" data-validation-required-message="Please enter a message."></textarea>
                                <span class="help-block"><?php echo $message_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-12 text-center">
                            <input name="submit" class="btn" type="submit" value="Send Message" />
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="footer">
            <div class="container">
                <div class="row" style="text-align: center;">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h4>JOFEDO</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h4>Links</h4>
                        <p><a href="#about">About Us</a></p>
                        <p><a href="#news">news</a></p>
                        <p><a href="#contact">Contact Us</a></p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h4>Contact Us</h4>
                        <p><a><i class="fa fa-facebook"></i> @ facebook/jofedo.com</a></p>
                        <p><a><i class="fa fa-twitter"></i> @ jofedo</a></p>
                        <p><a><i class="fa fa-phone"></i> 000 0000 000</a></p>
                        <p><a><i class="fa fa-google"></i> jofedo@jofedo.com</a></p>
                    </div>
                </div>    
            </div>
        </section>

        <div class="copyrights">
            <div class="container">
                <div class="row">
                    <div style="text-align: center; width: 100%;">
                        <p>All Rights Reserved. &copy; 2020 <b><a href="admin/adminlogin.php">JOFEDO   </a></b> Developed by : <a href=""><b>Idowu Joseph</b></a></p>
                    </div>
                </div>
            </div><!-- end container -->
        </div><!-- end copyrights -->

        <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>


        <script src="js/custom.js"></script>

    </body>
</html>