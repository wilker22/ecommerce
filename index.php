<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

//route site index
$app->get('/', function() {
    
	$page = new Page();
	$page->setTpl("index");

});

//route admin
$app->get('/admin', function() {
    
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("index");

});

//route login
$app->get('/admin/login', function(){
	$page = new PageAdmin([
		'header' => false,
		'footer' => false
	]);
	$page->setTpl("login");
});

$app->post('/admin/login', function(){
	User::login($_POST['login'], $_POST['password']);
	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function(){
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->run();

 ?>