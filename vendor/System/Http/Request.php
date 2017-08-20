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
    /*
     * prepare url
     * @return void
     */
    public  function  prepareUrl(){
        pre($_SERVER);
    }

}