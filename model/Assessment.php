<?php


class Assessment{
    public static $db_name = "t_assessment";
    public $assessment_id;
    public $assessment_name;
    public $subject_id;//课程id
    public $type; //类型  assignment=0,classwork=1,Tutorial=2, Midterm test=3,final exam=4,quize=5
    public $weight;//权重




    /**
     * @return mixed
     */
    public function getAssessmentName()
    {
        return $this->assessment_name;
    }

    /**
     * @param mixed $assessment_name
     */
    public function setAssessmentName($assessment_name): void
    {
        $this->assessment_name = $assessment_name;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }


}