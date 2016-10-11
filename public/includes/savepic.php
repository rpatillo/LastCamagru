<?php
/**
 * Created by PhpStorm.
 * User: rpatillo
 * Date: 8/19/16
 * Time: 2:32 PM
 */


define('ROOT', dirname(dirname(__DIR__)));
//date_default_timezone_set('Europe/Paris');

    require ROOT . '/app/App.php';
    App::load();
    $auth = new \Core\Auth\Photos(App::getInstance()->getDb());

    $tmp = $_POST['photo'];
    $tmp = str_replace('data:image/png;base64,', '', $tmp);
    $tmp = base64_decode($tmp);
    $im = imagecreatefromstring($tmp);


    $stmp = imagecreatefrompng(ROOT . '/public/img/photo.png');
    $temp = ROOT . '/public/img/photo.png';
    if ($_POST['nb'] === '1') {
        $stmp = imagecreatefrompng(ROOT . '/public/img/photo.png');
        $temp = ROOT . '/public/img/photo.png';
    } elseif ($_POST['nb'] === '2') {
        $stmp = imagecreatefrompng(ROOT . '/public/img/hat.png');
        $temp = ROOT . '/public/img/hat.png';
    } elseif ($_POST['nb'] === '3') {
        $stmp = imagecreatefrompng(ROOT . '/public/img/Eyes.png');
        $temp = ROOT . '/public/img/Eyes.png';
    }

    $marginX = $_POST['mX'];
    $marginY = $_POST['mY'];
    $sx = imagesx(imagecreatefrompng($temp));
    $sy = imagesy(imagecreatefrompng($temp));

    imagecopy($im, $temp, imagesx($im) - $sx - $marginX, imagesy($im) - $sy - $marginY, 0, 0, $sx, $sy);

    ob_start();
        imagepng($im);
        $image_data = ob_get_contents();
    ob_end_clean();

    $test = base64_encode($image_data);

    if ($auth->savePic('data:image/png;base64,' . $test, $_SESSION['auth'], NULL)) {
        $result = $auth->printPic($_SESSION['auth']);
        echo '<br />';
        foreach ($result as $post) {
            echo '<img src="' . $post->photo . '" name="onclick_del" id="' . $post->id . '" />';
        }
    } else {
        echo 'Something went terribly wrong ...';
    }

