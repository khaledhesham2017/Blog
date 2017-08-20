<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 20/08/2017
 * Time: 11:34 م
 */

namespace System;


abstract  class Controller
{
    /**
     * Application Object
     * @var \System\Application
     */
     private  $app;
     /**
      * Constructor
      * @param \System\Application $app
      */
     public function __construct(Application $app)
     {
         $this->app = $app;
     }
     /**
      * Call Shared application object dynamically
      * @param string $key
      * @return mixed
      */
     public  function __get($key){
         return $this->app->get($key);
     }
}