<?php

namespace Lib;

class Log
{

    public function __construct(){
        echo("Log");
    }

    static function getRealIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    static function writeLog($where) {

        $ip = getRealIp(); // Get the IP from superglobal
        $host = gethostbyaddr($ip);    // Try to locate the host of the attack
        $date = date("d M Y");

        // create a logging message with php heredoc syntax
        $logging = <<<LOG
    		\n
    		<< Start of Message >>
    		There was a hacking attempt on your form. \n 
    		Date of Attack: {$date}
    		IP-Adress: {$ip} \n
    		Host of Attacker: {$host}
    		Point of Attack: {$where}
    		<< End of Message >>
LOG;

        if($handle = fopen('hacklog.log', 'a')) {
            fputs($handle, $logging);
            fclose($handle);
        } else {
            die("Could not write to log");
        }
    }

}