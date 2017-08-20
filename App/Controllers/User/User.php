<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 19/08/2017
 * Time: 03:50 م
 */

namespace App\Controllers\User;


use System\Application;
use System\Session;

class User
{
    public function __construct(Application $app)
    {
        $session =  new Session($app);
        $session->set("Name","ooo");
        print_r($session->all());
    }
    public function  set ($key,$value){


    }
}