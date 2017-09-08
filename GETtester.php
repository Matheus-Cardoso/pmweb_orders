<?php 
	
include 'order_stats.php';


//caso seja nulo, $start_date recebe um valor "zerado"
if(is_null($start_date = $_GET["start_date"])) {
	
	$start_date = '0000-00-00';
}; 

//caso seja nulo, $end_date recebe a data mais recente (dia atual)
if(is_null($end_date = $_GET["end_date"])) {
	
	$end_date = date('Y-m-d');
}; 

//$orders recebe o objeto dos pedidos, e $orders_json a string ja formatada
$orders = new Pmweb_Orders_Stats;
$orders_json = $orders -> getOrdersToJSON($start_date, $end_date);
echo $orders_json;

?>