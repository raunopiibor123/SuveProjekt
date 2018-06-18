<?php

/**
 * This file contains functions
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rauno Piibor
 * @author   Hendrik Heinsar
 * @author   Elinor Roosalu
 * @author   Krister Riska
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

//sisestuse kontrollimine
function test_input($data)
{
    $data = trim($data); //eemaldab lõpust tühiku, tab vms
    $data = stripslashes($data); //eemaldab "\"
    $data = htmlspecialchars($data); //eemaldab keelatud märgid
    return $data;
}
