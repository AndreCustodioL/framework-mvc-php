<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony{
    
    /**
     * ID do depoimento
     *
     * @var int
     */
    public $id;

    /**
     * Nome do usuário que fez o depoimento
     *
     * @var string
     */
    public $nome;

    /**
     * Data de publicação do depoimento
     *
     * @var string
     */
    public $data;

    /**
     * Mensagem do depoimento
     *
     * @var string
     */
    public $mensagem;
    
    /**
     * Status de deletado do depoimento
     *
     * @var boolean
     */
    public $deletado = 0;

    
    
    /**
     * Método responsável por cadastrar a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERE O DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data,
            'deletado' => $this->deletado
        ]);

        //SUCESSO
        return true;

    }
    
    /**
     * Método responsável por retornar Depoimentos
     *
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('depoimentos'))->select($where,$order,$limit,$fields);
    }

}