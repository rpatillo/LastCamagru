<?PHP
    $auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());
    $auth->logout();
    echo "You've successfully logout. Wait to be redirected to home page. <br />";
    echo "Good day !";
    header('Refresh: 5; url=index.php');
