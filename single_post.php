<?php
// include function file
require_once('functions/DatabaseClass.php');


$msg = "";
$name = $email = $website = $message = "";
$name_err = $email_err = $message_err = "";


if(isset($_GET['title']))
{
    $slug = trim($_GET['title']);
    $db_connect = new DatabaseClass("localhost", "blog", "root", "");

    $sql = "SELECT * FROM posts WHERE slug = :slug";
    $blog = $db_connect->Select($sql, ["slug" => $slug]);


    if ($blog)
    {
        // Populate data from the database
        $query = "SELECT * FROM posts";
        $posts = $db_connect->Select($query);

        $sql = "SELECT * FROM reply WHERE post_id = :post_id ORDER BY id DESC";
        $result = $db_connect->Select($sql, ["post_id" => $blog[0]['id']]);

        $ano_sql = "SELECT COUNT(*) FROM reply WHERE post_id = :post_id";
        $num_comment = $db_connect->Select($ano_sql, ["post_id" => $blog[0]['id']]);

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
                            <li><a href="index.php">Home</a></li>
                            <li><a href="index#news">News</a></li>
                            <li><a href="index#about">About</a></li>
                            <li><a href="index.php#contact">Contact</a></li>
                        </ul>
                    </nav>    
                </div>
            </header>
    
    
            <!-- CONTENT -->
            <section class="onboard">
                <div class="container">
                <h1>JOFEDO<span>.COM</span></h1>
                    <h2>Professional Blog Page<br></h3>
                </div>
            </section>
        </div>
    <div class="container single">
        <div class="row" style="width: 100%">
            <div class="col-sm-8 col-md-8 col-lg-8">
                <div class="main-posts">
                    <img src="<?php echo "images/" . $blog[0]["image"]; ?>" style="margin-bottom: 20px;"/>
                    <div class="post-information">
                        <h2><?php echo $blog[0]['title']; ?></h2>
                        <div class="entry-meta">
                            <small>
                                <span class="author-meta"><i class="fa fa-user"></i> admin </span>
                                <span> <i class="fa fa-clock-o"> </i> <?php echo date("F j, Y ", strtotime($blog[0]['created_at'])); ?></span>
                                <span> <i class="fa fa-comments-o"> </i> <a href="#comment-list"><?php echo $num_comment[0]["COUNT(*)"]; ?> comments</a></span>
                            </small>
                        </div>
                        <div class="entry-content">
                            <?php echo $blog[0]['body']; ?>
                        </div>
                    </div>
                </div>
                <div class="comment-list" id="comment-list">
                    <div class="comments-heading">
                        <h3><?php echo $num_comment[0]["COUNT(*)"]; ?> comments</h3>
                    </div>
                    <?php
                        foreach ($result as $reply)
                        {
                    ?>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <img src="images/avatar.jpg"/>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                    <div style="margin-bottom: 5px;"><b><?php echo $reply['name']; ?></b> 
                                    <small><?php echo date("F j, Y", strtotime($reply['added_on'])) . " at " . date("g:i a", strtotime($reply['added_on'])); ?></small></div>
                                    <div><?php echo $reply['reply']; ?></div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="reply">
                    <h3 class="comment-reply-title">Leave a Reply </h3>
                    <small>Your email address will not be published. Required fields are marked *</small>
                    <form method="POST" action="validate_comment.php" role="form">
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
                                <input type="hidden" name="post_id" value="<?php echo $blog[0]['id']; ?>">
                                <input name="submit" class="btn" type="submit" value="Post Comment" />
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="side-posts">
                    <h4>Hot Topics</h4>
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
                                        <h5><a href="single_post.php?title=<?php echo $row['slug']?>"><?php echo $row['title']; ?></a></h5>
                                        <p style="color: rgba(0, 0, 0, 0.4);"><?php echo date("j F Y ", strtotime($row['created_at'])); ?></p>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="side-posts">
                        <h4>categories</h4>
                        <ul>
                        <?php
                            $sql = "SELECT * FROM topics";
                            $result = $db_connect->Select($sql);
                            foreach($result as $row)
                            {
                        ?>
                            <li>
                                <a href="#"><?php echo $row['name']; ?></a>
                            </li>
                        <?php
                            }
                        ?>
                        </ul>
                </div>
                <div class="side-posts">
                <h4>archive</h4>
                <ul>
                  <li>
                    <a href="#">07 July 2016</a>
                  </li>
                  <li>
                    <a href="#">29 June 2016</a>
                  </li>
                  <li>
                    <a href="#">13 May 2016</a>
                  </li>
                  <li>
                    <a href="#">20 March 2016</a>
                  </li>
                  <li>
                    <a href="#">09 Fabruary 2016</a>
                  </li>
                </ul>
            </div>
                </div>
            </div>
        </div>
    </div>

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



<script src="js/custom.js"></script>

</body>
</html>