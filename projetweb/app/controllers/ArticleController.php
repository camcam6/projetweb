<?php
/**
 * Created by PhpStorm.
 * User: Camille
 * Date: 02/11/2016
 * Time: 14:19
 */

namespace app\controllers;


use core\AppController;


class ArticleController extends AppController{

    public function accueil(){
        $this->loadModel();

        $article = $this->Article->find();

        $this->set(compact('article'));
        $this->render('accueil');
    }

    public function recette()
    {
        $this->render('recettes');
    }
    public function international(){
        $this->loadModel();

        $international = $this->Article->find(
            [
                'where'=>[
                    'nom_categorie'=>'International'
                ]
            ]
            ,[
            'categorie' => [
                'categorie.num','article.num_categorie'
            ]]

            );

        $this->set(compact('international'));
        $this->render('international');
    }

    public function sport(){
        $this->loadModel();

        $sport = $this->Article->find(
            [
                'where'=>[
                    'nom_categorie'=>'Sport'
                ]
            ]
            ,[
                'categorie' => [
                    'categorie.num','article.num_categorie'
                ]]

        );

        $this->set(compact('sport'));
        $this->render('sport');
    }

}