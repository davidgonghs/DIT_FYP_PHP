<?php


class SemesterStudent
{
    public static $db_name = "t_semester_student";
    public $sms_id;
    public $semester_id;
    public $student_number;

    /**
     * @return mixed
     */
    public function getSmsId()
    {
        return $this->sms_id;
    }

    /**
     * @param mixed $sms_id
     */
    public function setSmsId($sms_id): void
    {
        $this->sms_id = $sms_id;
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

}