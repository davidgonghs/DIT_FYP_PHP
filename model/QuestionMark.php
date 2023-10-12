<?php

//the mark of student
class QuestionMark{
    public static $db_name = "t_question_marks";
    public $mark_id;
    public $question_id;//哪个作业
    public $student_number;//课程id
    public $mark;
    /**
     * @return mixed
     */
    public function getMarkId()
    {
        return $this->mark_id;
    }

    /**
     * @param mixed $mark_id
     */
    public function setMarkId($mark_id): void
    {
        $this->mark_id = $mark_id;
    }

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
    public function getStudentNumber()
    {
        return $this->student_number;
    }

    /**
     * @param mixed $student_number
     */
    public function setStudentNumber($student_number): void
    {
        $this->student_number = $student_number;
    }

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param mixed $mark
     */
    public function setMark($mark): void
    {
        $this->mark = $mark;
    }


}