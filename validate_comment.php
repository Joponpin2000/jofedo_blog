<?php
// include function file
require_once('functions/DatabaseClass.php');


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

        $post_id = trim($_POST['post_id']);

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
            $db_connect = new DatabaseClass("localhost", "blog", "root", "");

            $sql = "INSERT INTO reply (post_id, name, email, website, reply) VALUES (:post_id, :name, :email, :website, :reply)";
            $stmt = $db_connect->Insert($sql, ['post_id' => $post_id, 'name' => $name, 'email' => $email, 'website' => $website, 'reply' => $message]);
            unset($stmt);


            $sql = "SELECT * FROM posts WHERE id = :id";
            $blog = $db_connect->Select($sql, ["id" => $post_id]);
        
            if ($blog)
            {
                header("location: single_post.php?title=" . $blog[0]['slug']);
            }
            else
            {
                header("location: index.php");
                exit;
            }        
        }    
    }
}

?>