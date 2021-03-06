<?php
class Schuchert_DVR_Program
{
    public $programName;
    public $episodeName;
    public $timeSlot;
 
    public function __construct($programName, $episodeName, $timeSlot)
    {
        $this->programName = $programName;
        $this->episodeName = $episodeName;
        $this->timeSlot = $timeSlot;
    }

    public function getId()
    {
        return sprintf("(%s:%d)", $this->programName, $this->timeSlot->channel);
    }

    public function sameEpisodeAs($program)
    {
        return ($this->timeSlot->channel == $program->timeSlot->channel)
            && ($this->programName == $program->programName)
            && ($this->episodeName == $program->episodeName);
    }
}
