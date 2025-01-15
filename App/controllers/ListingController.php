<?php

namespace App\Controllers;
use Framework\Database;
use Framework\Session;
use Framework\Validation;
use Framework\Authorization;

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
        $listings  = $this->db -> query('SELECT * FROM listings ORDER BY created_at DESC') -> fetchAll();
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

        $newListingData['user_id'] = Session::get('user')['id'];

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

        //authorization
        if(!Authorization::isOwner($listing->user_id)){
            $_SESSION['error_message'] =  'You are not allowed to delete this listing';
            header('Location: /public/listings/' . $listing->id);
            exit;
        }
        
        

        
        $this -> db -> query('DELETE FROM listings WHERE id = :id', $params);
        
        $_SESSION['success_message'] = 'Listing deleted';
        
        header('Location: /public/listings/');
        exit;
    }


        /**
     * Edit a Listing form
     *
     * @param array $params
     * @return void
     */
    public function edit($params) {
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

        loadView("listings/edit", [
            'listing' => $listing
        ]);
    }


        /**
     * Update a Listing form
     *
     * @param array $params
     * @return void
     */
    public function update($params) {
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

        $allowedFields = ['title','requirements','salary','description','benefits',
        'company','address','city','state','phone','email'
        ];

        $values = [];
        $values = array_intersect_key($_POST, array_flip($allowedFields));
        $values = array_map('sanitize', $values);


        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach($requiredFields as $field) {
            if(empty($values[$field]) || !Validation::string($values[$field])){
                $errors[$field] = ucfirst($field) . " is required";
            };
        };

        if (!empty($errors)){
            // Reload view
            loadView('listings/edit', [
                'errors' => $errors,
                'listing' => $listing
            ]);
            exit;
        }
        else {
            $updateFields = [];

            foreach(array_keys($values) as $v){
                $updateFields[] = "{$v} = :{$v}";
            }
            
            $updateFields = implode(', ', $updateFields);


           
            $q = "UPDATE listings SET $updateFields WHERE id = :id";
            $values['id'] = $id;
            $this -> db -> query ($q, $values);

            $_SESSION['success_message'] = 'Listing Updated';
            header('Location: /public/listings/' . $id);
            exit;
        }
        
    }
}