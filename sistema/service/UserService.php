<?php
session_start();
$url = '../';
require $url . 'controller/UserController.php';
$userController = new UserController();

switch ($_GET["op"]) {
	case '1':
		unset($_SESSION['userItem']);
		$request = json_decode(file_get_contents("php://input"));
		echo $userController->login($request);	
		break;
	case '2':
		echo $userController->findAllLog();	
		break;
	case '3':
		unset($_SESSION['userItem']);
		break;
	case '4':
	    $data = json_decode(file_get_contents("php://input"));
	    echo $userController->addLog($data);	
		break;
	case '5':
	    echo $userController->findUserById();	
		break;
	case '6':
		$data = json_decode(file_get_contents("php://input"));
	    echo $userController->updateUser($data);	
		break;
	case '7':
		$data = json_decode(file_get_contents("php://input"));
	    echo $userController->updateSenha($data);	
		break;			
	default:
		unset($_SESSION['userItem']);
		echo 'logout realizado com sucesso!';
		break;				
}

?>

