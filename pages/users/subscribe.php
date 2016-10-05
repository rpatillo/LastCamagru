<?PHP
echo '<h1> SUBSCRIBE </h1>';
if (!empty($_POST)) {
    if ($_POST['password'] === $_POST['passverif']) {
        $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
        if ($auth->subscribe($_POST['login'], $_POST['password'], $_POST['mail'])) {
            ?>
            <div class="alert alert-success">
                <strong>Account created.</strong> <br/>
                A mail as been sent to you.
            </div>
            <?PHP
        } else {
            ?>
            <div class="alert alert-danger">
                <strong>User already exist.</strong> <br/>
                Please, choose another Login.
            </div>
            <?PHP
        }
    } elseif ($_POST['password'] !== $_POST['passverif']) {
        ?>
        <div class="alert alert-success">
            <strong>Error.</strong> <br/>
            It seems that your password verification failled.
        </div>
        <?PHP
    }
}
$form = new \Core\HTML\BootstrapForm($_POST);
?>

<form method="post">
    <?= $form->input('login', 'Login'); ?>
    <?= $form->input('password', 'Password', ['type' => 'password']); ?>
    <?= $form->input('passverif', 'Password', ['type' => 'password']); ?>
    <?= $form->input('mail', 'Mail'); ?>
    <button>Envoyer</button>
</form>

