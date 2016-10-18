<?php
/**
 * Created by PhpStorm.
 * User: rpatillo
 * Date: 9/22/16
 * Time: 3:10 PM
 */

define('ROOT', dirname(dirname(__DIR__)));

require ROOT . '/app/App.php';
App::load();

function debug($value)
{
    echo '<pre>' . print_r($value, true) . '</pre>';
}

function RetCom($id) {
    $auth = new \Core\Auth\Photos(App::getInstance()->getDb());
    $com = $auth->printCom($_POST['id']);
    foreach ($com as $posts) {
        echo '<tr>';
        echo '<td><strong>' . $posts->username . ' :</strong></td>';
        echo '<td>' . $posts->comment . '</td>';
        echo '</tr>';
    }
}

if (!empty($_POST) && !empty($_POST['t'])) {
    $auth = new \Core\Auth\Photos(App::getInstance()->getDb());
    $auth2 = new \Core\Auth\DBAuth(App::getInstance()->getDb());
    $tmp = strip_tags($_POST['t']);
    $auth->saveCom($tmp, $_POST['u'], $_POST['id']);
    $mail = $auth2->getMail($_POST['o']);
    $mail = $mail[0]->mail;
    $body = 'Hi ! Your photo as received a comments.';
    $auth2->mail($_POST['o'], $mail, $body, 'New comments from ' . $_POST['u']);
}

return RetCom($_POST['id']);