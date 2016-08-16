<?php

class Comment
{
    private $m_sComment;


    public function __set($p_sProperty, $p_vValue)
    {

        switch ($p_sProperty) {

            case "Comment":
                $this->m_sComment = $p_vValue;
                break;
        }
    }

// GETTER FUNCTION
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Comment":
                return $this->m_sComment;
                break;

        }
    }



    public function addComment($taskid)
    {
        $q = new query();
        $q->newCommentquery($this->m_sComment, $_SESSION['user_id'], $taskid);
        return true;

    }


}

