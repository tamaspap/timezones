Detecting and working with timezones in PHP
===========================================

When you are developing a web app, a problem you will definitely have to solve is **timezones**.
Your users are from different countries and regions and you have to display dates and times for them accordingly.

In this article I will briefly present how I solved the *timezone* problem for our upcoming project [sketchsim.com](http://www.sketchsim.com).

## Detecting the user’s timezone automatically
The easiest way to get the user's timezone is probably to let him choose it from a dropdown. However, because we wanted to make the signup process as simple as possible, we decided to detect it automatically (the user can change it later on his profile/settings page).

The very first thing we need is a user-friendly timezone list.
Here is the list we use, and believe me, it was a time and coffee consuming task to put this together.

### timezone_list.php

    return array (
        '(UTC-11:00) Midway Island' => 'Pacific/Midway',
        '(UTC-11:00) Samoa' => 'Pacific/Samoa',
        '(UTC-10:00) Hawaii' => 'Pacific/Honolulu',
        '(UTC-09:00) Alaska' => 'US/Alaska',
        '(UTC-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
        '(UTC-08:00) Tijuana' => 'America/Tijuana',
        '(UTC-07:00) Arizona' => 'US/Arizona',
        '(UTC-07:00) Chihuahua' => 'America/Chihuahua',
        '(UTC-07:00) La Paz' => 'America/Chihuahua',
        '(UTC-07:00) Mazatlan' => 'America/Mazatlan',
        '(UTC-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
        '(UTC-06:00) Central America' => 'America/Managua',
        '(UTC-06:00) Central Time (US &amp; Canada)' => 'US/Central',
        '(UTC-06:00) Guadalajara' => 'America/Mexico_City',
        '(UTC-06:00) Mexico City' => 'America/Mexico_City',
        '(UTC-06:00) Monterrey' => 'America/Monterrey',
        '(UTC-06:00) Saskatchewan' => 'Canada/Saskatchewan',
        '(UTC-05:00) Bogota' => 'America/Bogota',
        '(UTC-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
        '(UTC-05:00) Indiana (East)' => 'US/East-Indiana',
        '(UTC-05:00) Lima' => 'America/Lima',
        '(UTC-05:00) Quito' => 'America/Bogota',
        '(UTC-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
        '(UTC-04:30) Caracas' => 'America/Caracas',
        '(UTC-04:00) La Paz' => 'America/La_Paz',
        '(UTC-04:00) Santiago' => 'America/Santiago',
        '(UTC-03:30) Newfoundland' => 'Canada/Newfoundland',
        '(UTC-03:00) Brasilia' => 'America/Sao_Paulo',
        '(UTC-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(UTC-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(UTC-03:00) Greenland' => 'America/Godthab',
        '(UTC-02:00) Mid-Atlantic' => 'America/Noronha',
        '(UTC-01:00) Azores' => 'Atlantic/Azores',
        '(UTC-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(UTC+00:00) Casablanca' => 'Africa/Casablanca',
        '(UTC+00:00) Edinburgh' => 'Europe/London',
        '(UTC+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
        '(UTC+00:00) Lisbon' => 'Europe/Lisbon',
        '(UTC+00:00) London' => 'Europe/London',
        '(UTC+00:00) Monrovia' => 'Africa/Monrovia',
        '(UTC+00:00) UTC' => 'UTC',
        '(UTC+01:00) Amsterdam' => 'Europe/Amsterdam',
        '(UTC+01:00) Belgrade' => 'Europe/Belgrade',
        '(UTC+01:00) Berlin' => 'Europe/Berlin',
        '(UTC+01:00) Bern' => 'Europe/Berlin',
        '(UTC+01:00) Bratislava' => 'Europe/Bratislava',
        '(UTC+01:00) Brussels' => 'Europe/Brussels',
        '(UTC+01:00) Budapest' => 'Europe/Budapest',
        '(UTC+01:00) Copenhagen' => 'Europe/Copenhagen',
        '(UTC+01:00) Ljubljana' => 'Europe/Ljubljana',
        '(UTC+01:00) Madrid' => 'Europe/Madrid',
        '(UTC+01:00) Paris' => 'Europe/Paris',
        '(UTC+01:00) Prague' => 'Europe/Prague',
        '(UTC+01:00) Rome' => 'Europe/Rome',
        '(UTC+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(UTC+01:00) Skopje' => 'Europe/Skopje',
        '(UTC+01:00) Stockholm' => 'Europe/Stockholm',
        '(UTC+01:00) Vienna' => 'Europe/Vienna',
        '(UTC+01:00) Warsaw' => 'Europe/Warsaw',
        '(UTC+01:00) West Central Africa' => 'Africa/Lagos',
        '(UTC+01:00) Zagreb' => 'Europe/Zagreb',
        '(UTC+02:00) Athens' => 'Europe/Athens',
        '(UTC+02:00) Bucharest' => 'Europe/Bucharest',
        '(UTC+02:00) Cairo' => 'Africa/Cairo',
        '(UTC+02:00) Harare' => 'Africa/Harare',
        '(UTC+02:00) Helsinki' => 'Europe/Helsinki',
        '(UTC+02:00) Istanbul' => 'Europe/Istanbul',
        '(UTC+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(UTC+02:00) Kyiv' => 'Europe/Helsinki',
        '(UTC+02:00) Pretoria' => 'Africa/Johannesburg',
        '(UTC+02:00) Riga' => 'Europe/Riga',
        '(UTC+02:00) Sofia' => 'Europe/Sofia',
        '(UTC+02:00) Tallinn' => 'Europe/Tallinn',
        '(UTC+02:00) Vilnius' => 'Europe/Vilnius',
        '(UTC+03:00) Baghdad' => 'Asia/Baghdad',
        '(UTC+03:00) Kuwait' => 'Asia/Kuwait',
        '(UTC+03:00) Minsk' => 'Europe/Minsk',
        '(UTC+03:00) Nairobi' => 'Africa/Nairobi',
        '(UTC+03:00) Riyadh' => 'Asia/Riyadh',
        '(UTC+03:00) Volgograd' => 'Europe/Volgograd',
        '(UTC+03:30) Tehran' => 'Asia/Tehran',
        '(UTC+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(UTC+04:00) Baku' => 'Asia/Baku',
        '(UTC+04:00) Moscow' => 'Europe/Moscow',
        '(UTC+04:00) Muscat' => 'Asia/Muscat',
        '(UTC+04:00) St. Petersburg' => 'Europe/Moscow',
        '(UTC+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(UTC+04:00) Yerevan' => 'Asia/Yerevan',
        '(UTC+04:30) Kabul' => 'Asia/Kabul',
        '(UTC+05:00) Islamabad' => 'Asia/Karachi',
        '(UTC+05:00) Karachi' => 'Asia/Karachi',
        '(UTC+05:00) Tashkent' => 'Asia/Tashkent',
        '(UTC+05:30) Chennai' => 'Asia/Calcutta',
        '(UTC+05:30) Kolkata' => 'Asia/Kolkata',
        '(UTC+05:30) Mumbai' => 'Asia/Calcutta',
        '(UTC+05:30) New Delhi' => 'Asia/Calcutta',
        '(UTC+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
        '(UTC+05:45) Kathmandu' => 'Asia/Katmandu',
        '(UTC+06:00) Almaty' => 'Asia/Almaty',
        '(UTC+06:00) Astana' => 'Asia/Dhaka',
        '(UTC+06:00) Dhaka' => 'Asia/Dhaka',
        '(UTC+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(UTC+06:30) Rangoon' => 'Asia/Rangoon',
        '(UTC+07:00) Bangkok' => 'Asia/Bangkok',
        '(UTC+07:00) Hanoi' => 'Asia/Bangkok',
        '(UTC+07:00) Jakarta' => 'Asia/Jakarta',
        '(UTC+07:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(UTC+08:00) Beijing' => 'Asia/Hong_Kong',
        '(UTC+08:00) Chongqing' => 'Asia/Chongqing',
        '(UTC+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(UTC+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(UTC+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
        '(UTC+08:00) Perth' => 'Australia/Perth',
        '(UTC+08:00) Singapore' => 'Asia/Singapore',
        '(UTC+08:00) Taipei' => 'Asia/Taipei',
        '(UTC+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
        '(UTC+08:00) Urumqi' => 'Asia/Urumqi',
        '(UTC+09:00) Irkutsk' => 'Asia/Irkutsk',
        '(UTC+09:00) Osaka' => 'Asia/Tokyo',
        '(UTC+09:00) Sapporo' => 'Asia/Tokyo',
        '(UTC+09:00) Seoul' => 'Asia/Seoul',
        '(UTC+09:00) Tokyo' => 'Asia/Tokyo',
        '(UTC+09:30) Adelaide' => 'Australia/Adelaide',
        '(UTC+09:30) Darwin' => 'Australia/Darwin',
        '(UTC+10:00) Brisbane' => 'Australia/Brisbane',
        '(UTC+10:00) Canberra' => 'Australia/Canberra',
        '(UTC+10:00) Guam' => 'Pacific/Guam',
        '(UTC+10:00) Hobart' => 'Australia/Hobart',
        '(UTC+10:00) Melbourne' => 'Australia/Melbourne',
        '(UTC+10:00) Port Moresby' => 'Pacific/Port_Moresby',
        '(UTC+10:00) Sydney' => 'Australia/Sydney',
        '(UTC+10:00) Yakutsk' => 'Asia/Yakutsk',
        '(UTC+11:00) Vladivostok' => 'Asia/Vladivostok',
        '(UTC+12:00) Auckland' => 'Pacific/Auckland',
        '(UTC+12:00) Fiji' => 'Pacific/Fiji',
        '(UTC+12:00) International Date Line West' => 'Pacific/Kwajalein',
        '(UTC+12:00) Kamchatka' => 'Asia/Kamchatka',
        '(UTC+12:00) Magadan' => 'Asia/Magadan',
        '(UTC+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(UTC+12:00) New Caledonia' => 'Asia/Magadan',
        '(UTC+12:00) Solomon Is.' => 'Asia/Magadan',
        '(UTC+12:00) Wellington' => 'Pacific/Auckland',
        '(UTC+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
    );

To detect the user's timezone we need to:

1. Get the user’s timezone offset (javascript)
2. Detect if daylight saving time (DST) is in effect at the moment (javascript)
3. Submit these information to the server, and find the appropriate php timezone identifier based on them (php).

Our javascript function (inspired by [this article](http://javascript.about.com/library/bldst.htm)) is the following:

### timezone.js

    var getTimeZoneData = function() {
      var today = new Date();
      var jan = new Date(today.getFullYear(), 0, 1);
      var jul = new Date(today.getFullYear(), 6, 1);
      var dst = today.getTimezoneOffset() < Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());

      return {
        timezone_offset: -(today.getTimezoneOffset()/60),
        timezone_dst: +dst
      };
    }

And finally the PHP class, I use for finding the appropriate timezone identifier based on the time zone offset and dst:

### timezone.php

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


After detecting the appopriate timezone identifier for the user, we can save it to the database along with other user related data (username, password, etc.).
Next time the user logs in, we can load his timezone identifier to the $_SESSION array. This way, any time we need to display a time or date for the user we [can convert it to his timezone first](http://stackoverflow.com/q/2505681/240324).

## Let the user choose his timezone

It is worth mentioning that for some users, multiple timezones can work. For example, I'm living in Hungary, so my timezone is `Europe/Budapest`, but the script will detect `Europe/Amsterdam` for me. They are both correct, and will work properly. However, it's recommended to make it possible for your users to change their timezones manually (for example on their profile/settings page).

Based on the `timezone_list.php` file is very easy to generate a html dropdown the user can choose from:

    <select class="auth-input" id="timezone" name="timezone">
        <option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
        <option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
        <option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
        <option value="US/Alaska">(UTC-09:00) Alaska</option>
        <option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
        <option value="America/Tijuana">(UTC-08:00) Tijuana</option>
        <option value="US/Arizona">(UTC-07:00) Arizona</option>
        <option value="America/Chihuahua">(UTC-07:00) Chihuahua</option>
        <option value="America/Chihuahua">(UTC-07:00) La Paz</option>
        <option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
        <option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
        <option value="America/Managua">(UTC-06:00) Central America</option>
        <option value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
        <option value="America/Mexico_City">(UTC-06:00) Guadalajara</option>
        <option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
        <option value="America/Monterrey">(UTC-06:00) Monterrey</option>
        <option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
        <option value="America/Bogota">(UTC-05:00) Bogota</option>
        <option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
        <option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
        <option value="America/Lima">(UTC-05:00) Lima</option>
        <option value="America/Bogota">(UTC-05:00) Quito</option>
        <option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
        <option value="America/Caracas">(UTC-04:30) Caracas</option>
        <option value="America/La_Paz">(UTC-04:00) La Paz</option>
        <option value="America/Santiago">(UTC-04:00) Santiago</option>
        <option value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
        <option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
        <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Buenos Aires</option>
        <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown</option>
        <option value="America/Godthab">(UTC-03:00) Greenland</option>
        <option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
        <option value="Atlantic/Azores">(UTC-01:00) Azores</option>
        <option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
        <option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
        <option value="Europe/London">(UTC+00:00) Edinburgh</option>
        <option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
        <option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
        <option value="Europe/London">(UTC+00:00) London</option>
        <option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
        <option value="UTC">(UTC+00:00) UTC</option>
        <option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
        <option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
        <option value="Europe/Berlin">(UTC+01:00) Berlin</option>
        <option value="Europe/Berlin">(UTC+01:00) Bern</option>
        <option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
        <option value="Europe/Brussels">(UTC+01:00) Brussels</option>
        <option value="Europe/Budapest">(UTC+01:00) Budapest</option>
        <option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
        <option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
        <option value="Europe/Madrid">(UTC+01:00) Madrid</option>
        <option value="Europe/Paris">(UTC+01:00) Paris</option>
        <option value="Europe/Prague">(UTC+01:00) Prague</option>
        <option value="Europe/Rome">(UTC+01:00) Rome</option>
        <option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
        <option value="Europe/Skopje">(UTC+01:00) Skopje</option>
        <option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
        <option value="Europe/Vienna">(UTC+01:00) Vienna</option>
        <option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
        <option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
        <option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
        <option value="Europe/Athens">(UTC+02:00) Athens</option>
        <option value="Europe/Bucharest" selected="selected">(UTC+02:00) Bucharest</option>
        <option value="Africa/Cairo">(UTC+02:00) Cairo</option>
        <option value="Africa/Harare">(UTC+02:00) Harare</option>
        <option value="Europe/Helsinki">(UTC+02:00) Helsinki</option>
        <option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
        <option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
        <option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
        <option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
        <option value="Europe/Riga">(UTC+02:00) Riga</option>
        <option value="Europe/Sofia">(UTC+02:00) Sofia</option>
        <option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
        <option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
        <option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
        <option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
        <option value="Europe/Minsk">(UTC+03:00) Minsk</option>
        <option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
        <option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
        <option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
        <option value="Asia/Tehran">(UTC+03:30) Tehran</option>
        <option value="Asia/Muscat">(UTC+04:00) Abu Dhabi</option>
        <option value="Asia/Baku">(UTC+04:00) Baku</option>
        <option value="Europe/Moscow">(UTC+04:00) Moscow</option>
        <option value="Asia/Muscat">(UTC+04:00) Muscat</option>
        <option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
        <option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
        <option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
        <option value="Asia/Kabul">(UTC+04:30) Kabul</option>
        <option value="Asia/Karachi">(UTC+05:00) Islamabad</option>
        <option value="Asia/Karachi">(UTC+05:00) Karachi</option>
        <option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
        <option value="Asia/Calcutta">(UTC+05:30) Chennai</option>
        <option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
        <option value="Asia/Calcutta">(UTC+05:30) Mumbai</option>
        <option value="Asia/Calcutta">(UTC+05:30) New Delhi</option>
        <option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
        <option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
        <option value="Asia/Almaty">(UTC+06:00) Almaty</option>
        <option value="Asia/Dhaka">(UTC+06:00) Astana</option>
        <option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
        <option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
        <option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
        <option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
        <option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
        <option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
        <option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
        <option value="Asia/Hong_Kong">(UTC+08:00) Beijing</option>
        <option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
        <option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
        <option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
        <option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
        <option value="Australia/Perth">(UTC+08:00) Perth</option>
        <option value="Asia/Singapore">(UTC+08:00) Singapore</option>
        <option value="Asia/Taipei">(UTC+08:00) Taipei</option>
        <option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
        <option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
        <option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
        <option value="Asia/Tokyo">(UTC+09:00) Osaka</option>
        <option value="Asia/Tokyo">(UTC+09:00) Sapporo</option>
        <option value="Asia/Seoul">(UTC+09:00) Seoul</option>
        <option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
        <option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
        <option value="Australia/Darwin">(UTC+09:30) Darwin</option>
        <option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
        <option value="Australia/Canberra">(UTC+10:00) Canberra</option>
        <option value="Pacific/Guam">(UTC+10:00) Guam</option>
        <option value="Australia/Hobart">(UTC+10:00) Hobart</option>
        <option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
        <option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
        <option value="Australia/Sydney">(UTC+10:00) Sydney</option>
        <option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
        <option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
        <option value="Pacific/Auckland">(UTC+12:00) Auckland</option>
        <option value="Pacific/Fiji">(UTC+12:00) Fiji</option>
        <option value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
        <option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
        <option value="Asia/Magadan">(UTC+12:00) Magadan</option>
        <option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
        <option value="Asia/Magadan">(UTC+12:00) New Caledonia</option>
        <option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
        <option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
        <option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
    </select>


## Demo

[See it in action](http://php-timezone.gopagoda.com/).

## Feedback

If you find a bug or have an idea to make this code better feel free to [open an issue](https://github.com/paptamas/timezones/issues), or [create a pull request](https://github.com/paptamas/timezones/pulls).

## Licence

This software is licenced under  the [MIT licence](http://opensource.org/licenses/MIT).
