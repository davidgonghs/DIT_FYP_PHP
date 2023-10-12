<?php

//Programme Outcome
class ProgrammeOutcome{
    public static $db_name = "t_po";
    public $po_id;
    public $po_code;
    public $po_name;
    public $program_id;//学系id

    /**
     * @return mixed
     */
    public function getPoCode()
    {
        return $this->po_code;
    }

    /**
     * @param mixed $po_code
     */
    public function setPoCode($po_code): void
    {
        $this->po_code = $po_code;
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
    public function getPoName()
    {
        return $this->po_name;
    }

    /**
     * @param mixed $po_name
     */
    public function setPoName($po_name): void
    {
        $this->po_name = $po_name;
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