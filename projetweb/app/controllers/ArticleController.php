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
        //charge le model Article
        $this->loadModel();

        //cherche toutes les données de la table Article
        $article = $this->Article->find();

        $this->set(compact('article'));
        //affiche la vue accueil.html
        $this->render('accueil');
    }

    public function recette()
    {
        //charge la vue recettes.html
        $this->render('recettes');
    }
    public function international(){
        $this->loadModel();

        //cherche les articles de catégorie internationale en faisant une jointure
        //entre la table article et catégorie
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