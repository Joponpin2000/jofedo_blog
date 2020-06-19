<?php
// include function file
require_once('functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

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
                            <li><a href="">News</a></li>
                            <li><a href="">About</a></li>
                            <li><a href="">Contact</a></li>
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
        
        <section class="about">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-6">
                        <img src="images/slider-01.jpg" alt="">
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <h3>Hello Friends!</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel beatae impedit, sunt necessitatibus
                             voluptas sequi omnis tenetur exercitationem. Iure ameo quibusdam animi magnam corrupti? Necessitatibus,
                              quidem vel maxime et consequatur accusamus.</p>
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel beatae impedit, sunt necessitatibus
                                voluptas sequi omnis tenetur exercitationem. Iure ameo quibusdam animi magnam corrupti? Necessitatibus,
                                 quidem vel maxime et consequatur accusamus.</p>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <p>70 Macember 1307</p>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <p>Posted by: John Doe</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="news">
            <div class="container">
                <div class="row">
                    <?php
                        // Populate data from the database
                        $sql = "SELECT * FROM posts";
                        $stmt = $db_connect->Select($sql);
                        foreach ($stmt as $post)
                        {
                    ?>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="news-item">
                                <div class="thumbnail">
                                    <img src="<?php echo "images/" . $post["image"]; ?>"/>
                                </div>
                                <div class="caption">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <p><i class="fa fa-comment"></i> 90 comments</p>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <p><?php echo date("F j, Y ", strtotime($post['created_at'])); ?></p>
                                        </div>
                                    </div>
                                    <h4><a href="single_post.php?title=<?php echo $post['slug']?>" style="color: #40c4ff"><?php echo $post['title']; ?></a></h4>
                                    <p><?php echo $post['body']; ?></p>
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

        <section class="footer">
            <div class="container">
                <div class="row" style="text-align: center;">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h4>JOFEDO</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h4>Links</h4>
                        <p><a href="#donation">blog</a></p>
                        <p><a href="#causes">news</a></p>
                        <p><a href="contact">Contact Us</a></p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <h4>Contact Us</h4>
                        <p><a><i class="fa fa-facebook"></i> @/facebook/jofedo.com</a></p>
                        <p><a><i class="fa fa-twitter"></i> @jofedo</a></p>
                        <p><a><i class="fa fa-phone"></i> 000 0000 000</a></p>
                        <p><a><i class="fa fa-google"></i> jofedo@sosi.com</a></p>
                    </div>
                </div>    
            </div>
        </section>

        <div class="copyrights">
            <div class="container">
                <div class="row">
                    <div style="text-align: center; width: 100%;">
                        <p>All Rights Reserved. &copy; 2020 <b><a href="#">JOFEDO   </a></b> Developed by : <a href=""><b>Idowu Joseph</b></a></p>
                    </div>
                </div>
            </div><!-- end container -->
        </div><!-- end copyrights -->

        <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>


        <script src="js/custom.js"></script>

    </body>
</html>