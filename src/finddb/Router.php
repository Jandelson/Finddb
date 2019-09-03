<?php
/**
 * Roteador de url
 * Criado em Fri Jun 08 2018
 * PHP Version 7
 *
 * @category  Router
 * @package   finddb
 * @author    Jandelson Oliveira <jandelson_oliveira@yahoo.com.br>
 * @copyright 2019 Jandelson Oliveira
 * @version   Release: 1.0.0
 *
 * @todo
 */

namespace finddb;

class Router
{
    private $routers = [];
    private $actions = [];
    private $class;

    /**
     * Adição de rotas e ações
     *
     * @param string $uri url qual vai ser acessada
     * @param string $action  ação que a rota vai executar
     * @return void
     */
    public function newRouter(string $uri, string $action)
    {
        $this->routers[] = trim($uri, '/');
        $this->actions[] = $action;
    }

    /**
     * usado para analisar as rotas em ambiente de teste
     *
     * @return void
     */
    public function map()
    {
        print "<pre>";
        print_r($this->routers);
        print_r($this->actions);
    }

    /**
     * Executa as rotas
     * Pega o parametro uri para analisar
     * @return void
     */
    public function run()
    {
        $uri = $_GET['uri'];
        /**
         * Procura pela uri na lista de rotas
         */
        $chave = \array_search($uri, $this->routers);
        if ($chave === false) {
            echo 'Rota não encontrada!';
        } else {
            $this->class = "finddb\\".$this->actions[$chave];
            new $this->class();
        }
    }
}
