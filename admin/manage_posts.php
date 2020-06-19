<?php
session_start();

// include function file
require_once('functions/DatabaseClass.php');

$db_connect = new DatabaseClass("localhost", "blog", "root", "");

if(!isset($_SESSION['admin']))
{
	header("location:adminlogin.php");
}

$title = "";
$image = "";
$body = "";

$msg = "";
$image_required = 'required';

if (isset($_GET['id']) && (trim($_GET['id']) != ''))
{
    $image_required = '';
    $id = trim($_GET['id']);

    // Populate data from database
    $sql = "SELECT * FROM posts WHERE id = :id ";
    $stmt = $db_connect->Select($sql, ["id" => $id]);

    if ($stmt->rowCount() == 1)
    {
        $title = $stmt[0]['title'];    
        $image = $stmt[0]['image'];    
        $body = $stmt[0]['body'];    
    }
    else
    {
        header("location: posts.php");
        die();            
    }

    // Close statement
    unset($stmt);
}


if(isset($_POST['submit']))
{
    $title = trim($_POST['title']);
    $body = trim($_POST['body']);

    if ($_FILES['image']['type'] != '' && $_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg')
    {
        $msg = "Please select only png, jpg and jpeg formats.";
    }

    if ($msg == "")
    {
        if (isset($_GET['id']) && (trim($_GET['id']) != ''))
        {
            if ($_FILES['image']['name'] != '')
            {
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);

                // Execute an update statement
                $sql = "UPDATE posts SET title = :title, body = :body, image = :image WHERE id = :id ";
                $stmt = $db_connect->Update($sql, ['title' => $title, 'body' => $body, 'image' => $image, 'id' => $id]);

                // Close statement
                unset($stmt);
            }
            else
            {
                // Execute an update statement
                $sql = "UPDATE posts SET title = :title, body = :body WHERE id = :id ";
                $stmt = $db_connect->Update($sql, ['title' => $title, 'body' => $body, 'id' => $id]);

                // Close statement
                unset($stmt);
            }
        }
        else
        {
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
            
            // Execute an insert statement
            $sql = "INSERT INTO posts (title, body, image) VALUES (:title, :body, :image)";
            $stmt = $db_connect->Update($sql, ['title' => $title, 'body' => $body, 'image' => $image, 'id' => $id]);

            // Close statement
            unset($stmt);
        }
        header("location: posts.php");
        die();        
    }
}

unset($pdo);

?>


<!DOCTYPE html>
<html>
    <head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
     <!-- Site Metas -->
    <title>JOFEDO</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap-1.css">

    <!-- Site CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="../css/versions.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/custom.css">
    </head>
    <body>
            <div class="wrapper">
                <nav id="sidebar">
                    <div class="sidebar-header">
                        <h3 style="color: white">Admin Panel</h3>
                    </div>
                    <ul class="list-unstyled components">
                        <li>
                            <a href="product.php" class="active">Posts</a>
                        </li>
                        <li>
                            <a href="users.php">Users</a>
                        </li>
                        <li>
                            <a href="contact_us.php">Contact Us</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </nav>
                <div id="content" style="padding-left: 20px; width: 100vw">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <button class="btn btn-warning" type="button" id="sidebarCollapse" style="background: #7386D5;">&#9776;</button>
                        </div>
                    </nav>
                    <div class="container">
                    <div class="title">
                        <h5>Add Post</h5>
                    </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 cat-block">
                            <div class="form-block">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Post Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title ?>" placeholder="Enter post title" required/>
                                </div>
                                <div class="form-group">
                                    <label for="image" class="form-control-label">Image</label>
                                    <input type="file" name="image" class="form-control" <?php echo $image_required ?>/>
                                </div>
                                <div class="form-group">
                                    <label for="body" class="form-control-label">Body</label>
                                    <textarea name="body" class="form-control" placeholder="Enter post body"><?php echo $body ?></textarea>
                                </div>
                                <button type="submit" name="submit" class="btn btn-warning btn-block">Submit</button>
                                <span class="help-block" style="color:red;"><?php echo $msg; ?></span>
                            </form>
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

                </div>
            </div>


            <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

            <script src="js/custom.js"></script>
    </body>
</html>