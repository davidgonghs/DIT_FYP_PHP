<?php


class Student{
    public static $db_name = "t_student_user";
    public $student_number;
    public $user_name;
    public $email;
    public $password;//sha1 加密
    public $ic_passport; // ic card
    public $program_id; //学系
    public $status;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
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
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $name
     */
    public function setUserName($userName): void
    {
        $this->user_name = $userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIcPassport()
    {
        return $this->ic_passport;
    }

    /**
     * @param mixed $ic_passport
     */
    public function setIcPassport($ic_passport): void
    {
        $this->ic_passport = $ic_passport;
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


}