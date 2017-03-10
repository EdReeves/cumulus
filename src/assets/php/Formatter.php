<?php namespace edreeves\cumulus;

/**
 * Formats associative array format data returned from a PDO statement using the
 * provided definition
 *
 * If no callback is defined for a field, it is not reformatted
 *
 * @package edreeves\cumulus
 */
class Formatter
{
    /** @var array */
    protected $def;

    public function __construct(array $def)
    {
        $this->def = $def;
    }

    /**
     * @param array $data
     * @return array
     */
    public function formatRecord(array $data)
    {
        foreach ($data as $field => &$value)
            if ($callback = array_value_default($field, $this->def, false))
                $value = call_user_func($callback, $value);

        return $data;
    }

    /**
     * @param array[] $data
     * @return array[]
     */
    public function formatTable(array $data)
    {
        return array_map(function ($record) { return $this->formatRecord($record); }, $data);
    }
}