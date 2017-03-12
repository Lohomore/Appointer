<?php
if(!defined('ALLOW_ACCESS')) exit(header('Location: /'));

class User
{
    public $database, $data;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function generateToken()
    {
        if(function_exists('random_bytes'))
        {
            return bin2hex(random_bytes(32));
        }
        else
        {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    public function login()
    {
        if(!isset($_POST['email']) || !isset($_POST['password']))
        {
            header('Location: /?error=1');
            exit();
        }

        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strlen($_POST['password']))
        {
            if($this->getUserBy('email', $_POST['email']) && password_verify($_POST['password'], $this->data['password']))
            {
                //WE MAY NOT NEED THIS UNLESS WE DECIDE TO USE COOKIES
                /*
                $token = $this->generateToken();

                $uniqueTokenQuery = $this->database->query('SELECT null FROM users WHERE token = ? LIMIT 1', $token);

                while($this->database->rowCount($uniqueTokenQuery))
                {
                    $token = $this->generateToken();
                    $uniqueTokenQuery = $this->database->query('SELECT null FROM users WHERE token = ? LIMIT 1', $token);
                }

                $tokenQuery = $this->database->query('UPDATE users SET token = ? WHERE id = ?', $token, $this->data['id']);

                //CHECK !isset($_SESSION) here
                $_SESSION["token"] = $token;
                */

                $_SESSION["id"] = $this->data['id'];

                header('Location: /home');
                exit();
            }
            else
            {
                //http_response_code(401);
                header('Location: /?error=2');
                exit();
            }
        }
        else
        {
            http_response_code(401);
            header('Location: /?error=3');
            exit();
        }
    }
    
    public function register()
    {
        if(!isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['bday']) || !isset($_POST['bmonth']) || !isset($_POST['byear']) || !isset($_POST['country']) || !isset($_POST['province']) || !isset($_POST['city']) || !isset($_POST['email']) || !isset($_POST['pass']) || !isset($_POST['confpass']))
        {
            header('Location: /?error=4');
            exit();
        }
        
        if(strlen($_POST['fname']) || strlen($_POST['lname']) || strlen($_POST['bday']) || strlen($_POST['bmonth']) || strlen($_POST['byear']) || strlen($_POST['country']) || strlen($_POST['province']) || strlen($_POST['city']) || strlen($_POST['email']) || strlen($_POST['pass']) || strlen($_POST['confpass']))
        {
            if(!strcmp($_POST['pass'], $_POST['confpass']))
            {
                $birthday = $_POST['byear'] . '-' . $_POST['bmonth'] . '-' . $_POST['bday']; //ADD DATE VALIDATION FOR SAFETY
                
                if($this->database->query('INSERT INTO users (email, password, firstname, lastname, birthday, country, province, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', $_POST['email'], password_hash($_POST['pass'], PASSWORD_DEFAULT), $_POST['fname'], $_POST['lname'], $birthday, $_POST['country'], $_POST['province'], $_POST['city']))
                {
                    $this->getUserBy('email', $_POST['email']);
                    $_SESSION["id"] = $this->data['id'];
                    
                    header('Location: /home');
                    exit();
                }
                else
                {
                    header('Location: /?error?error=5');
                    exit();
                }
            }
            else
            {
                header('Location: /?error?error=6');
                exit();
            }
        }
        else
        {
            header('Location: /?error?error=7');
            exit();
        }
    }

    public function logout()
    {
        if(isset($_SESSION["id"]))
        {
            session_destroy();
        }

        header('Location: /');
        exit();
    }
    
    public function view()
    {
        $this->getUserBy('id', $_SESSION['id']);
        
        if($this->data['rank'] == 2)
        {
            include(__DIR__ . '/../pages/html/manager_view.html');
        }
        else if($this->data['rank'] == 1)
        {
            include(__DIR__ . '/../pages/html/employee_view.html');
        }
        else
        {
            include(__DIR__ . '/../pages/html/customer_view.html');
        }
    }

    public function validateSession()
    {
        //return isset($_SESSION['token']) && $this->getUserBy('token', $_SESSION['token']);
        return isset($_SESSION['id']);
    }

    public function getUserBy($param, $value)
    {
        //if($param == 'id' || $param == 'email' || $param = 'token')
        if($param == 'id' || $param == 'email')
        {
            $userQuery = $this->database->query('SELECT * FROM users WHERE ' . $param . ' = ? LIMIT 1', $value);
        }

        if(isset($userQuery) && $this->database->rowCount($userQuery))
        {
            $userRow = $this->database->fetch($userQuery);

            foreach($userRow as $key => $data)
            {
                $this->data[$key] = $data;
            }

            return true;
        }

        unset($this->data);

        return false;
    }
}