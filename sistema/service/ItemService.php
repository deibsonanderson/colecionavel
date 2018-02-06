<?php

$url = '../';
require $url . 'controller/ItemController.php';
$itemControll = new ItemController();

if($itemControll->validarLogin()){


switch ($_GET["op"]) {
	case '1':
		echo $itemControll->findItemByFilter($_GET);
		break;
	case '2':
		echo $itemControll->findItemById($_GET["id"],false);
		break;
	case '3':
		$data = json_decode(file_get_contents("php://input"));
		echo $itemControll->addItem($data);
		break;
	case '4':
	    $data = json_decode(file_get_contents("php://input"));
	    echo $itemControll->updateItem($data);	
		break;
	case '5':
	    echo $itemControll->deleteItem($_GET["id"]); 
		break;
	case '6':
	    echo $itemControll->findItemByVideoGame();
		break;	
	case '7':
	    echo $itemControll->findItemByProgressos();
		break;
	case '8':
	    echo $itemControll->findItemByCountGames();
		break;
	case '9':
	    echo $itemControll->findItemByMaiorTempo();
		break;
	case '10':
	    echo $itemControll->findItemByMaisJogadas();
		break;		
	case '11':
	    echo $itemControll->findItemByMaisRecente();
		break;
	case '12':
	    echo $itemControll->findItemByMaisCaro();
		break;		
	case '13':
	    echo $itemControll->findItemByAvaliado();
		break;
	case '14':
	    echo $itemControll->findPortatilByAvaliado();
		break;		
	case '15':
	    echo $itemControll->findVideoGameByAvaliado();
		break;
	case '16':
	    echo $itemControll->findItemByCompletado();
		break;	
	case '17':
	    echo $itemControll->findAdaptadorByAvaliado();
		break;				
	default:
		echo $itemControll->findAllItem($_GET);
		break;
}

}else{
    $arr = array('message' => 'Acesso negado ao sistema!'); //etc
    header('HTTP/1.1 201 Created');
    echo json_encode($arr);
    http_response_code(401);
}

?>

