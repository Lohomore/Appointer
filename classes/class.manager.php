<?php
if(!defined('ALLOW_ACCESS')) exit(header('Location: /'));

class Manager extends User
{
    public $database, $data;

    public function __construct($database)
    {
        $this->database = $database;
    }
}