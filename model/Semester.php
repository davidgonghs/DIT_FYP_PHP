<?php


class Semester{
    public static $db_name = "t_semester";
    public $semester_id;
    public $semester_infor;
    public $semester_date;
    public $program_id;

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
    public function getSemesterInfor()
    {
        return $this->semester_infor;
    }

    /**
     * @param mixed $semester_infor
     */
    public function setSemesterInfor($semester_infor): void
    {
        $this->semester_infor = $semester_infor;
    }

    /**
     * @return mixed
     */
    public function getSemesterDate()
    {
        return $this->semester_date;
    }

    /**
     * @param mixed $semester_date
     */
    public function setSemesterDate($semester_date): void
    {
        $this->semester_date = $semester_date;
    }





}