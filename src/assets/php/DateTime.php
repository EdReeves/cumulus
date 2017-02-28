<?php namespace edreeves\cumulus;

class DateTime extends \alroniks\dtms\DateTime
{
    public function diff($datetime2, $absolute = false)
    {
        $interval = new DateInterval('PT0.000000S');

        foreach (get_object_vars(parent::diff($datetime2, $absolute)) as $property => $value)
        {
            $interval->{$property} = $value;
        }

        return $interval;
    }
}