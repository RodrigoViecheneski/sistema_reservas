<?php
require 'config.php';
require 'classes/carros.class.php';
require 'classes/reservas.class.php';

$reservas = new Reservas($pdo);
$carros = new Carros($pdo);
?>

<h1>Reservas</h1>

<a href="reservar.php">Adicionar Reserva</a>
<br/><br/>

<form method="GET">
	<select name="ano">
		<?php for($q=date('Y'); $q>2000;  $q--): ?>
			<option><?php echo $q; ?></option>
		<?php endfor; ?>
	</select>
	<select name="mes">
		<option>01</option>
		<option>02</option>
		<option>03</option>
		<option>04</option>
		<option>05</option>
		<option>06</option>
		<option>07</option>
		<option>08</option>
		<option>09</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
	</select>
	<input type="submit" value="Mostrar">
</form>

<?php
if(empty($_GET['ano'])){
	exit;
}
//aqui copia do calendário para validar
$data = $_GET['ano'].'-'.$_GET['mes']; //dados vindos dos selects da index
//$data = '2020-03'; testes
$dia1 = date('w', strtotime($data.'-01'));
$dias = date('t', strtotime($data));
//ceil arredonda o resultado para cima
$linhas = ceil(($dia1+$dias) / 7);
$dia1 = -$dia1;
$data_inicio = date('Y-m-d', strtotime($dia1.' days', strtotime($data)));
$data_fim = date('Y-m-d', strtotime(( ($dia1 + ($linhas*7) - 1) ).' days', strtotime($data)));
//fim copia
$lista = $reservas->getReservas($data_inicio, $data_fim);
/*
foreach($lista as $item){
	$data1 = date('d/m/Y', strtotime($item['data_inicio']));
	$data2 = date('d/m/Y', strtotime($item['data_fim']));
	echo $item['pessoa'].' reservou o carro '.$item['id_carro'].' entre '.$data1. ' e '.$data2.'<br/>';
}*/
?>
<hr/>
<?php
require 'calendario.php';
?>