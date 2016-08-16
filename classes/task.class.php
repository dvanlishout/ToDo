<?php

class Tasks
{
    private $m_sTaskname;
    private $m_iDate;


    public function __set($p_sProperty, $p_vValue)
    {
        $validation = new Validate();
        switch ($p_sProperty) {
            case "Taskname":
                if ($validation->isName($p_vValue)) {
                    $this->m_sTaskname = $p_vValue;  };

                break;

            case "Date":
                $this->m_iDate = $p_vValue;
                break;
        }
    }

    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Taskname":
                return $this->m_sTaskname;
                break;

        }
    }




    public function addTask()
    {
            $q = new query();
            $result = $q->newTaskquery($this->m_sTaskname, $_SESSION['listid'], $this->m_iDate);
            return $result;


    }

    public function getTime($deadline)
    {
        $today = date("Ymd");
        $countdown = strtotime($deadline) - strtotime($today);
        $days =$countdown /86400;
        return $days;
    }






}