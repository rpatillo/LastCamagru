<?PHP
namespace App\Table;

use App\App;

class Table {

    public static function find($id) {
        return static::query("
                    SELECT *
                    FROM " . static::$table . "
                    WHERE id = ?
                ", [$id], true);
    }

    public static function query($stmt, $attributes = NULL, $one = false) {
        if ($attributes) {
            return App::getDb()->prepare($stmt, $attributes, get_called_class(), $one); 
        } else {
            return App::getDb()->query($stmt, get_called_class(), $one); 
        }
    }

    public function __get($key) {
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }

    public static function all() {
        return App::getDb()->query("
                    SELECT *
                    FROM " . static::$table . "
                ", get_called_class()); 
    }
}