<?php

/**
 * This file handles the database connection
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

try
{
    $bdd = new PDO('mysql:host=localhost:8889;dbname=if17_roheline;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Error : ' . $e->getMessage());
}
