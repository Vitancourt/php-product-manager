<?php
ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);
error_reporting(0);

require_once "config.php";
require_once "../vendor/autoload.php";
use Core\Database;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
Database::run(new Capsule);
parse_str(implode('&', array_slice($argv, 1)), $_GET);
if (empty($_GET["file"])) {
    echo "Erro de parâmetro";
    echo "<br>";
    echo "Padrão: php -f import.php file=nome_arquivo";
    exit();
}
$file = $_GET["file"];

$delimitador = ';';

$data = array();

// Abrir arquivo para leitura
$f = fopen($file, 'r');
if ($f) { 

    // Ler cabecalho do arquivo
    $cabecalho = fgetcsv($f, 0, $delimitador);

    $i = 0;

    // Enquanto nao terminar o arquivo
    while (!feof($f)) { 

        // Ler uma linha do arquivo
        $linha = fgetcsv($f, 0, $delimitador);
        if (!$linha) {
            continue;
        }

        // Montar registro com valores indexados pelo cabecalho
        $registro = array_combine($cabecalho, $linha);

        $data[$i]['name'] = $registro['nome'];
        $data[$i]['sku'] = $registro['sku'];
        $data[$i]['description'] = $registro['descricao'];
        $data[$i]['price'] = $registro['preco'];
        $data[$i]['quantity'] = $registro['quantidade'];
        $data[$i]['categories'] = explode("|", $registro['categoria']);

        $i++;
    }
    fclose($f);
    foreach ($data as $d) {
        foreach ($d['categories'] as $c) {
            $categoria['name'] = $c;
            $categoria['code'] = $c;
            \Model\Category::insert($categoria);
        }
    }
    foreach ($data as &$d) {
        foreach ($d['categories'] as &$c) {
            $f = \Model\Category::get(null,$c);
            $c = $f[0]->id;
        }
        \Model\Product::insert($d);
    }
}
?>