<?php
/*
 * @package		Timezone Detect
 * @author      Pap Tamas
 * @copyright   (c) 2013 Pap Tamas
 * @website		https://github.com/paptamas/timezone-detect
 * @license		http://opensource.org/licenses/MIT
 *
 */

require './php/timezone.php';

if ( ! isset($_POST['offset']) || ! isset($_POST['dst']))
{
	die('Invalid request.');
}

$offset = $_POST['offset'];
$dst = $_POST['dst'];

echo json_encode(Timezone::detect_timezone_id($offset, $dst));
