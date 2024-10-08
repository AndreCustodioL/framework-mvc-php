<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page{

    /**
     * Método responsável por retornar o contéudo (view) da nossa home
     * @return string
     */
    public static function getHome(){
        //ORGANIZACAO
        $obOrganization = new Organization;

        //VIEW DA HOME
        $content = View::render('pages/home', [
            'name' => $obOrganization->name
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('André Custodio - Home',$content);
    }

}