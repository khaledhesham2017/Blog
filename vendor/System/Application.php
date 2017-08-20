<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 17/08/2017
 * Time: 10:15 م
 */

namespace System;


class Application
{
    /**
     * Container
     * @var array
     */
    private  $container =[];
    /**
     * Application  Object
     * @var \System\Application
     */
      private static $instance;
    /**
     *
     * Constructor
     * @param \System\File $file
     */
    private  function  __construct(File $file)
    {
       $this->share('file',$file);
       $this->registerClasses();
       static::$instance =$this;
       $this->loadHelpers();
    }
    /**
     * Get Application Instance
     * @param \System\File $file
     * @return \System\Application
     */
    public static function getInstance ( $file =null){
        if(is_null(static::$instance)){
            static::$instance = new static($file);
        }
        return static::$instance;
    }
    /*
     * Run the  Application
     * @return void
     */
    public  function  run(){

         $this->session->start();
         $this->request->prepareUrl();
         $this->file->newRequire('App/index.php');
         list($controller,$method,$arguments) = $this->route->getProperRoute();

    }
    /*
     * Load Helpers File
     *@return void
     *
     */
    private  function  loadHelpers(){
        $this->file->newRequire('vendor/helpers.php');
    }
    /*

     * Register Classes in spl auto load register
     * @return void
     */
    private  function  registerClasses(){
     spl_autoload_register([$this,'load']);

    }
    /*
     * load Class through autoload
     * @param string $class
     * @return void
     */
    public  function  load ($class){


    if (strpos($class,'App')===0){

        $file = $class.'.php';
    }
    else{
        //get class  from vendor
        $file = 'vendor/'.$class.'.php';

    }

        if ($this->file->exists($file)){

            $this->file->newRequire($file);
        }

    }
    /**
     * get share  value
     * @param string $key
     * @return mixed
     */
    public function get ($key){

        if(! $this->isSharing($key)){
            if($this->isCoreAlias($key)) {
                $this->share($key, $this->crateNewCoreObject($key));

            }
            else{
                die ('<br>'.$key.'</br>not found in application container');
            }
        }
        return $this->container[$key];
      }
      /*
       *Determine if the  given key is  shared through Application
       * @param string $key
       * @return bool
       */
      public function isSharing($key){
       return   isset($this->container[$key]);
      }

    /*
     * Share given  key | value Through Application
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
public  function  share ($key,$value ){
    $this->container[$key]=$value;

}
/*Determine if the  given key is  shared through Application
       * @param string $key
       * @return bool
*/
private function isCoreAlias($alias){
 $coreClasses =$this->coreClasses();
 return isset($coreClasses[$alias]);
}
/*
 * create new object for the core class based on the  given alias
 * @param string $alias
 * @return object
 */
private function crateNewCoreObject($alias){
    $coreClasses = $this->coreClasses();
    $object = $coreClasses[$alias];
    return new $object($this);
}
/*
 * Get All Core Classes with its aliases
 * @return array
 */
 private  function  coreClasses(){

     return [
         'request' => 'System\\Http\\Request',
         'response'=> 'System\\Http\\Response',
         'session' => 'System\\Session',
         'route'   => 'System\\Route',
         'cookie'  => 'System\\Cookie',
         'load'    => 'System\\loader',
         'html'    => 'System\\Html',
         'db'      => 'System\\Database',
         'view'    => 'System\\ViewFactory',


     ];
 }
    /*
        * Get shared Value dynamically
        * @param string $key
        * @return mixed
        */
    public  function  __get ($key){

        return $this->get($key);
    }
}