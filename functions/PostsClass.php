<?php
require_once("DatabaseClass.php");
class Posts extends DatabaseClass
{
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