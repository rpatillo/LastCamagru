<?PHP
//phpinfo();


define('ROOT', dirname(__DIR__));
//date_default_timezone_set('Europe/Paris');

require ROOT . '/app/App.php';
App::load();

$auth = new \Core\Auth\DBAuth(App::getInstance()->getDb());

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'home';
}

ob_start();
if (isset($_SESSION['auth']) && $auth->isValid($_SESSION['auth'], NULL, 1)) {
    if ($page === 'home') {
        require ROOT . '/pages/posts/home.php';
    } elseif ($page === 'posts.category') {
        require ROOT . '/pages/posts/category.php';
    } elseif ($page === 'posts.show') {
        require ROOT . '/pages/posts/show.php';
    } elseif ($page === 'login') {
        require ROOT . '/pages/users/login.php';
    } elseif ($page === 'subscribe') {
        require ROOT . '/pages/users/subscribe.php';
    } elseif ($page === 'photo') {
        require ROOT . '/pages/users/photo.php';
    } elseif ($page === 'logout') {
        require ROOT . '/pages/users/logout.php';
    }  elseif ($page === 'reset') {
        require ROOT . '/pages/users/reset.php';
    } elseif ($page === 'gallery') {
        require ROOT . '/pages/users/gallery.php';
    }
}  else {
    if ($page === 'home') {
        require ROOT . '/pages/posts/home.php';
    } elseif ($page === 'login') {
        require ROOT . '/pages/users/login.php';
    } elseif ($page === 'reset') {
        require ROOT . '/pages/users/reset.php';
    } elseif ($page === 'subscribe') {
        require ROOT . '/pages/users/subscribe.php';
    } elseif ($page === 'gallery') {
        require ROOT . '/pages/users/gallery.php';
    } elseif ($page === 'validate') {
        require ROOT . '/pages/users/validate.php';
    } elseif ($page === 'logout') {
        require ROOT . '/pages/users/logout.php';
    }
}
$content = ob_get_clean();
require ROOT . '/pages/template/default.php';
