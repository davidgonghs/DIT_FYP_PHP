<?php


class Question{
    public static $db_name = "t_question";
    public $question_id;
    public $assessment_id;//哪个作业
    public $subject_id;//课程id
    public $lo_id;

    public $question_code; // Question like  1a ， 2A ，3b
    public $full_mark;

    /**
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id): void
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getAssessmentId()
    {
        return $this->assessment_id;
    }

    /**
     * @param mixed $assessment_id
     */
    public function setAssessmentId($assessment_id): void
    {
        $this->assessment_id = $assessment_id;
    }

    /**
     * @return mixed
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * @param mixed $subject_id
     */
    public function setSubjectId($subject_id): void
    {
        $this->subject_id = $subject_id;
    }

    /**
     * @return mixed
     */
    public function getLoId()
    {
        return $this->lo_id;
    }

    /**
     * @param mixed $lo_id
     */
    public function setLoId($lo_id): void
    {
        $this->lo_id = $lo_id;
    }



    /**
     * @return mixed
     */
    public function getQuestionCode()
    {
        return $this->question_code;
    }

    /**
     * @param mixed $question_code
     */
    public function setQuestionCode($question_code): void
    {
        $this->question_code = $question_code;
    }

    /**
     * @return mixed
     */
    public function getFullMark()
    {
        return $this->full_mark;
    }

    /**
     * @param mixed $full_mark
     */
    public function setFullMark($full_mark): void
    {
        $this->full_mark = $full_mark;
    }


}