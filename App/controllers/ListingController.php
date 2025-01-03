<?php

namespace App\Controllers;
use Framework\Database;

class ListingController {

    protected $db;

    public function __construct(){
        $config = require basePath("config/db.php");
        $this->db = new Database($config);;
    }

    
    /**
     * Show the main page
     *
     * @return void
     */
    public function index() {
        $listings  = $this->db -> query('SELECT * FROM listings') -> fetchAll();
        loadView('listings/index', ['listings' => $listings]);
        
    }

    /**
     * Show the create Listing form
     *
     * @return void
     */
    public function create() {
        loadView('listings/create');
    }

    /**
     * Show a single Listing form
     *
     * @return void
     */
    public function show() {
        $id = $_GET['id'] ?? '';
        $params = [
            "id" => $id
        ];
        
        $listing = $this->db -> query('SELECT * FROM listings where id = :id', $params) -> fetch();
        
        loadView("listings/show", [
            'listing' => $listing
        ]);
    }
}