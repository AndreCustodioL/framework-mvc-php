<?php

namespace App\Controller\Api;

use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api{

    /**
     * Método responsável por obter a renderização dos itens de dpoimentos para a página
     * @param Request $request
     * @param Pagination $obPagination
     * @return void
     */
    private static function getTestimonyItems($request,&$obPagination){
        //DEPOIMENTOS
        $itens = [];

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal = EntityTestimony::getTestimonies('deletado = 0',null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PÁGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //QUANTIDADE POR PÁGINA
        $qtdPagina = $queryParams['results'] ?? 5;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal,$paginaAtual,$qtdPagina);

        //RESULTADOS DA PÁGINA
        $results = EntityTestimony::getTestimonies('deletado = 0','id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            //VIEW DE DEPOIMENTOS
            $itens[] = [
                'id' => (int)$obTestimony ->id,
                'nome' => $obTestimony ->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => $obTestimony->data
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $itens;
        
    }
    
    /**
     * Método responsável por retornar os depoimentos cadastrados
     *
     * @param  Request $request
     * @return array
     */
    public static function getTestimonies($request){
        return [
            'depoimentos' => self::getTestimonyItems($request,$obPagination),
            'paginacao'   => parent::getPagination($request,$obPagination)
        ];
    }
    
    /**
     * Método responsável por retornar os detalhes de um depoimentp
     *
     * @param  Request $request
     * @param  int $id
     * @return array
     */
    public static function getTestimony($request,$id){
        //VALIDA O ID DO DEPOIMENTO
        if(!is_numeric($id)){
            throw new \Exception("O id '".$id."' Não é válido",400);
        }


        //BUSCA DEPOIMENTO
        $obTestimony = EntityTestimony::getTestimonyByid($id);

        //VALIDA SE O DEPOIMENTO EXISTE
        if(!$obTestimony instanceof EntityTestimony) {
            throw new \Exception("O Depoimento ".$id." Não foi encontrado",404);
        }

        //RETORNA OS DETALHES DO DEPOIMENTO
        return [
            'id' => (int)$obTestimony ->id,
            'nome' => $obTestimony ->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }

}