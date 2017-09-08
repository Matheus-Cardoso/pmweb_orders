# Sumário
Git da tarefa sobre status de pedidos, Pmweb

Exercício 1 - Criação de tabela
  A tabela product_order foi criada para satisfazer as necessidades dos dados (CSV), os valores de preços e quantidades podem atingir grande extensão sem prejudicarem a inserção, e com o formato que se encaixa nos requisitos. Mais informações na descrição dos campos (product_order.sql

Exercício 2 - Criação de Classe
  Os métodos já existentes foram programados para atender as necessidades tanto dos parametros quanto do retorno de cada um, em adição, foi criado um "controlador" para a parte que condiz com o Banco de dados: getOrdersInSQL. Este método recebe como parâmetro um indicador de onde o requerimento está vindo, para que a Query seja adaptada e satisfaça a necessidade de cada método. O arquivo 'config.php' recebeu uma adição de classe, para se manter o padrão do programa. O objeto da conexão é instanciado na inicialização de qualquer Objeto do tipo 'Pmweb_Orders_Stats'. Para fins de teste, alterar os valores no arquivo de config.

Exercício 3 - Json export
  Foi criado um .php para teste: 'GETester.php'. Nele as variáveis são inicializadas por parâmetros da URL, e, caso algum ou ambos estejam nulos, o programa utiliza de valores de datas que visam pegar o maior ou total numero de pedidos. Foi criado um método que retorna uma string formatada em JSON e utiliza do mesmo controlador citado no exercício 2.

URL de exemplo: http://localhost/GETtester.php?start_date=2017-06-17&end_date=2017-06-18
