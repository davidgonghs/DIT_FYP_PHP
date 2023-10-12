<?php


class Subject{
    public static $db_name = "t_subject";
    public $subject_id;
    public $program_id;
    public $model_code;
    public $model_name;// full name
    public $model_sname;//short name  AWD..
    public $lecturer;
    public $semester_id;

    /**
     * @return mixed
     */
    public function getSemesterId()
    {
        return $this->semester_id;
    }

    /**
     * @param mixed $semester_id
     */
    public function setSemesterId($semester_id): void
    {
        $this->semester_id = $semester_id;
    }

    /**
     * @return mixed
     */
    public function getProgramId()
    {
        return $this->program_id;
    }

    /**
     * @param mixed $program_id
     */
    public function setProgramId($program_id): void
    {
        $this->program_id = $program_id;
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
    public function getModelCode()
    {
        return $this->model_code;
    }

    /**
     * @param mixed $model_code
     */
    public function setModelCode($model_code): void
    {
        $this->model_code = $model_code;
    }

    /**
     * @return mixed
     */
    public function getModelName()
    {
        return $this->model_name;
    }

    /**
     * @param mixed $model_name
     */
    public function setModelName($model_name): void
    {
        $this->model_name = $model_name;
    }

    /**
     * @return mixed
     */
    public function getModelSname()
    {
        return $this->model_sname;
    }

    /**
     * @param mixed $model_sname
     */
    public function setModelSname($model_sname): void
    {
        $this->model_sname = $model_sname;
    }

    /**
     * @return mixed
     */
    public function getLecturer()
    {
        return $this->lecturer;
    }

    /**
     * @param mixed $lecturer
     */
    public function setLecturer($lecturer): void
    {
        $this->lecturer = $lecturer;
    }





}