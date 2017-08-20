<?php
/**
 * Created by PhpStorm.
 * User: khale
 * Date: 20/08/2017
 * Time: 06:25 م
 */
//white List routes
use System\Application;

$app =Application::getInstance();
$app->route->add('/','/Home');
$app->route->add('/posts/:text/:id','Posts/Post');
$app->route->add('/404','Error/NotFound');
$app->route->notFound('/404');
$app->session->set("name","khaled");
