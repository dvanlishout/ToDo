<?php
/**
 * Created by PhpStorm.
 * User: Ditte
 * Date: 06/08/16
 * Time: 12:29
 */
class Task
{
    private $m_sTaskname;


    public function __set($p_sProperty, $p_vValue)
    {

        switch ($p_sProperty) {

            case "Taskname":
                $this->m_sTaskname = $p_vValue;
                break;
        }
    }

// GETTER FUNCTION
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Taskname":
                return $this->m_sTaskname;
                break;

        }
    }


    public function getListId()
    {

        $PDO = Db::getInstance();
        $arr = $PDO->prepare("SELECT listid FROM list WHERE listname = :listname");
        $arr->bindValue(":listname", $_SESSION["listname"]);
        $arr->execute();
        $data_array = $arr->fetchAll();


        $_SESSION["listid"] = $data_array[0]['listID'];






        return true;

    }

    public function newTask()
    {

        // VERIFICATION: IF FILLED IN


        // CONNECTION WITH DATABASE
        $conn = Db::getInstance();
        //$conn = mysqli_connect("localhost", "root", "root", "imd");

        // PREPARE QUERY
        $statement = $conn->prepare("INSERT INTO task (taskname, fk_listid) VALUES (:taskname, :fk_listid)");

        // HASH PASSWORD


        // BIND VALUES TO QUERY
        $statement->bindValue(":taskname", $this->m_sTaskname);
        $statement->bindValue(":fk_listid", $_SESSION["listid"]);



        // CHECK IF USERNAME/EMAIL ALREADY EXISTS

            $statement->execute();







    }







    public function showList()
    {
        $PDO = Db::getInstance();

        $statement = $PDO->prepare("SELECT listname FROM list");
        foreach ($statement as $row)
        {
            return $row['listname'] . "\n";
        }

    }



}