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

    // function to insert row(s) in a database
    public function Insert($statement = "", $parameters = [])
    {
        $this->executeStatement($statement, $parameters);
        return $this->connection->lastInsertId();
    }

    // function to select row(s) in a database
    public function Select($statement = "", $parameters = [])
    {
        $stmt = $this->executeStatement($statement, $parameters);
        return $stmt->fetchAll();
    }

    // function to update row(s) in a database
    public function Update($statement = "", $parameters = [])
    {
        $this->executeStatement($statement, $parameters);
    }

    // function to remove row(s) in a database
    public function Remove($statement = "", $parameters = [])
    {
        $this->executeStatement($statement, $parameters);
    }

    // function to execute statement
    private function executeStatement($statement = "", $parameters = [])
    {
        if ($stmt = $this->connection->prepare($statement))
        {
            if ($stmt->execute($parameters))
            {
                return $stmt;    
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }    
}

?>