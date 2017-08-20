<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 20/08/2017
 * Time: 01:24 م
 */

namespace System\Http;


class Request
{
    /*
     * Url
     * @var string
     */
    private $url;
    /**
     * Base Url
     * @var  string
     */
    private  $baseUrl;
    /*
     * prepare url
     * @return void
     */
    public  function  prepareUrl(){
        $script =dirname($this->server('SCRIPT_NAME'));
        $script = strtolower($script);
        $requestUri = $this->server('REQUEST_URI');
        if (strpos($requestUri,'?')!==false){
            list($requestUri,$queryString)=explode('?',$requestUri);
        }
        $this->url = preg_replace('#^'.$script.'#','',$requestUri);
        $this->baseUrl =$this->server('REQUEST_SCHEME').'://'.$this->server('HTTP_HOST').$script.'/';

    }
    /*
     * Get Value from _Get by the given  key
     * @param string  key
     * @param mixed $key
     * @return mixed
     */
    public  function  get($key ,$default =null){
        return array_get($_GET,$key,$default);
    }
    /*
     * Get Value from _Post by the given  key
     * @param string  key
     * @param mixed $key
     * @return mixed
     */
    public  function  Post($key ,$default =null){
        return array_get($_POST,$key,$default);
    }
    /*
     * Get Value from _SERVER by the given  key
     * @param string  key
     * @param mixed $key
     * @return mixed
     */
    public  function  server($key ,$default =null){
       return array_get($_SERVER,$key,$default);
    }
    /**
     * Get Current Request Method
     * @return string
     */
    public function method(){
      return $this->server('REQUEST_METHOD');
    }
    /**
     * Get full url of the  script
     * @return string
     */
    public  function  baseUrl(){
      return $this->baseUrl;
    }
    /**
     * Get only relative url (Clean url)
     * @return string
     */
public  function url(){
    return $this->url;
}
}