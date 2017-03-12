<?php
if(!defined('ALLOW_ACCESS')) exit(header('Location: /'));

class Core
{
    private $config, $database, $user;

    public function __construct($config, $database, $user)
    {
        $this->config = $config;
        $this->database = $database;
        $this->user = $user;

        mb_internal_encoding('UTF-8');
        date_default_timezone_set('America/Regina'); //Should be the same as MySQL server timezone

        $this->route();
    }

	public function route()
	{
        session_start();

        //$request = array_slice(explode('/', str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI'])), 1);

        if($this->user->validateSession())
        {
            if($_SERVER['REQUEST_URI'] == '/home')
            {
                $this->user->view();
            }
            else if($_SERVER['REQUEST_URI'] == '/system/logout')
            {
                $this->user->logout();
            }
            else
            {
               header('Location: /home');
               exit();
            }
        }
        else
        {
            if($_SERVER['REQUEST_URI'] == '/system/login')
            {
                $this->user->login();
            }
            else if($_SERVER['REQUEST_URI'] == '/system/register')
            {
                $this->user->register();
            }
            else if($_SERVER['REQUEST_URI'] != '/') //MAY NEED TO BE CHANGED TO HANDLE ERROR CODES
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
}