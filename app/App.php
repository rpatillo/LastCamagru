<?PHP

use Core\Config;
use Core\Database\SqliteDatabase;

class App {

    private static $_instance;
    private $db_instance;

    public $title = 'Camagru';

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load() {
        session_start();
        require ROOT .'/app/Autoloader.php';
        App\Autoloader::register();
        require ROOT . '/core/Autoloader.php';
        Core\Autoloader::register();

    }

    public function getTable($name) {
        $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
        return new $class_name($this->getDb());
    }

    public function getDb() {
        $config = Config::getInstance(ROOT . '/config/config.php');
        if (is_null($this->db_instance)) {
            return new SqliteDatabase($config->get('db_name'));
        }
    }

    public function forbidden() {
        header('HTTP/1.0 403 Forbidden');
        die ('Acces interdit');
    }

    public function notFound() {
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable');
    }

    public static function getTitle() {
        return self::$title;
    }
}