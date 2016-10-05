<?php
/**
 * Created by PhpStorm.
 * User: rpatillo
 * Date: 10/5/16
 * Time: 12:58 PM
 */

echo '<h1> RESET </h1>';
if (!empty($_POST)) {
    $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
    if (isset($_POST['login'])) {
        $auth->resetPass($_POST['login']);
        echo 'New password sent.';
    } else if (isset($_POST['login_reset']) && isset($_POST['old_pass']) && isset($_POST['new_pass'])) {
        $auth->changePass($_POST['login_reset'], $_POST['old_pass'], $_POST['new_pass']);
        echo 'New password set !';
    }
}
$form = new \Core\HTML\BootstrapForm($_POST);
?>

<h1>Please, fill your information. A mail with a new password will be sent.</h1>
<form method="post">
    <?= $form->input('login', 'Login '); ?>
    <button>Envoyer</button>
</form>
<br />


-------------------------------------------

<h1>To change your password, please, fill this form.</h1>
<form method="post">
    <?= $form->input('login_reset', 'Login'); ?>
    <?= $form->input('old_pass', 'Old Password ', ['type' => 'password']); ?>
    <?= $form->input('new_pass', 'New Password ', ['type' => 'password']); ?>
    <button>Envoyer</button>
</form>