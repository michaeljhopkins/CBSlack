<?php namespace Drapor\Networking\Traits;
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 1/12/15
 * Time: 5:18 PM
 */
trait TimeElapsed{


    /**
     * @var int $startedAt
     */
    public $startedAt;

    /**
     * @var int $endedAt
     */
    public $endedAt;

    /**
     * @var int $time_elapsed
     */
    public $time_elapsed;

    /**
     * @return int
     */
    public function getTimeElapsed()
    {
        return round($this->time_elapsed,7);
    }

    /**
     * @return mixed
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }


    public function setEndedAt()
    {
        $this->endedAt = microtime(true);
        $this->time_elapsed = $this->benchmark();
    }

    /**
     * @return mixed
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }


    public function setStartedAt()
    {
        $this->startedAt = microtime(true);
    }

    public function benchmark(){
        return $this->getEndedAt() - $this->getStartedAt();
    }




}