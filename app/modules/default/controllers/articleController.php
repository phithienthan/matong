<?php

/*
 * @author quyetnd
 */

Class articleController Extends defaultController
{

    public function indexAction()
    {
        
    }

    public function viewdetailAction()
    {
        $articleModel = $this->model->get('article');
        $categoryModel = $this->model->get('category');
        $articleId = $this->request->queryString("id");
        $article = $articleModel->getArticleInfo($articleId, 1);
        $categoryId = $article['category_id'];
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        // Get other article
        $top = 11;
        $articles = $articleModel->getAllArticlesByCategoryId($categoryId, 1, $top);                
        $this->view->data['articles'] = $articles;        
        // Set a template variable
        $this->view->data['categoryInfo'] = $categoryInfo;
        $this->view->data['article'] = $article;

        $this->view->setTitle($article["title"]);
        $this->view->setDescription($article["title"]);
        $this->view->setKeywords($article["title"]);
        // Load the index template
        $this->view->show('view_detail');
    }

    public function listAction()
    {
        $articleModel = $this->model->get('article');
        $categoryModel = $this->model->get('category');
        $categoryId = $this->request->queryString("id");
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = 1;
        }
        $pageSize = 20;
        $articles = $articleModel->getAllArticlesByCategoryId($categoryId, $page, $pageSize);
        // Set a template variable
        $this->view->data['categoryInfo'] = $categoryInfo;
        $this->view->data['articles'] = $articles;

        $this->view->setTitle($categoryInfo["title"]);
        $this->view->setDescription($categoryInfo["title"]);
        $this->view->setKeywords($categoryInfo["title"]);
        // Load the index template
        $this->view->show('list');
    }

}

?>