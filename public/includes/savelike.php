<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 28/09/2016
 * Time: 15:25
 */
define('ROOT', dirname(dirname(__DIR__)));
require ROOT . '/app/App.php';
App::load();


function debug($value)
{
    echo '<pre>' . print_r($value, true) . '</pre>';
}


    $auth = new \Core\Auth\Photos(App::getInstance()->getDb());
    $data = $auth->liked($_SESSION['auth'], $_POST['id'], '1');
    echo $auth->printLikes($_POST['id']);
