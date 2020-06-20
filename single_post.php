<?php
// include function file
require_once('functions/DatabaseClass.php');

if(isset($_GET['title']))
{
    $slug = trim($_GET['title']);
    $db_connect = new DatabaseClass("localhost", "blog", "root", "");

    $sql = "SELECT * FROM posts WHERE slug = :slug";
    $post = $db_connect->Select($sql, ["slug" => $slug]);

    if ($post)
    {
        $query = "SELECT * FROM posts";
        $posts = $db_connect->Select($query);

        $msg = "";
        $name = $email = $website = $message = "";
        $name_err = $email_err = $message_err = "";

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

                $website = trim($_POST['website']);
                
                //validate email
                if (empty(trim($_POST["email"])))
                {
                    $email_err = "Please enter your email.";
                }
                else
                {
                    //SANITIZE EMAIL
                    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
                }

            
                //validate message
                if(empty(trim($_POST["message"])))
                {
                    $message_err = "Please enter your message.";
                }
                else {
                    $message = trim($_POST["message"]);
                }
            
                //Check input errors before inserting in databse
                if(empty($name_err) && (empty($message_err) && empty($email_err)))
                {
                    $sql = "INSERT INTO reply (name, email, website, comment) VALUES (:name, :email, :website, :comment)";
                    $stmt = $db_connect->Insert($sql, ['name' => $name, 'email' => $email, 'website' => $website, 'comment' => $message]);
                    unset($stmt);
                }    
            }
        }
    }
    else
    {
        header("location: index.php");
        exit;
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
        <header class="single">
            <div class="container">
                <div class="navbar-brand">
                    <a href="index.html">JOFEDO</a>
                </div>
                <nav>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li><a href="">News</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="index.php#contact">Contact</a></li>
                    </ul>
                </nav>    
            </div>
        </header>
        
        <div class="container single">
            <div class="row" style="width: 100%">
                <div class="col-sm-8 col-md-8 col-lg-8">
                    <div class="main-posts">
                        <h1 style="margin-bottom: 20px;"><?php echo $post[0]['title']; ?></h1>
                        <img src="<?php echo "images/" . $post[0]["image"]; ?>" style="margin-bottom: 20px;"/>
                        <p><?php echo $post[0]['body']; ?></p>
                    </div>
                    <div class="reply">
                        <h5>LEAVE A REPLY </h5>
                        <small>Your email address will not be published. Required fields are marked *</small>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="form">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input class="form-control" name="name" value="<?php echo $name; ?>" type="text" required>
                                        <span class="help-block"><?php echo $name_err; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input class="form-control" name="email" type="text" value="<?php echo $email; ?>" required>
                                        <span class="help-block"><?php echo $email_err; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input class="form-control" name="website" type="text" value="<?php echo $website; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="message">Reply *</label>
                                        <textarea class="form-control" name="message" value="<?php echo $message; ?>" required></textarea>
                                        <span class="help-block"><?php echo $message_err; ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                <input name="submit" class="btn" type="submit" value="Post Coment" />
                            </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="side-posts">
                        <h3>Hot Topics</h3>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <a href="#" class="btn">All</a>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <a href="#" class="btn">Recent</a>
                            </div>
                        </div>
                        <div>
                            <?php
                                foreach ($posts as $row)
                                {
                            ?>
                                    <div class="row" style="margin-bottom: 20px;" >
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <img src="<?php echo "images/" . $row["image"]; ?>"/>
                                        </div>
                                        <div class="col-sm-8 col-md-8 col-lg-8">
                                            <h5><a href="single_post.php?title=<?php echo $row['slug']?>" style="color: #40c4ff"><?php echo $row['title']; ?></a></h5>
                                            <p style="color: rgba(0, 0, 0, 0.4);"><?php echo date("j F Y ", strtotime($row['created_at'])); ?></p>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script src="js/custom.js"></script>

</body>
</html>