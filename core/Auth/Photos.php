<?php
/**
 * Created by PhpStorm.
 * User: rpatillo
 * Date: 8/22/16
 * Time: 4:31 PM
 */

namespace Core\Auth;

use Core\Database\Database;
use \PDO;

class Photos
{
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function savePic($photo, $username) {
        if (isset($photo) && isset($username)) {
            $array = array($photo, $username);
            $req = $this->db->prepare('INSERT INTO photo VALUES ( ?, ? , NULL)', $array, NULL, false, true);
            return true;
        }
        return false;
    }

    public function printPic($username = NULL) {
        if (isset($username)) {
            $pict = $this->db->query('SELECT * FROM photo WHERE username=\''. $username . '\'');
        } else {
            $pict = $this->db->query('SELECT * FROM photo');
        }
        return $pict;
    }

    public function delPic($id) {
        $this->db->query('DELETE FROM photo where id=\'' . $id . '\'');
    }

    public function saveCom($com, $username, $id_photo) {
        $array = array($com, $username, $id_photo);
        $this->db->prepare('INSERT INTO comments VALUES (?, ?, ?)', $array, NULL, false, true);
    }

    public function printCom($id) {
        return $this->db->query('SELECT * FROM comments WHERE id=\'' . $id . '\'');
    }

    public function liked($username, $id_photo, $ret = NULL) {
        $user = $this->db->prepare('SELECT * FROM likes WHERE username = ? AND id_photo = ?', [$username, $id_photo], NULL, true);
        if (!$user) {
            $array = array($username, '1', $id_photo);
            $this->db->prepare('INSERT INTO likes VALUES ( ?, ?, ?)', $array);
        }
    }

    public function printLikes($id_photo) {
        return $this->db->query('SELECT COUNT(*) FROM likes WHERE id_photo=\'' . $id_photo . '\'', 'count');
    }
}