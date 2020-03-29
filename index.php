<?php


use App\DBRepository\UserSQL;
use App\Reporting\JsonReporter;
use App\User\SendMailToUser;
use App\User\User;
use App\Validation\Validation;

require_once('vendor/autoload.php');

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$password2 = $_REQUEST['password2'];

$user = new User($email, $password, $password2, new Validation(new JsonReporter));
$user->saveNewUser(new UserSQL(new JsonReporter), new SendMailToUser, new JsonReporter);
