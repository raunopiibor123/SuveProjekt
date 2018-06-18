<?Php

/**
 * This file handles changing the raport name and description from raport view with ajax
 *
 * PHP version 5.6.30-0+deb8u1
 *
 * @category Tarkvaraarenduse_Praktika
 * @package  Roheline
 * @author   Rasmus Kello <rasmus.kello@tlu.ee>
 * @license  [https://opensource.org/licenses/MIT] [MIT]
 * @link     ...
 */

require_once "bdd.php";
$sql = "UPDATE csv set " . $_POST["column"] . " = '" . $_POST["editval"] . "' WHERE  id=" . $_POST["id"];
$query = $bdd->prepare($sql);
$sth = $query->execute();