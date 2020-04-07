<?php


use App\Chain\Authenticate;
use App\Chain\EmailChain;
use App\Chain\PasswordChain;
use App\Chain\UserExistsChain;
use App\Container\Container;
use App\User\User;

require_once('vendor/autoload.php');

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$password2 = $_REQUEST['password2'];

$config = json_decode(file_get_contents(__DIR__ . "/app/config/services.json"), true);

$container = new Container();

foreach ($config['services'] as $service => $arguments) {
    $container->set($service, $arguments['arguments'] ?: [], $config['services'][$service]['class']);
}

$chain = $container->get(EmailChain::class);
$passChain = $container->get(PasswordChain::class);
$userExistsChain = $container->get(UserExistsChain::class);
$chain->linkNext($passChain)->linkNext($userExistsChain);

$user = $container->get(User::class);
$user->setEmail($email);
$user->setPassword($password);
$user->setPassword2($password2);

$auth = new Authenticate($chain);
$auth->checked($user);

$user->saveNewUser();
