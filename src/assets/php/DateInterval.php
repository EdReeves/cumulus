<?php namespace edreeves\cumulus;



class DateInterval extends \alroniks\dtms\DateInterval
{
    /**
     * @param DateInterval $interval2
     * @param bool $absolute
     * @return bool|\DateInterval
     */
    public function diff(DateInterval $interval2, $absolute = false)
    {
        $datetime1 = date_create();
        $datetime2 = clone $datetime1;

        $datetime1 = $datetime1->add($this);
        $datetime2 = $datetime2->add($interval2);

        return $datetime1->diff($datetime2, $absolute);
    }

    /**
     * @param DateInterval $interval2
     * @return int
     */
    public function compare(DateInterval $interval2)
    {
        $datetime1 = date_create();
        $datetime2 = clone $datetime1;

        $datetime1 = $datetime1->add($this);
        $datetime2 = $datetime2->add($interval2);

        if($datetime1 < $datetime2)
        {
            return -1;
        }
        else if($datetime1 == $datetime2)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /**
     * @param DateInterval $interval2
     * @return bool
     */
    public function lt(DateInterval$interval2)
    {
        return $this->compare($interval2) == -1 ? true : false;
    }

    /**
     * @param DateInterval $interval2
     * @return bool
     */
    public function lte(DateInterval $interval2)
    {
        switch ($this->compare($interval2))
        {
            case -1:
            case 0:
                return true;

            default:
                return false;
        }
    }

    /**
     * @param DateInterval $interval2
     * @return bool
     */
    public function eq(DateInterval$interval2)
    {
        return $this->compare($interval2) == 0 ? true : false;
    }

    /**
     * @param DateInterval $interval2
     * @return bool
     */
    public function gte(DateInterval $interval2)
    {
        switch ($this->compare($interval2))
        {
            case 0:
            case 1:
                return true;

            default:
                return false;
        }
    }

    /**
     * @param DateInterval $interval2
     * @return bool
     */
    public function gt(DateInterval$interval2)
    {
        return $this->compare($interval2) == 1 ? true : false;
    }
}