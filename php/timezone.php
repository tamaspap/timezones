<?php
/*
 * @package		Timezone Detect
 * @author      Pap Tamas
 * @copyright   (c) 2013 Pap Tamas
 * @website		https://github.com/paptamas/timezones
 * @license		http://opensource.org/licenses/MIT
 *
 */
class Timezone  {

    /**
     * Get the timezone list
     *
     * @return  array
     */
    public static function get_timezone_list()
    {
        return require 'timezone_list.php';
    }

    /**
     * Detect the timezone id(s) from an offset and dst
     *
     * @param   int     $offset
     * @param   int     $dst
     * @param   bool    $multiple
     * @param   string  $default
     * @return  string|array
     */
    public static function detect_timezone_id($offset, $dst, $multiple = FALSE, $default = 'UTC')
    {
        $detected_timezone_ids = array();

        // Get the timezone list
        $timezones = self::get_timezone_list();

        // Try to find a timezone for which both the offset and dst match
        foreach ($timezones as $timezone_id)
        {
            $timezone_data = self::get_timezone_data($timezone_id);
            if ($timezone_data['offset'] == $offset && $dst == $timezone_data['dst'])
            {
                array_push($detected_timezone_ids, $timezone_id);
                if ( ! $multiple)
                    break;
            }
        }

        if (empty($detected_timezone_ids))
        {
            $detected_timezone_ids = array($default);
        }

        return $multiple ? $detected_timezone_ids : $detected_timezone_ids[0];
    }

    /**
     * Get the current offset and dst for the given timezone id
     *
     * @param   string  $timezone_id
     * @return  int
     */
    public static function get_timezone_data($timezone_id)
    {
        $date = new DateTime("now");
        $date->setTimezone(timezone_open($timezone_id));

        return array(
            'offset' => $date->getOffset() / 3600,
            'dst' => intval(date_format($date, "I"))
        );
    }
}

// END Timezone
