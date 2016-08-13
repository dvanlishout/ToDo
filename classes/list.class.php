<?php
/**
 * Created by PhpStorm.
 * User: Ditte
 * Date: 05/08/16
 * Time: 12:08
 */

class TodoList
{
    private $m_sListname;


    public function __set($p_sProperty, $p_vValue)
    {

        switch ($p_sProperty) {

            case "Listname":
                $this->m_sListname = $p_vValue;
                break;
        }
    }

// GETTER FUNCTION
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Listname":
                return $this->m_sListname;
                break;

        }
    }

    public function newList()
    {

        // VERIFICATION: IF FILLED IN


        // CONNECTION WITH DATABASE
        $conn = Db::getInstance();
        //$conn = mysqli_connect("localhost", "root", "root", "imd");

        // PREPARE QUERY
        $statement = $conn->prepare("INSERT INTO list (listname, fk_userid) VALUES (:listname, :fk_userid)");

        // HASH PASSWORD


        // BIND VALUES TO QUERY
        $statement->bindValue(":listname", $this->m_sListname);
        $statement->bindValue(":fk_userid", $_SESSION['user_id']);
        $listname = $this->m_sListname;


        // CHECK IF USERNAME/EMAIL ALREADY EXISTS
        if ($this->ListnameAvailable()) {

            $_SESSION['loginfeedback'] = "This name is already taken!";


        } else {
            $_SESSION['loginfeedback'] = "Welcome aboard!";

            $statement->execute();
            $fp= fopen($listname . '.php', 'w');
            fwrite($fp, '
            <?php $_SESSION["listname"] = $listname;?>

            <div id="new list">
                <a href="addTask.php" class="button btn btn-primary">New Task </a>
            </div>
');
            fclose($fp);


        }




    }

    public function ListnameAvailable()
    {

        $PDO = Db::getInstance();

        $statement = $PDO->prepare("SELECT listname FROM list WHERE listname = :listname");
        $statement->bindValue(":listname", $this->m_sListname);

        $statement->execute();
        $count = count($statement->fetchAll());

        if ($count > 0) {

            return true;

        } else {

            return false;
        }


    }


    public function showList()
    {
        $PDO = Db::getInstance();
        $statement = $PDO->prepare("SELECT * FROM");
        $statement->execute();
        $listz = $statement->fetchAll();
        foreach ($listz as $row)
        {

            ?><div class="row"> <button class="btn btn-secondary  listname col-md-2    " value="<?php echo $row['listname'] ?>"
                                        onclick="showList(this.value);">
                <?php echo $row['listname']; ?>
            </button> </div> <?php
        }



    }



}