<?php
if(!defined('ALLOW_ACCESS')) exit(header('Location: /'));

class Core
{
    private $config, $database, $user;//, $appointment;

    public function __construct($config)//, $database, $user, $appointment)
    {
        $this->config = $config;
        $this->database = new Database($this->config);;
        //$this->user = $user;
        //$this->appointment = $appointment;
        
        if(isset($_SESSION['rank']) && $_SESSION['rank'] == 2)
        {
            //MANAGER
            $this->user = new Manager($this->database);
        }
        else if(isset($_SESSION['rank']) && $_SESSION['rank'] == 1)
        {
            //STYLIST
            $this->user = new Stylist($this->database);
        }
        else
        {
            //CUSTOMER
            $this->user = new User($this->database);
        }

        mb_internal_encoding('UTF-8');
        date_default_timezone_set('America/Regina'); //Should be the same as MySQL server timezone

        $this->route();
    }

	public function route()
	{
        session_start();

        $request = explode('?', $_SERVER['REQUEST_URI'], 2);
        //$request = array_slice(explode('/', str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI'])), 1);

        if($this->user->validateSession())
        {
            if($request[0] == '/home')
            {
                $this->user->view();
            }
            else if($request[0] == '/system/logout')
            {
                $this->user->logout();
            }
            else if($request[0] == '/system/appointments')
            {
                $salon = new Salon($this->database);
                $salon->getUnavailableTimesJSON();
            }
            else if($request[0] == '/system/services')
            {
                $salon = new Salon($this->database);
                $salon->getServicesJSON();
            }
            else if($request[0] == '/system/locations')
            {
                $this->user->getUserBy('id', $_SESSION['id']);
                $salon = new Salon($this->database);
                $salon->getLocationsJSON($this->user->getData('country'), $this->user->getData('province'), $this->user->getData('city'));
            }
            else if($request[0] == '/system/stylists')
            {
                $salon = new Salon($this->database);
                $salon->getStylistsJSON();
            }
            else if($request[0] == '/system/schedule')
            {
                $salon = new Salon($this->database);
                $salon->scheduleAppointment();
            }
            else if($request[0] == '/system/upload')
            {
                $this->upload();
            }
            else if($request[0] == '/system/cancel')
            {
                $salon = new Salon($this->database);
                $salon->cancelAppointment($_POST['appointment']);
            }
            else
            {
               header('Location: /home');
               exit();
            }
        }
        else
        {
            if($request[0] == '/system/login')
            {
                $this->user->login();
            }
            else if($request[0] == '/system/register')
            {
                $this->user->register();
            }
            else if($request[0] != '/') //MAY NEED TO BE CHANGED TO HANDLE ERROR CODES
            {
                header('Location: /');
                exit();
            }
            else
            {
                include(__DIR__ . '/../pages/html/index.html');
            }
        }
	}
    
    function upload()
    {
        $target_dir = __DIR__ . "/../uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = true;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $target_file = round(microtime(true)) . '.' . $imageFileType;
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        
        //echo $imageFileType;
        
        if($check == false) 
        {
            $uploadOk = false;
        }
        
        if ($_FILES["file"]["size"] > 1000000) 
        {
            $uploadOk = false;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
        {
            $uploadOk = false;
        }
        
        while (file_exists($target_file)) 
        {
            $target_file = round(microtime(true)) . '.' . $imageFileType;
        }
        
        $newFile = array();
        
        if($uploadOk)
        {
           move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $target_file); 
           $newFile['file'] = $target_file;
           $newFile['error'] = false;
        }
        else
        {
            $newFile['error'] = true;
        }
        
        echo json_encode($newFile);
    }

}