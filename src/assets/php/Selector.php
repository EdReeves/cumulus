<?php namespace edreeves\cumulus;

require_once ('functions.php');

use \PDO;

/**
 * Selects data between two DateTimes from tables/views in the provided definition
 *
 * If a level isn't specified, the appropriate one will be selected using the definition
 *
 * @package edreeves\cumulus
 */
class Selector
{
    const INTERVAL_MAX_STR = 'P50Y';

    /** @var PDO */
    protected $db;

    /** @var array[] */
    protected $def;

    public function __construct(array $def)
    {
        $this->initDb();
        $this->def = $def;
    }

    protected function initDb()
    {
        $this->db = new PDO(PDO_CONNECT, PDO_USER, PDO_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    }

    /**
     * Retrieve the name of the appropriate level using the given DateInterval
     *
     * @param DateInterval $interval
     * @return string
     * @throws AmbiguousLevelException
     * @throws LevelNotFoundException
     */
    protected function getLevelFromInterval(DateInterval $interval)
    {
        // Retrieve levels from def that match the internal
        $match = array_filter($this->def, function ($def) use ($interval) {
            $min = array_value_default('gte', $def, new DateInterval('PT0S')); // 0 seconds
            $max = array_value_default('lt', $def, new DateInterval(static::INTERVAL_MAX_STR));
            return $interval->gte($min) && $interval->lt($max);
        });

        $count = count($match);
        if ($count === 0)
            throw new LevelNotFoundException("Error getting level from interval: No matching levels in select definition.");
        else if ($count > 1)
            throw new AmbiguousLevelException("Error getting level from interval: Found $count matching levels in selector definition.");
        else
            return array_keys($match)[0];
    }

    /**
     * Retrieve DateTime of the earliest record in the defined raw data table
     *
     * @return DateTime
     */
    protected function getMinDateTime()
    {
        $statement = $this->db->query("SELECT MIN(timestamp) AS timestamp FROM {$this->def['raw']['from']}");
        return new DateTime($statement->fetch(PDO::FETCH_ASSOC)['timestamp']);
    }

    /**
     * Retrieve DateTime of the latest record in the defined raw data table
     *
     * @return DateTime
     */
    protected function getMaxDateTime()
    {
        $statement = $this->db->query("SELECT MAX(timestamp) AS timestamp FROM {$this->def['raw']['from']}");
        return new DateTime($statement->fetch(PDO::FETCH_ASSOC)['timestamp']);
    }

    /**
     * @param DateTime|null $from DateTime to select data from, defaulting to beginning of time
     * @param DateTime|null $to DateTime to select data until, defaulting to end of time
     * @param string|null $level Override the level to select data from, defaults to appropriate for interval
     * @return array[] Array of records, in the format returned by the database
     */
    public function getData(DateTime $from = null, DateTime $to = null, string $level = null)
    {
        if ($from === null)
            $from = $this->getMinDateTime();
        if ($to === null)
            $to = $this->getMaxDateTime();
        if ($level === null)
            $level = $this->getLevelFromInterval($from->diff($to));

        $from = $from->format('Y-m-d H:i:s.ue');
        $to = $to->format('Y-m-d H:i:s.ue');

        $table = $this->def[$level]['from'];

        $sql =
            "SELECT * FROM $table WHERE timestamp ".
            "BETWEEN {$this->db->quote($from)} AND {$this->db->quote($to)}";

        $statement = $this->db->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}