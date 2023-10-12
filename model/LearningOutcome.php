<?php

//Learning Outcome
class LearningOutcome{
    public static $db_name = "t_lo";
    public $lo_id;
    public $po_id;
    public $lo_code;
    public $lo_name;
    public $subject_id;//课程id

    /**
     * @return mixed
     */
    public function getLoCode()
    {
        return $this->lo_code;
    }

    /**
     * @param mixed $lo_code
     */
    public function setLoCode($lo_code): void
    {
        $this->lo_code = $lo_code;
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
    public function getPoId()
    {
        return $this->po_id;
    }

    /**
     * @param mixed $po_id
     */
    public function setPoId($po_id): void
    {
        $this->po_id = $po_id;
    }

    /**
     * @return mixed
     */
    public function getLoName()
    {
        return $this->lo_name;
    }

    /**
     * @param mixed $lo_name
     */
    public function setLoName($lo_name): void
    {
        $this->lo_name = $lo_name;
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

}