<?php
namespace App\Table;

use Core\Table\Table;

class PostTable extends Table {

    protected $table = 'articles';
    /**
     * Recup les derniers posts
     * @return array
     */

    public function last() {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, categories.titre as categorie
            FROM articles 
            LEFT JOIN categories ON articles.category_id = categories.id
            ");
    }

    /**
     * Recup les derniers articles de la category demandee
     * @param $category_id int
     * @return array
     */

    public function lastByCategory($category_id) {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, categories.titre as categorie
            FROM articles 
            LEFT JOIN categories ON articles.category_id = categories.id
            WHERE articles.category_id = ?", [$category_id]);
    }
    /**
     * Recup un article en liant la cat associee
     * @param $id int
     * @return \App\Entity\PostEntity
     */
    public function find($id) {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, categories.titre as categorie
            FROM articles 
            LEFT JOIN categories ON articles.category_id = categories.id
            WHERE articles.id = ?", [$id], true);
    }
}