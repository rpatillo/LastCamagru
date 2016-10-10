<?PHP
if (!empty($_POST)) {
    $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
    if ($_POST['password'] === $_POST['verif_pass']) {
        if ($auth->subscribe($_POST['login'], $_POST['password'], $_POST['mail'])) {
            ?>
            <div>
                <strong>Account created.</strong> <br/>
                A mail as been sent to you.
            </div>
            <?PHP
        } else {
            ?>
            <div>
                <strong>Oh snap !</strong> <br/>
                Something was wrong.
                Be sure to pick 1 uppercase letter, 1 lowercase letter and 1 digit.
            </div>
            <?PHP
        }
    } else {
        ?>
            <div>
                <strong>Mail doesn't correspond.</strong> <br />
                Please, verify your password
            </div>
        <?PHP
    }
}
$form = new \Core\HTML\BootstrapForm($_POST);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-6"><img src="img/home_photo.png" alt="home_photo" height=80% width=80%></div>
        <div class="col-xs-6">
            <h1>Camagru</h1>
            <h3>Create an account and take / share pictures !</h3>
            <form method="post">
                <?= $form->input('login', 'Username '); ?>
                <?= $form->input('password', 'Password ', ['type' => 'password']); ?>
                <?= $form->input('verif_pass', 'Password Verification ', ['type' => 'password']); ?>
                <?= $form->input('mail', 'Mail '); ?>
                <button>Subscribe</button>
            </form> <br />
            Already got an account ? <a href="index.php?p=login">Log in.</a><br />
            <a href="index.php?p=reset">Lost password ?</a><br />
        </div>
    </div>
    <br />
</div>