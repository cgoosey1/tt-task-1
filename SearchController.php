<?php

class SearchController
{
    /**
     * Show search page
     *
     * @return void
     */
    public function searchPage() : void
    {
        include('view.php');
    }

    /**
     * Get all matching profiles based on name
     *
     * I feel I should have handled no data better, i.e. with 204/404 http code, but I'm skipping
     * that, and adding a comment instead.
     *
     * @return void
     */
    public function searchNames() : void
    {
        require_once('SearchModel.php');
        $searchModel = new SearchModel();
        $term = $_GET['term'];

        $data = $searchModel->getSearchData($term);

        // Set the content type, this helps JQuery parse the result
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);
    }
}