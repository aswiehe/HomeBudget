<?php
class Entity {

// START:   CLASS - PROPERTIES
    
    // START:   DATABASE PROPERTIES

        // Table: entities
        public $entities_id;
        public $shorthand;
        public $people_id;
        public $companies_id;
        public $departments_id;
        public $phones_id;
        public $emails_id;
        public $addresses_id;
        public $short_description;
        public $long_description;

        // Table: people
        public $first_name;
        public $middle_name;
        public $last_name;
        public $suffix;
        public $nickname;

        // Table: companies
        public $company_name;
        public $company_category;   

        // Table: departments
        public $department_name;

        // Table: phones
        public $country_code;
        public $area_code;
        public $exchange_code;
        public $line_number;
        public $extension; 

        // Table: emails
        public $email_user;
        public $email_domain; 

        // Table: addresses
        public $address_line_one;
        public $address_line_two;
        public $city;
        public $state;
        public $zip_five;
        public $zip_four; 
        
    // END:      DATABASE PROPERTIES

// END:     CLASS - PROPERTIES

// START:   CLASS CONSTRUCTOR
    function __construct() {

    }
// END:     CLASS CONSTRUCTOR

// START:   CLASS - METHODS

    // END:     CRUD METHODS 

        // START:   CREATE METHODS
            function create_entity($shorthand, $short_description, $long_description) {
                $this->shorthand = $shorthand;
                $this->short_description = $short_description;
                $this->long_description = $long_description;
                $this->people_id = '';
                $this->companies_id = '';
                $this->departments_id = '';
                $this->phones_id = '';
                $this->emails_id = '';
                $this->addresses_id = '';
                $this->entities_id = '';
            }
            function create_person($first_name, $middle_name, $last_name, $suffix, $nickname) {
                $this->first_name = $first_name;
                $this->middle_name = $middle_name;
                $this->last_name = $last_name;
                $this->suffix = $suffix;
                $this->nickname = $nickname;
                $this->departments_id = '';
                $this->people_id = '';
            }
            function create_department($department_name) {
                $this->department_name = $department_name;
                $this->companies_id = '';
                $this->departments_id = '';
            }
            function create_phone($country_code, $area_code, $exchange_code, $line_number, $extension) {
                $this->country_code = $country_code;
                $this->area_code = $area_code;
                $this->exchange_code = $exchange_code;
                $this->line_number = $line_number;
                $this->extension = $extension;
                $this->phones_id = '';
            }
            function create_email($email_user, $email_domain) {
                $this->email_user = $email_user;
                $this->email_domain = $email_domain;
                $this->emails_id = '';
            }
            function create_address() {
                $this->address_line_one = $address_line_one;
                $this->address_line_two = $address_line_two;
                $this->city = $city;
                $this->state = $state;
                $this->zip_five = $zip_five;
                $this->zip_four = $zip_four;
                $this->addresses_id = '';
            }
        // END:     CREATE METHODS
        
        // START:   INSERT METHODS
            function insert_entity($shorthand, $short_description, $long_description) {
                $this->shorthand = $shorthand;
                $this->short_description = $short_description;
                $this->long_description = $long_description;
                $people_id = $this->people_id;
                $companies_id = $this->companies_id;
                $departments_id = $this->departments_id;
                $phones_id = $this->phones_id;
                $emails_id = $this->emails_id;
                $addresses_id = $this->addresses_id;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO entities (shorthand, people_id, companies_id, departments_id, phones_id, emails_id, addresses_id, short_description, long_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('siiiiiiss', $shorthand, $people_id, $companies_id, $departments_id, $phones_id, $emails_id, $addresses_id, $short_description, $long_description);
                $stmt->execute();
                $this->entities_id = $stmt->insert_id;
            }
            function insert_person($first_name, $middle_name, $last_name, $suffix, $nickname) {
                $this->first_name = $first_name;
                $this->middle_name = $middle_name;
                $this->last_name = $last_name;
                $this->suffix = $suffix;
                $this->nickname = $nickname;
                $departments_id = $this->departments_id;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO people (first_name, middle_name, last_name, suffix, nickname) VALUES (?, ?, ?, ?, ?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('sssss', $first_name, $middle_name, $last_name, $suffix, $nickname);
                $stmt->execute();
                $this->people_id = $stmt->insert_id;
            }
            function insert_company($company_name, $company_category) {
                $this->company_name = $company_name;
                $this->company_category = $company_category;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO companies (company_name, company_category) VALUES (?, ?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('ss', $company_name, $company_category);
                $stmt->execute();
                $this->companies_id = $stmt->insert_id;
            }            
            function insert_department($department_name) {
                $this->department_name = $department_name;
                $companies_id = $this->companies_id;
                $departments_id = $this->departments_id;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO departments (department_name) VALUES (?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('s', $department_name);
                $stmt->execute();
                $this->departments_id = $stmt->insert_id;
            }
            function insert_phone($country_code, $area_code, $exchange_code, $line_number, $extension) {
                $this->country_code = $country_code;
                $this->area_code = $area_code;
                $this->exchange_code = $exchange_code;
                $this->line_number = $line_number;
                $this->extension = $extension;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO phones (country_code, area_code, exchange_code, line_number, extension) VALUES (?, ?, ?, ?, ?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('sssss', $country_code, $area_code, $exchange_code, $line_number, $extension);
                $stmt->execute();
                $this->phones_id = $stmt->insert_id;
            }
            function insert_email($email_user, $email_domain) {
                $this->email_user = $email_user;
                $this->email_domain = $email_domain;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO emails (email_user, email_domain) VALUES (?, ?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('ss', $email_user, $email_domain);
                $stmt->execute();
                $this->emails_id = $stmt->insert_id;
            }
            function insert_address($address_line_one, $address_line_two, $city, $state, $zip_five, $zip_four) {
                $this->address_line_one = $address_line_one;
                $this->address_line_two = $address_line_two;
                $this->city = $city;
                $this->state = $state;
                $this->zip_five = $zip_five;
                $this->zip_four = $zip_four;
 
                $conn = new DbConnection();
                $insert_query = "INSERT INTO addresses (address_line_one, address_line_two, city, state, zip_five, zip_four) VALUES (?, ?, ?, ?, ?, ?)";
                $mysqli = $conn->schema_connect('finfig_entities');
                $stmt = $mysqli->prepare($insert_query);
                $stmt->bind_param('ssssss', $address_line_one, $address_line_two, $city, $state, $zip_five, $zip_four);
                $stmt->execute();
                $this->addresses_id = $stmt->insert_id;
            }
        // END:     INSERT METHODS
    
        // START:   SELECT METHODS
            function search_for_company($search_terms) {
                $data = array();
                foreach($search_terms as $search_term) {
                    $search_term = "%$search_term%";
                    $conn = new DbConnection();
                    $query = 'SELECT * FROM companies WHERE company_name LIKE ?';
                    $mysqli = $conn->schema_connect('finfig_entities');
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('s', $search_term);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                }
                return $data;
            }
        // END:     SELECT METHODS

    // END:     CRUD METHODS

    // START:   SETTERS & GETTERS

        // START:   ENTITIES - SETTERS & GETTERS
            // START:   SETTERS
                function set_entities_id($entities_id) {
                    $this->entities_id = $entities_id;
                }
                function set_shorthand($shorthand) {
                    $this->shorthand = $shorthand;
                }
                function set_people_id($people_id) {
                    $this->people_id = $people_id;
                }
                function set_companies_id($companies_id) {
                    $this->companies_id = $companies_id;
                }
                function set_phones_id($phones_id) {
                    $this->phones_id = $phones_id;
                }
                function set_addresses_id($addresses_id) {
                    $this->addresses_id = $addresses_id;
                }
                function set_short_description($short_description) {
                    $this->short_description = $short_description;
                }
                function set_long_description($long_description) {
                    $this->long_description = $long_description;
                }
            // END:     SETTERS
            // START:   GETTERS
                function get_entities_id() {
                    return $this->entities_id;
                }
                function get_entity_shorthand() {
                    return $this->entity_shorthand;
                }
                function get_people_id() {
                    return $this->people_id;
                }
                function get_companies_id() {
                    return $this->companies_id;
                }
                function get_phones_id() {
                    return $this->phones_id;
                }
                function get_addresses_id() {
                    return $this->addresses_id;
                }
                function get_short_entity_description() {
                    return $this->short_entity_description;
                }
                function get_long_entity_description() {
                    return $this->long_entity_description;
                }
            // END:     GETTERS
        // END:     ENTITIES - SETTERS & GETTERS

        // START:   PEOPLE - SET & GET
            // START:   SETTERS
                function set_first_name($first_name) {
                    $this->first_name = $first_name;
                }
                function set_middle_name($middle_name) {
                    $this->middle_name = $middle_name;
                }
                function set_last_name($last_name) {
                    $this->last_name = $last_name;
                }
                function set_suffix($suffix) {
                    $this->suffix = $suffix;
                }
                function set_nickname($nickname) {
                    $this->nickname = $nickname;
                } 
            // END:     SETTERS
            // START:   GETTERS
                function get_first_name() {
                    return $this->first_name;
                }
                function get_middle_name() {
                    return $this->middle_name;
                }
                function get_last_name() {
                    return $this->last_name;
                }
                function get_suffix() {
                    return $this->suffix;
                }
                function get_nick_name() {
                    return $this->nick_name;
                }
            // END:     GETTERS 
        // END:     PEOPLE - SET & GET

        // START:   COMPANIES - SET & GET
            // START:   SETTERS
                function set_company_name($company_name) {;
                    $this->company_name = $company_name;
                }
                function set_company_category($company_category) {
                    $this->category = $company_category;
                }   
            // END:     SETTERS
            // START:   GETTERS
                function get_company_name() {
                    return $this->company_name;
                }
                function get_category() {
                    return $this->category;
                } 
            // END:     GETTERS  
        // END:     COMPANIES - SET & GET

        // START:   DEPARTMENTS - SET & GET
            // START:   SETTERS
                function set_department_name($department_name) {
                    $this->department_name = $department_name;
                }
            // END:     SETTERS
            // START:   GETTERS
                function get_department_name() {
                    return $this->department_name;
                }
            // END:     GETTERS
        // END:     DEPARTMENTS - SET & GET
        
        // START:   PHONES - SET & GET
            // START:   SETTERS
                function set_country_code($country_code) {
                    $this->country_code = $country_code;
                }
                function set_area_code($area_code) {
                    $this->area_code = $area_code;
                }
                function set_exchange_code($exchange_code) {
                    $this->exchange_code = $exchange_code;
                }
                function set_line_number($line_number) {
                    $this->line_number = $line_number;
                }
                function set_extension($extension) {
                    $this->extension = $extension;
                } 
            // END:     SETTERS
            // START:   GETTERS
                function get_country_code($country_code) {
                    return $this->country_code;
                }
                function get_area_code($area_code) {
                    return $this->area_code;
                }
                function get_exchange_code($exchange_code) {
                    return $this->exchange_code;
                }
                function get_line_number($line_number) {
                    return $this->line_number;
                }
                function get_extension($extension) {
                    return $this->extension;
                } 
            // END:     GETTERS
        // END:     PHONES - SET & GET
        
        // START:   EMAILS - SET & GET
            // START:   SETTERS
                function set_email_user($email_user) {
                    $this->email_user = $email_user;
                }
                function set_email_domain($email_domain) {
                    $this->email_domain = $email_domain;
                } 
            // END:     SETTERS
            // START:   GETTERS
                function get_user_name() {
                    return $this->user_name;
                }
                function get_domain_name() {
                    return $this->domain_name;
                } 
            // END:     GETTERS
                // END:     EMAILS - SET & GET
        
        // END:     EMAILS - SET & GET
        
        // START:   ADDRESSES - SET & GET
            // START:   SETTERS
                function set_address_line_one($address_line_one) {
                    $this->address_line_one = $address_line_one;
                }
                function set_address_line_two($address_line_two) {
                    $this->address_line_two = $address_line_two;
                }
                function set_city($city) {
                    $this->city = $city;
                }
                function set_state($state) {
                    $this->state = $state;
                }
                function set_zip_five($zip_five) {
                    $this->zip_five = $zip_five;
                }
                function set_zip_four($zip_four) {
                    $this->zip_four = $zip_four;
                } 
            // END:     SETTERS
            // START:   GETTERS
                function get_line_one() {
                    return $this->line_one;
                }
                function get_line_two() {
                    return $this->line_two;
                }
                function get_city() {
                    return $this->city;
                }
                function get_state() {
                    return $this->state;
                }
                function get_zip_code_five() {
                    return $this->zip_code_five;
                }
                function get_zip_code_four() {
                    return $this->zip_code_four;
                }
            // END:     GETTERS
        // END:     ADDRESSES - SET & GET

    // END:     SETTERS & GETTERS

// END:     CLASS - METHODS


}
?>