<?php


class TodoList
{
    private $m_sListname;


    public function __set($p_sProperty, $p_vValue)
    {
        $validation = new Validate();
        switch ($p_sProperty) {

            case "Listname":
                if ($validation->isName($p_vValue)) {
                    $this->m_sListname = $p_vValue;  };
        }
    }


    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Listname":
                return $this->m_sListname;
                break;

        }
    }




    public function addList($courseID)
    {

        $q = new query;
        if ($q->listnameQuery($this->m_sListname)) {
            $q = new query();
            $q->newListquery($this->m_sListname, $_SESSION['user_id'], $courseID );
            return true;
        }


        else {
                throw new Exception("Deze lijstnaam is al in gebruik");
            }
    }



}