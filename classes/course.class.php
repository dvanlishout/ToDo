<?php

class Course
{
    private $m_sCoursename;
    private $m_sTeacher;


    public function __set($p_sProperty, $p_vValue)
    {
        $validation = new Validate();
        switch ($p_sProperty) {

            case "Coursename":
                    $this->m_sCoursename = $p_vValue;

                break;

            case "Teacher":
                if ($validation->isName($p_vValue)) {
                $this->m_sTeacher = $p_vValue; };
                break;
        }
    }

// GETTER FUNCTION
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Coursename":
                return $this->m_sCoursename;
                break;
            case "Teacher":
                return $this->m_sTeacher;
                break;

        }
    }




    public function addCourse()
    {
        $q = new query;
        if ($q->coursenameQuery($this->m_sCoursename)) {
            $q = new query();
            $q->newCoursequery($this->m_sCoursename, $this->m_sTeacher );
            return true;

        }

        else{
            throw new Exception("Dit vak is al aangemaakt");

        }
    }

    public function listCourse(){
        $q = new query;
        $result = $q->chooseCourse();
        return $result;



    }










}
