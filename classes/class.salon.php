<?php
if(!defined('ALLOW_ACCESS')) exit(header('Location: /'));

class Salon
{
    public $database, $data;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getServicesJSON()
    {
        $serviceQuery = $this->database->query('SELECT * FROM services');
        $services = array();
        
        if($this->database->rowCount($serviceQuery))
        {
            while($serviceRow = $this->database->fetch($serviceQuery))
            {
                //$service['id'] = $serviceRow['id'];
                //$service['service'] = $serviceRow['service'];
                //$service['minutes'] = $serviceRow['minutes'];
                $services[] = $serviceRow;
            }
        }
        
        echo json_encode($services);
    }
    
    public function getLocationsJSON($country, $province, $city)
    {
        //$this->user->getUserBy('id', $_SESSION['id']);
        
        $locationQuery = $this->database->query('SELECT id, address FROM locations WHERE country = ? AND province = ? AND city =?', $country, $province, $city);
        $locations = array();
        
        if($this->database->rowCount($locationQuery))
        {
            while($locationRow = $this->database->fetch($locationQuery))
            {
                //$location['id'] = $locationRow['id'];
                //$location['address'] = $locationRow['address'];
                $locations[] = $locationRow;
            }
        }
        
        echo json_encode($locations);
    }
    
    public function getStylistsJSON()
    {
        $stylistQuery = $this->database->query('SELECT id, firstName, image FROM users WHERE rank = 1 AND location = ?', $_GET['loc']); //CHECK IF GET VARIABLE EXISTS
        //$stylistQuery = $this->database->query('SELECT id, firstName FROM users WHERE rank = 1 AND location = ?', $location); //CHECK IF GET VARIABLE EXISTS
        $stylists = array();
        
        if($this->database->rowCount($stylistQuery))
        {
            while($stylistRow = $this->database->fetch($stylistQuery))
            {
                //$stylist['id'] = $stylistRow['id'];
                //$stylist['firstName'] = $stylistRow['firstname'];
                $stylists[] = $stylistRow;
            }
        }
        
        echo json_encode($stylists);
    }
    
    public function getUnavailableTimesJSON()
    {
        $apps = array();
        
        date_default_timezone_set('UTC');
        
        $start = intval(strtotime($_GET['start'] . " 0:00:00 GMT"));
        $end = intval(strtotime($_GET['end'] . " 23:59:59 GMT"));

        //GET ALL USER APPOINTMENTS
        if(isset($_SESSION['id'])) //CHECK RANK
        {
            $appUserQuery = $this->database->query('SELECT * FROM appointments WHERE user = ? AND start >= ? AND end <= ?', $_SESSION['id'], $start, $end);
            
            if($this->database->rowCount($appUserQuery))
            {
                while($appUserRow = $this->database->fetch($appUserQuery))
                {
                    //$app = array();
                    $app['id'] = $appUserRow['id'];
                    $app['title'] = $appUserRow['title'];
                    $app['start'] = date('Y-m-d\TH:i:s', $appUserRow['start']);
                    $app['end'] = date('Y-m-d\TH:i:s', $appUserRow['end']);
                    $app['serviceName'] = $this->getServiceName($appUserRow['service']);
                    $app['stylistName'] = $this->getStylistName($appUserRow['stylist']);
                    $app['locationName'] = $this->getLocationName($appUserRow['location']);
                    $app['details'] = $appUserRow['details'];
                    $app['image'] = $appUserRow['image'];
                    
                    $apps[] = $app;
                }
            }
        }
        
        //GET ALL CLOSED DAYS
        $daysQuery = $this->database->query('SELECT sun, mon, tues, wed, thurs, fri, sat FROM config LIMIT 1'); //ADD LOCATION   
        
        $days = array();
        
        if($this->database->rowCount($daysQuery))
        {
            $daysRow = $this->database->fetch($daysQuery);
            $curDay = 0;
            
            
            foreach($daysRow as $data)
            {
                if(!$data)
                {
                    $days[] = $curDay;
                }
                
                $curDay++;
            }
            
            if(count($days))
            {
                $app['title'] = 'CLOSED';
                $app['start'] = '00:00:00';
                $app['end'] = '24:00:00';
                $app['color'] = '#BBB';
                $app['dow'] = $days;
                $apps[] = $app;
            }
        }
        
        if(isset($_GET['stylist']))
        {
            //GET ALL STYLIST APPOINTMENTS
            $appStylistQuery = $this->database->query('SELECT * FROM appointments WHERE user != ? AND stylist = ? AND start >= ? AND end <= ?', $_SESSION['id'], $_GET['stylist'], $start, $end);
            
            if($this->database->rowCount($appStylistQuery))
            {
                while($appStylistRow = $this->database->fetch($appStylistQuery))
                {
                    //$app = array();
                    $app['title'] = 'UNAVAILABLE';
                    $app['start'] = date('Y-m-d\TH:i:s', $appStylistRow['start']);
                    $app['end'] = date('Y-m-d\TH:i:s', $appStylistRow['end']);
                    $app['color'] = '#BBB';
                    $apps[] = $app;
                }
            }

            $stylistDaysQuery = $this->database->query('SELECT sun, mon, tues, wed, thurs, fri, sat FROM availability WHERE stylist = ? LIMIT 1', $_GET['stylist']); //ADD LOCATION   
            
            if($this->database->rowCount($stylistDaysQuery))
            {
                $stylistDaysRow = $this->database->fetch($stylistDaysQuery);
                $curStylistDay = 0;
                $stylistDays = array();
                
                foreach($stylistDaysRow as $data)
                {
                    if(!$data && !in_array($curStylistDay, $days))
                    {
                        $stylistDays[] = $curStylistDay;
                    }
                    
                    $curStylistDay++;
                }
                
                if(count($stylistDays))
                {
                    $app['title'] = 'UNAVAILABLE';
                    $app['start'] = '00:00:00';
                    $app['end'] = '24:00:00';
                    $app['color'] = '#BBB';
                    $app['dow'] = $stylistDays;
                    $apps[] = $app;
                }
            }
        }
        
        echo json_encode($apps);
    }
    
    public function getServiceName($id)
    {
        $serviceQuery = $this->database->query('SELECT service FROM services WHERE id = ? LIMIT 1', $id);

        if(isset($serviceQuery) && $this->database->rowCount($serviceQuery))
        {
            $serviceRow = $this->database->fetch($serviceQuery);
            
            return $serviceRow['service'];
        }

        return '';
    }
    
    public function getStylistName($id)
    {
        $stylistQuery = $this->database->query('SELECT firstName FROM users WHERE id = ? LIMIT 1', $id);

        if(isset($stylistQuery) && $this->database->rowCount($stylistQuery))
        {
            $stylistRow = $this->database->fetch($stylistQuery);
            
            return $stylistRow['firstName'];
        }

        return '';
    }
    
    public function getlocationName($id)
    {
        $locationQuery = $this->database->query('SELECT address FROM locations WHERE id = ? LIMIT 1', $id);

        if(isset($locationQuery) && $this->database->rowCount($locationQuery))
        {
            $locationRow = $this->database->fetch($locationQuery);
            
            return $locationRow['address'];
        }

        return '';
    }
    
    public function cancelAppointment($id)
    {
        if(isset($_SESSION['id']) && $this->database->query('DELETE FROM appointments WHERE id = ? AND user = ?', $id, $_SESSION['id']))
        {
            $response['success'] = true;
            echo json_encode($response);
        }
        else
        {
            $response['success'] = false;
            echo json_encode($response); 
        }
    }
    
    public function scheduleAppointment()
    {
        
        if(isset($_SESSION['id']))
        {
            if($this->database->query('INSERT INTO appointments (user, stylist, location, service, details, start, end, title, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', $_SESSION['id'], $_POST['stylist'], $_POST['location'], $_POST['service'], $_POST['details'], strtotime($_POST['start']), strtotime($_POST['end']), $_POST['title'], $_POST['image']))
            {
                $response['success'] = true;
                echo json_encode($response);
            }
            else
            {
                $response['success'] = false;
                echo json_encode($response); 
            }
        }
        
    }
}