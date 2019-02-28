<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 17/5/8
 * Time: 下午6:38
 */

include '../config/config.php';
$input = file_get_contents("php://input");

each($input);