<?php


class Teacher{
    public static $db_name = "t_teacher_user";
    public $staff_number;
    public $user_name;
    public $email;
    public $password; //sha1 加密
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
    public function getStaffNumber()
    {
        return $this->staff_number;
    }

    /**
     * @param mixed $staff_number
     */
    public function setStaffNumber($staff_number): void
    {
        $this->staff_number = $staff_number;
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


}