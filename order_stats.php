<?php

include 'config.php';

/**
 * Sumarizações de dados transacionais de pedidos.
 */
class Pmweb_Orders_Stats {

	//vari'avel de conex~ao
	private $db_conn;

	//Valores de Data de inicial e final da consulta, sempre em Timestamp
	public $start_date;
	public $end_date;

	function __construct() {
		
		$connection = new Database_Conn();						//conecta-se ao banco na instancia da classe
		$this -> db_conn = $connection -> DBConnection();		//$db_conn = conexao com o banco
    }

	/**
	 * Define o período inicial da consulta.
	 * @param String $date Data de início, formato `Y-m-d` (ex, 2017-08-24).
	 *
	 * @return void
	 */
	public function setStartDate($date) {
		
		$this -> start_date = $date; //passa data de inicio ao objeto
	}

	/**
	 * Define o período final da consulta.
	 * 
	 * @param String $date Data final da consulta, formato `Y-m-d` (ex, 2017-08-24).
	 * 
	 * @return void
	 */
	public function setEndDate($date) {
		
		$this -> end_date = $date; //passa data de fim ao objeto
	}

	/**
	 * Executa a procura na tabela, retorno de colunas varia de acordo com $request. 
	 * 
	 * @param Integer $request define a funcao e que fez a chamada, e consequentemente as coluna a ser retornada.
	 * 
	 * @return Array com resultados de pedidos referentes ao periodo, NULL caso ocorra erro.
	 */

	public function getOrdersInSQL($request) {

		switch ($request) {

			case 'count': 			//$request = funcao  getOrdersCount, coluna = COUNT(*)					
				$coluna = 'COUNT(*)';
				break;

			case 'revenue': 		//$request = funcao getOrdersRevenue, coluna e' a soma dos precos de pedidos				
				$coluna = 'SUM(price)';
				break;

			case 'quantity': 		//$request = funcao getOrdersQuantity, coluna e' a quantidade total de pedidos
				$coluna = 'SUM(quantity)';
				break;

			case 'retail_price':	//$request = funcao getOrdersRetailPrice, coluna e' a divisao do total de vendas pela quantidade vendida
				$coluna = 'SUM(price)/ SUM(quantity)';		
				break;

			case 'retail_price':	//$request = funcao getOrdersAverageOrderValue, coluna e' o preco medio de cada pedido
				$coluna = 'SUM(price)/ COUNT(*)';
				break;	

			case 'JSON': 			//neste caso, $request recebe todas as colunas anteriores, para fins de exporta'cao em JSON
				$coluna = 'COUNT(*), SUM(price), SUM(quantity), SUM(price)/ SUM(quantity), SUM(price)/ COUNT(*)';
				break;

			default:
				
				break;
		}

		//busca na tabela pedidos relativos ao periodo entre start_date e end_date, tendo $coluna como unico resultado

		$orders_in_period = "SELECT ".$coluna." FROM product_order 			
							WHERE `order_date` >= '".$this -> start_date."' 
							AND `order_date` <= '".$this -> end_date."'";

		if($select_orders = mysqli_query($this -> db_conn, $orders_in_period)) { 

			return $select_orders;			//retorna array com resultado da query
		}
		else {
			
			return null;					//retorna Nulo caso haja algum erro no MySQL
		}
	}

	/**
	 * Retorna o total de pedidos efetuados no período.
	 * 
	 * @return integer Total de pedidos.
	 */
	public function getOrdersCount() {

		$count_orders = mysqli_fetch_array($this -> getOrdersInSQL('count'));	//retorna COUNT(*) dos pedidos no periodo				 	
		return $count_orders[0]; 
	}

	/**
	 * Retorna a receita total de pedidos efetuados no período.
	 * 
	 * @return float Receita total no período.
	 */
	public function getOrdersRevenue() {

		$revenue_orders = mysqli_fetch_array($this -> getOrdersInSQL('revenue'));  //retorna SUM(price) dos pedidos no periodo
		
		return $revenue_orders[0];
	}

	/**
	 * Retorna o total de produtos vendidos no período (soma de quantidades).
	 * 
	 * @return integer Total de produtos vendidos.
	 */
	public function getOrdersQuantity() {
		
		$quantity_orders = mysqli_fetch_array($this -> getOrdersInSQL('quantity'));  //retorna SUM(quantity) dos pedidos no periodo
		
		return $quantity_orders[0];
	}

	/**
	 * Retorna o preço médio de vendas (receita / quantidade de produtos).
	 * 
	 * @return float Preço médio de venda.
	 */
	public function getOrdersRetailPrice() {
		
		$retail_orders = mysqli_fetch_array($this -> getOrdersInSQL('retail_price'));
		
		return round($retail_orders[0], 2); //arredondamento de 2 casas do valor original
	}

	/**
	 * Retorna o ticket médio de venda (receita / total de pedidos).
	 * 
	 * @return float Ticket médio.
	 */
	public function getOrdersAverageOrderValue() {

		$average_orders = mysqli_fetch_array($this -> getOrdersInSQL('average_value'));
		
		return round($average_orders[0], 2); //arredondamento de 2 casas do valor original

	}

	public function getOrdersToJSON($start_date, $end_date) {


		$this -> setStartDate($start_date);
		$this -> setEndDate($end_date);

		$json_orders = mysqli_fetch_array($this -> getOrdersInSQL('JSON'));

		//passa as variaveis para um array e as converte explicitamente para remover as aspas duplas de cada item
		$values_array = array(
						'orders' => array(
							'count' => (int)$json_orders[0], 
							'revenue' => (float)$json_orders[1],
							'quantity' => (int)$json_orders[2],
							'averageRetailPrice' => round((float)$json_orders[3], 2), 
							'averageOrderValue' => round((float)$json_orders[4], 2)
						)
					);

		return json_encode($values_array);
	}
	
}

?>