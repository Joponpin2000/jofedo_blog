<?php

class DatabaseClass
{
    protected $connection = null;

    // this function is called everytime this class is instantiated
    public function __construct($db_host = "localhost", $db_name = "blog", $db_username = "root", $db_password = "")
    {
        try
        {
            $this->connection = new PDO("mysql:host={$db_host};dbname={$db_name};", $db_username, $db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
}

?>