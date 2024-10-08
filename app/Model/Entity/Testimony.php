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
     * Método responsável por atualizar os dados do banco com a instância atual
     *
     * @return boolean
     */
    public function atualizar(){
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //ATUALIZA O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('depoimentos'))->update('id = '.$this->id,[
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data,
            'deletado' => $this->deletado
        ]);

    }

    /**
     * Método responsável por excluir um depoimento do banco de dados
     *
     * @return boolean
     */
    public function excluir(){
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');

        //EXCLUI O DEPOIMENTO NO BANCO DE DADOS
        return (new Database('depoimentos'))->delete('id = '.$this->id);

    }
    
    /**
     * Método responsável por retornar um depoimento com base no seu id
     *
     * @param  int $id
     * @return Testimony
     */
    public static function getTestimonyByid($id){
        return self::getTestimonies('id = '.$id)->fetchObject(self::class);
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