<?php


class Program{
    public static $db_name = "t_program";
    public $program_id;
    public $name;
    public $dean;// teacher staff_id
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDean()
    {
        return $this->dean;
    }

    /**
     * @param mixed $dean
     */
    public function setDean($dean): void
    {
        $this->dean = $dean;
    }

}