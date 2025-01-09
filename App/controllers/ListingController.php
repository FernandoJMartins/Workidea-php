<?php

namespace App\Controllers;
use Framework\Database;
use Framework\Validation;

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
    public function show($params) {
        $id = $params['id'] ?? '';
        $params = [
            "id" => $id
        ];
        
        $listing = $this->db -> query('SELECT * FROM listings where id = :id', $params) -> fetch();
        
        //Check if $listing exists
        if (!$listing){
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView("listings/show", [
            'listing' => $listing
        ]);
    }

    /**
     * Store in database
     *
     * @return void
     */
    public function store(){

        $allowedFields = ['title','requirements','salary','description','benefits',
        'company','address','city','state','phone','email'
        ];
  
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = 1;

        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title','salary','description','city','state','email'];
        $errors = [];

        foreach($requiredFields as $field) {
            if(empty($newListingData[$field]) || !Validation::string($newListingData[$field])){
                $errors[$field] = ucfirst($field) . " is required";
            };
        }

        if (!empty($errors)){
            // Reload view
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        }
        else {
           
            $fields = [];

            foreach($newListingData as $field => $value){
                $fields[] = $field;

                if ($value === ''){
                    $newListingData[$field] = null;
                }
                $values[] = ":" . $field;
            }

            $fields = implode(', ', $fields);
            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
            $this -> db -> query($query, $newListingData);
            
            header('Location: /public/listings/');
            exit;
        }
    }

    public function delete($params){
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();
    
        if(!$listing){
            ErrorController::notFound('Listing not found');
            return;
        }
        
        $this -> db -> query('DELETE FROM listings WHERE id = :id', $params);
        header('Location: /public/listings/');
        exit;
    }
}