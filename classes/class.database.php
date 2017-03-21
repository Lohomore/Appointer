<?php
if(!defined('ALLOW_ACCESS')) exit(header('Location: /'));

class Database
{
	private $config, $database;

	public function __construct($config)
	{
        $this->config = $config;

        try
        {
            $DSN = "mysql:host={$this->config['mysql']['host']};port={$this->config['mysql']['port']};dbname={$this->config['mysql']['database']};charset=utf8";
            $options = [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false
                       ];

            $this->database = new PDO($DSN, $this->config['mysql']['username'], $this->config['mysql']['password'], $options);
        }
        catch (PDOException $e)
        {
            //echo 'MySQL database connection failed: ' . $e->getMessage();
            echo 'MySQL database connection failed.';
            exit();
        }

	}

    public function query($sql, ...$params) //Change name
    {
        try
        {
            $query = $this->database->prepare($sql);

            foreach($params as $i => $value)
            {
                $query->bindValue($i + 1, $value);
            }

            $query->execute();

            return $query;
        }
        catch (PDOException $e)
        {
            //echo 'MySQL query failed.';
            //exit();
            return false;
        }
    }

    public function fetch($query)
    {
        if($query && $query->rowCount())
        {
            return $query->fetch();
        }

        return false;
    }

    public function rowCount($query)
    {
        if($query)
        {
            return $query->rowCount();
        }

        return false;
    }

    /*
    public function closeCursor($query)
    {
        if($query)
        {
            return $query->closeCursor();
        }

        return false;
    }
    */
}