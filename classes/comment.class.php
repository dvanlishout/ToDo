<?php

class Comment
{
    private $m_sComment;


    public function __set($p_sProperty, $p_vValue)
    {

        switch ($p_sProperty) {

            case "Commenttext":
                $this->m_sComment = $p_vValue;
                break;
        }
    }

// GETTER FUNCTION
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case "Commenttext":
                return $this->m_sComment;
                break;

        }
    }



    public function addComment()
    {
        $q = new query();
        $q->newCommentquery($this->m_sComment, $_SESSION['user_id'], $_SESSION['taskid']);
        return $q;

    }


}

