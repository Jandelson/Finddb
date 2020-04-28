<?php
namespace finddb;

use \Doctrine\DBAL\Configuration;
use \Doctrine\DBAL\DriverManager;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use \ActiveRouter\Router;
use \finddb\Search;
use \Symfony\Component\Dotenv\Dotenv;

class Init
{
    public function __construct()
    {
        $config = new Configuration();

        $dotenv = new Dotenv();
        $dotenv->load('.env');

        $connectionParams = array(
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'charset' => $_ENV['DB_CHARSET'],
            'driver' => $_ENV['DB_CONNECTION']
        );

        $db = DriverManager::getConnection($connectionParams, $config);
        $loader = new FilesystemLoader('views');

        $twig = new Environment($loader);
        $search = new Search();
        $search->setDB($db);
        try {
            $dados = $search->searchData($_POST['consulta']);
            echo $twig->render('index.html', [
                'page_title' => 'Finddb',
                'content' => 'Busca no banco de dados',
                'dados' => $dados
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
            echo 'Renomear .env_exemplo para .env arquivo de configuração com o banco de dados!';
        }
    }
}
