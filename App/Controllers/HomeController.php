<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 20/08/2017
 * Time: 11:24 م
 */

namespace App\Controllers;


use System\Controller;

class HomeController extends Controller
{
 public function  index(){
      echo  $this->request->url();
      //$this->session->set('name','Hassan');
     //to use  controller  in anthor controller
     $this->load->controller('Header')->index();
     echo $this->session->get('name');
 }
}