<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 20/08/2017
 * Time: 07:33 م
 */

namespace System;


class Route
{
    /**
     * Application object
     * @var \System\Application
     */
      private  $app;
      /**
       * Routes Container
       * @var array
       */
      private $routes =[];
    /**
     * Not Found UrL
     * @var string
     */
    private $notFound;
      /**
       * Constructor
       * @param \System\Application $app
       */
      public  function __construct($app)
      {
          $this->app =$app;
      }
      /**
       * Add New Route
       * @param string $url
       * @param string $action
       * @param string $requestMethod
       * @return void
       */
     public function add ($url,$action,$requestMethod ='Get'){
         $routes = [
              'url'      =>  $url ,
             'pattern'   => $this->generatePattern($url),
             'action'    => $this->getAction($action),
             'method'    =>strtoupper( $requestMethod)
         ];
         $this->routes[] =$routes;
     }
    /**
     * Set Not Found Url
     * @param string $url
     * @return void
     */
    public  function  notFound($url){
        $this->notFound = $url;
    }
    /**
     * Get proper Route
     * @return array
     */
    public function getProperRoute(){
        foreach ($this->routes as $route){
            if ($this->isMatching($route['pattern'])){

                $arguments =$this->getArgumentsFrom($route['pattern']);
                list($controller,$method)=explode('@',$route['action']);
                return [$controller,$method,$arguments];
            }
        }
    }
    /**
     * Determine if the given pattern the Current request url
     * @param string $pattern
     * @return bool
     */
    private function isMatching($pattern){

        return preg_match($pattern,$this->app->request->url());
    }
    /**
     * Get Arguments from  the current request url based on  the given pattern
     * @param string $pattern
     * @return array
     */
    private function  getArgumentsFrom($pattern){
       preg_match($pattern,$this->app->request->url(),$matches);
       array_shift($matches);
       return $matches;
    }
     /**
      * Generate a regex pattern for the given urL
      * @param string $url
      * @return string
      */
     private function generatePattern($url){
         $pattern = '#^';
         $pattern .= str_replace([':text',':id'],['([a-zA-Z0-9-]+)','(\d+)'],$url);
         $pattern .='$#';
         return $pattern;
     }
     /**
      * Get The Proper Action
      * @param string $action
      * @return string
      */
     private  function  getAction($action){
         $action =str_replace('/','\\',$action);
         return strpos($action,'@' !== false) ? $action :$action.'@index';
     }
}