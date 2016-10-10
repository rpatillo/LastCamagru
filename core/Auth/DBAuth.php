<?PHP

namespace Core\Auth;

use Core\Database\Database;
use \PDO;

class DBAuth {

    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getUserId() {
        if ($this->logged()) {
            return $_SESSION['auth'];
        }
        return false;
    }

    public function logout() {
        if ($this->logged()) {
            unset($_SESSION['auth']);
            return true;
        }    
        return false;
    }
    
    /**
     * @param $login
     * @param $password
     * @param $email
     */
    public function subscribe($login, $password, $email) {
        if ($this->checkPass($password) === true) {
            $temp = $this->random();
            $hash = hash('whirlpool', $password);
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                return false;
            }
            $array = array($login, $hash, $email, $temp, 0);
            $user = $this->db->prepare('SELECT * FROM users WHERE username = ?', [$login], NULL, true);
            if (!$user) {
                $this->db->prepare('INSERT INTO users VALUES ( ?, ?, ?, ?, ?, NULL)', $array, NULL, false, true);
                $body = 'Please, validate your account by clicking on this link : http://localhost:8080/index.php?p=validate&u=' . $login . '&t=' . $temp;
                $this->mail($login, $email, $body, $subject);
                return true;
            }
        }
        return false;
    }

    public function isValid($login, $token = NULL, $ask = NULL) {
        if ($ask === NULL) {
            $array = array($login, $token);
            $ret = $this->db->prepare('SELECT * FROM users WHERE username=? AND hashKey=?', $array, NULL, true);
            if ($ret) {
                $this->db->query('UPDATE users SET is_valid=1 WHERE username=\'' . $login . '\'');
                echo 'You\' successfully registered to Camagru ! Welcome !';
            } else {
                echo 'Something went wrong...';
            }
        } else {
            $ret = $this->db->prepare('SELECT * FROM users WHERE username=? AND is_valid=1', [$login], NULL, true);
            if ($ret)
                return true;
            else
                return false;
        }
    }

    public function mail($login, $mail, $body = NULL, $subject = NULL) {
        if ($subject === NULL) {
            $subject = "Registration Camagru";
        }
        if ($body === NULL) {
            $body = "You've successfully registered on Camagru. This website allows you to take and share pictures. Enjoy your day !";
        }
        $headers = "Hi $login.";
        mail($mail, $subject, $body, $headers);
    }

    public function getMail($login) {
        return $this->db->query('SELECT mail FROM users WHERE username=\'' . $login . '\'');
    }


    /**
     * @param $username
     * @param $password
     * @return boolean
     */
    public function login($username, $password) {
        $user = $this->db->prepare('SELECT * FROM users Where username = ?', [$username], NULL, true);
        if ($user) {
            if ($user->password === hash('whirlpool', $password)) {
                $_SESSION['auth'] = $user->username;
                return true;
            }
        }
        return false;
    }

    public function random() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return (implode($pass)); //turn the array into a string
    }

    public function resetPass($login) {
        $temppass = $this->random();
        $body = 'Your new password is ' . $temppass . ' consider changing it quickly !';
        $subject = 'You\'ve juste reset your password.';
        $mail = $this->getMail($login);
        $mail = $mail[0]->mail;
        $this->mail($login, $mail, $body, $subject);
        $hash = hash('whirlpool', $temppass);
        $this->db->query('UPDATE users SET password=\'' . $hash . '\' WHERE username=\'' . $login . '\'');
        return true;
    }

    public function changePass($login, $o_pass, $n_pass) {
        $user = $this->db->prepare('SELECT * FROM users Where username = ?', [$login], NULL, true);
        if ($user) {
            if ($user->password === hash('whirlpool', $o_pass)) {
                $hash = hash('whirlpool', $n_pass);
                $this->db->query('UPDATE users SET password=\'' . $hash . '\' WHERE username=\'' . $login . '\'');
                return true;
            }
        }
    }

    public function logged() {
        return isset($_SESSION['auth']);
    }

    public function checkPass($pass) {
        if ((preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/', $pass) != 1) || empty($pass)) {
            return false;
        }
        return true;
    }

}