<?php
	require_once 'sistema/dao/Dados.php';
	$dados = new Dados();
	$conexao = $dados->ConectarBanco();
	
	$tipos = array("Action Figures","Adaptador","Amiibo","Arcade","Board Game","Board Game","Cabos","Card Game","Cartões de memória","CD Musical","Console","Controle","DVD Musical","EverDrive","Ferramenta","Fonte","HQ","Instrumento musical","Jogo Digital","Jogo Físico","Livro Jogo","Livro","Manga","Manual","Memory Card","Outros Acessórios","Póster","Panfletos","Pistola","Portátil","Revista","RPG - Livro","Rumble pack","Tapete","Televisor");
	$plataformas = array("Outros","Atari 2600","Atari Flashback","Game Boy","Game Boy Advance","Game Boy Color","Master System","Mega Drive/Genesis","Neo Geo Pocket","Neo Geo Pocket Color","Neo-Geo","Neo-Geo CD","NES/Famicom","Nintendo 2DS","Nintendo 3DS","Nintendo 64","Nintendo DS","Nintendo DS Lite","PC-FX","PlayStation","PlayStation 2","PlayStation 3","PlayStation 4","PlayStation 5","PlayStation Vita","PSP 3000","Sega 32X","Sega CD","Sega Saturn","Super Game Boy","Super Nintendo/Super Famicom","Wii","WonderSwan","WonderSwan Color","Xbox","Xbox 360","Xbox One","Xbox Series S","Xbox Series X");
	
	$filter .= ($_GET["plataforma"] != null || $_GET["plataforma"] != '') ? " AND gi.plataforma = '" . $_GET["plataforma"] . "'" : "";
	$filter .= ($_GET["tipo"] != null || $_GET["tipo"] != '') ? " AND gi.tipo = '" . $_GET["tipo"] . "'" : "";
	
	$query = mysqli_query($conexao, "SELECT gi.`id`,Date_format(gi.`data_cadastro`,'%d/%m/%Y') AS data_cadastro,gi.`titulo`,gi.`descricao`,gi.`imagem`,gi.`procedencia`,gi.`regiao`,gi.`valor_pago`,gi.`valor_atual`,gi.`plataforma`,gi.`tipo`,gi.`codigo`,gi.`complemento`,gi.`avaliacao`,gi.`local_primeiro`,gi.`local_segundo`,gi.`local_terceiro`,gi.`flag_cartucho_disco`,gi.`flag_replica`,gi.`flag_protetor`,gi.`flag_cd_dvd`,gi.`flag_caixa`,gi.`flag_manual`,gi.`flag_berco`,gi.`flag_panfleto`,gi.`flag_poster`,gi.`flag_nota_fiscal`,gi.`flag_lacrado`,gi.`flag_luva`,gi.`flag_retrocompativel`,gi.`id_user`,gi.`status`,gi.`progressao`,gi.`situacao`,gi.`genero`,gi.`produtora`,gi.`quantidade`,gi.`publicadora`,gi.`screenshot1`,gi.`screenshot2`,gi.`screenshot3`,gi.`screenshot4`,gi.`tempo`,gi.`num_jogadas`,gi.`possui` FROM `tb_game_item` gi WHERE gi.id_user = '2' ".$filter." ORDER BY RAND(); ");
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	
	function getSimNao($value){
		return $value == '1'?'Sim':'Não';
	}
	
	function getStatus($value){
		$result = null;
		switch($value){
			case 'C': 
				$result = 'Completo';
				break;	
			case 'P': 
				$result = 'Pendente';
				break;
            case 'W': 
				$result = 'Pausado';
				break;				
			case 'E': 
				$result = 'Em Progressão';
				break;	
			case 'A': 
				$result = 'Abandonado';
				break;					
		}
		return $result;
	}
	
	function getSizeImagem($imagem){
		$imagePath = './sistema/uploads/'.$imagem; 
		$imageSize = getimagesize($imagePath); 
		$width = $imageSize[0]; 
		$height = $imageSize[1];
		
		if($width > $height){
			return 'width="400"';
		}else{
			return 'height="400"';
		}
		
	}
	
	function getClassRand(){
		$result = null;
		switch(rand(1, 7)){
			case 1: 
				$result = 'bg-success';
				break;	
			case 2: 
				$result = 'bg-info';
				break;	
			case 3: 
				$result = 'bg-warning';
				break;	
			case 4: 
				$result = 'bg-primary';
				break;
			case 5: 
				$result = 'bg-danger';
				break;
			case 6: 
				$result = 'bg-dark';
				break;
			case 7: 
				$result = 'bg-secondary';
				break;
		}
		return $result;				
	}
	
	function montarLinks($listagem, $view, $campo){
		$galeria = '';
		$html = '<br/><b>'.strtoupper($campo).'S:&nbsp;</b>';
		if($view != null && strtolower($view) == "g"){
			$galeria = '&view=g';
		}
		$html .= '<a href="itens.php?'.$galeria.'"><i>Todos</i></a>&nbsp;&nbsp;';
		foreach($listagem as $valor){
			$html .= '<a href="itens.php?'.$campo.'='.$valor.$galeria.'">'.$valor.'</a>&nbsp;&nbsp;';
		}
		return $html;
	}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus Itens</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<style>
		* {
		  box-sizing: border-box;
		}

		body {
		  margin: 0;
		  font-family: Arial;
		}

		.header {
		  text-align: center;
		  padding: 32px;
		}

		.row {
		  display: -ms-flexbox; /* IE10 */
		  display: flex;
		  -ms-flex-wrap: wrap; /* IE10 */
		  flex-wrap: wrap;
		  padding: 0 4px;
		}

		/* Create four equal columns that sits next to each other */
		.column {
		  -ms-flex: 25%; /* IE10 */
		  flex: 25%;
		  max-width: 25%;
		  padding: 0 4px;
		}

		.column img {
		  margin-top: 8px;
		  vertical-align: middle;
		  width: 100%;
		}

		/* Responsive layout - makes a two column-layout instead of four columns */
		@media screen and (max-width: 800px) {
		  .column {
			-ms-flex: 50%;
			flex: 50%;
			max-width: 50%;
		  }
		}

		/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
		@media screen and (max-width: 600px) {
		  .column {
			-ms-flex: 100%;
			flex: 100%;
			max-width: 100%;
		  }
		}
    </style>
  </head>
  <body>
<?php
if($_GET["view"] != null && strtolower($_GET["view"]) == "g"){
$aux = 0;
echo 'Total de Registros carregados: <b>'.(mysqli_num_rows($query)-1).'</b>&nbsp;/&nbsp;Modo de Visualização:&nbsp;<a href="itens.php">Listagem</a>';
echo montarLinks($tipos,$_GET["view"],'tipo').'<br/>';
echo montarLinks($plataformas,$_GET["view"],'plataforma');
echo '<div class="row">';
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$aux++;

	if($aux == 1){
		echo '<div class="column">';
	}	
	echo '<img src="./sistema/uploads/'.$row["imagem"].'" style="width:100%" >';

	if($aux == 3){
		echo '</div>';
		$aux = 0;
	}	  
	
}
echo '</div>';
?> 
<?php
	  
	  
} else {
  ?>
	
	<?php 
	    echo 'Total de Registros carregados: <b>'.(mysqli_num_rows($query)-1).'</b>&nbsp;/&nbsp;Modo de Visualização:&nbsp;<a href="itens.php?view=G">Galeria</a>';
		echo montarLinks($tipos,$_GET["view"],'tipo').'<br/>'; 
		echo montarLinks($plataformas,$_GET["view"],'plataforma');
	?>
    <table class="table">
	  <thead>
		<tr>
			<th scope="col">imagem</th>
			<th scope="col">id</th>
			<th scope="col">data_cadastro</th>
			<th scope="col">titulo</th>
			<th scope="col">tipo</th>			
			<th scope="col">procedencia</th> 
			<th scope="col">regiao</th> 
			<th scope="col">quantidade</th> 
			<th scope="col">valor_pago</th> 
			<th scope="col">valor_atual</th> 
			<th scope="col">plataforma</th> 
			<th scope="col">codigo</th> 
			<th scope="col">avaliacao</th> 
			<th scope="col">local_primeiro</th> 
			<th scope="col">local_segundo</th> 
			<th scope="col">local_terceiro</th>
			<th scope="col">flag_cartucho_disco</th>
			<th scope="col">flag_replica</th>
			<th scope="col">flag_protetor</th>
			<th scope="col">flag_cd_dvd</th>
			<th scope="col">flag_caixa</th>
			<th scope="col">flag_manual</th> 
			<th scope="col">flag_berco</th>
			<th scope="col">flag_panfleto</th> 
			<th scope="col">flag_poster</th>
			<th scope="col">flag_nota_fiscal</th> 
			<th scope="col">flag_lacrado</th> 
			<th scope="col">flag_luva</th>
			<th scope="col">flag_retrocompativel</th>
			<th scope="col">status</th>
			<th scope="col">progressao</th>
			<th scope="col">situacao</th>
			<th scope="col">possui</th>
			<th scope="col">genero</th>
			<th scope="col">produtora</th>
			<th scope="col">publicadora</th>
			<th scope="col">tempo/Hs</th>
			<th scope="col">num_jogadas</th>
		</tr>
	  </thead>
	  <tbody>
<?php
$aux = 0; 		
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){ 
$color = 'bg-info';
if($aux & 1){
	$color = 'bg-danger';	
} 
$aux++;
	  
echo '<tr class="'.$color.'">		  
		 <td>
			<a href="./sistema/uploads/'.$row["imagem"].'" data-lightbox="roadtrip" data-title="'.$row["titulo"].'">
				<img src="./sistema/uploads/'.$row["imagem"].'" width="170">
			</a>			
		 </td> 
		 <td>'.$row["id"].'</td>
		 <td>'.$row["data_cadastro"].'</td>
		 <td class="xpto">'.$row["titulo"].'</td>
		 <td>'.$row["tipo"].'</td>		 
		 <td>'.$row["procedencia"].'</td> 
		 <td>'.$row["regiao"].'</td> 
		 <td>'.$row["quantidade"].'</td> 
		 <td>'.$row["valor_pago"].'</td> 
		 <td>'.$row["valor_atual"].'</td> 
		 <td>'.$row["plataforma"].'</td> 
		 <td>'.$row["codigo"].'</td> 
		 <td>'.$row["avaliacao"].' / 100</td> 
		 <td>'.$row["local_primeiro"].'</td> 
		 <td>'.$row["local_segundo"].'</td> 
		 <td>'.$row["local_terceiro"].'</td>
		 <td>'.getSimNao($row["flag_cartucho_disco"]).'</td>
		 <td>'.getSimNao($row["flag_replica"]).'</td>
		 <td>'.getSimNao($row["flag_protetor"]).'</td>
		 <td>'.getSimNao($row["flag_cd_dvd"]).'</td>
		 <td>'.getSimNao($row["flag_caixa"]).'</td>
		 <td>'.getSimNao($row["flag_manual"]).'</td> 
		 <td>'.getSimNao($row["flag_berco"]).'</td>
		 <td>'.getSimNao($row["flag_panfleto"]).'</td> 
		 <td>'.getSimNao($row["flag_poster"]).'</td>
		 <td>'.getSimNao($row["flag_nota_fiscal"]).'</td> 
		 <td>'.getSimNao($row["flag_lacrado"]).'</td> 
		 <td>'.getSimNao($row["flag_luva"]).'</td>
		 <td>'.getSimNao($row["flag_retrocompativel"]).'</td>
		 <td>'.getStatus($row["status"]).'</td>
		 <td>'.$row["progressao"].'</td>
		 <td>'.$row["situacao"].'</td>
		 <td>'.getSimNao($row["possui"]).'</td>
		 <td>'.$row["genero"].'</td>
		 <td>'.$row["produtora"].'</td>
		 <td>'.$row["publicadora"].'</td>
		 <td>'.$row["tempo"].' Hs.</td>
		 <td>'.$row["num_jogadas"].'</td>
     </tr>';
} 
}
?>		
	  </tbody>
	</table>
	
	
    <!-- lightbox -->
   	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <link href="bower_components/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">
    <script src="bower_components/lightbox2/dist/js/lightbox.min.js"></script>
	<!-- lightbox -->
	<script>	
		function doubleClick(){
			var touchtime = 0;
			$(".xpto").on("click", function() {
				if (touchtime == 0) {
					touchtime = new Date().getTime();
				} else {
					if (((new Date().getTime()) - touchtime) < 800) {
						alert($(this).html());
						touchtime = 0;
					} else {
						touchtime = new Date().getTime();
					}
				}    
			});	
		}
		
		$(function() {
			doubleClick();
		});	
	</script>
  </body>
</html>
<?php 

$dados->FecharBanco($conexao);

?>

