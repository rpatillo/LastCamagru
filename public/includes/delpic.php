<?php
/**
 * Created by PhpStorm.
 * User: rpatillo
 * Date: 10/4/16
 * Time: 12:53 PM
 */

define('ROOT', dirname(dirname(__DIR__)));
require ROOT . '/app/App.php';
App::load();
$auth = new \Core\Auth\Photos(App::getInstance()->getDb());

$auth->delPic($_POST['id']);

$result = $auth->printPic($_SESSION['auth']);
echo '<br />';
foreach ($result as $post) {
    echo '<img src="' . $post->photo . '" name="onclick_del" id="'. $post->id . '" />';
}