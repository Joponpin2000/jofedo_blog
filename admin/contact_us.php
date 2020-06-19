<?php
session_start();

// include function file
require_once('../functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

if(!isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] !== true))
{
	header("location:adminlogin.php");
}

if (isset($_GET['type']) && trim($_GET['type']) != '')
{
    $type = trim($_GET['type']);

    if ($type == 'delete')
    {
        $id = trim($_GET['id']);
        
        // Execute a Delete statement
        $sql = "DELETE FROM contact_us WHERE id = :id";
        $stmt = $db_connect->Remove($sql, ['id' => $id]);

        // Close statement
        unset($stmt);
    }
}

// Populate data from database
$sql = "SELECT * FROM contact_us ORDER BY id DESC";
$result = $db_connect->Select($sql);
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


            <div class="wrapper">
                <nav id="sidebar">
                    <div class="sidebar-header">
                        <h3 style="color: white">Admin Panel</h3>
                    </div>
                    <ul class="list-unstyled components">
                        <li>
                            <a href="posts.php">Posts</a>
                        </li>
                        <li>
                            <a class="active" href="contact_us.php">Contact Us</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </nav>
                <div id="content" style="padding-left: 20px; width: 100vw">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <button class="btn" type="button" id="sidebarCollapse" style="background: #7386D5;">&#9776;</button>
                        </div>
                    </nav>
                    <div class="title">
                        <h3>Contact Us</h3>
                    </div>
                    <div class="table" style="width: 100%;">
                        <table style="width: 100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach ($result as $row)
                            {
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['usernname'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['comment'] ?></td>
                                <td><?php echo $row['added_on'] ?></td>
                                <td>
                                    <?php
                                    echo "&nbsp;<span class='sett delete'><a href='?type=delete&id=" . $row['id'] .  "'>Delete</a><span>";
                                    ?>
                                </td>
                            </tr>
                        <?php
                        ++$i;
                        }
                        ?>
                    </tbody>
                        </table>
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
                </div>
                
            </div>


            <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

            <script src="../js/custom.js"></script>
    </body>
</html>