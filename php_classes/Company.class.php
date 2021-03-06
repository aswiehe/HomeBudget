<?php

class Company {

    public $index_id;

    public $overview_id;
    public $company_name;
    public $company_classification;
    public $company_type;
    public $company_description_short;
    public $company_description_long;

    public $address_id;
    public $address_line_one;
    public $address_line_two;
    public $city;
    public $state;
    public $zip;

    public $contact_id;
    public $department;
    public $person_of_contact;
    public $email;
    public $country_code;
    public $area_code;
    public $exchange_code;
    public $line_number;
    public $extension;

    function __construct() {

    }

    function company_name_exists($company_name) {
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $query = "
            SELECT
                COUNT(overview_id)
            FROM
                overviews
            WHERE
                company_name = ?
        ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $company_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_rows = 0;
        while($row = $result->fetch_assoc()) {
            $num_rows++;
        }
        switch($num_rows) {
            case 0:
                return false;
            break;
            case 1:
                return true;
            break;
            default:
                die('There is a duplicate of this company');
            break;

        }
    }

    function source_company_name($company_name) {
        $this->company_name_exists($company_name);
        $this->company_name = $company_name;
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        
        $overview_query = "
            SELECT 
                overview_id,
                company_classification,
                company_type,
                company_description_short,
                company_description_long
            FROM 
                overviews
            WHERE 
                company_name = ?
        ";
        $stmt = $mysqli->prepare($overview_query);
        $stmt->bind_param('s', $company_name);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->overview_id = $row['overview_id'];
            $this->company_classification = $row['company_classification'];
            $this->company_type = $row['company_type'];
            $this->company_description_short = $row['company_description_short'];
            $this->company_description_long = $row['company_description_long'];
        }
        $index_query = "
            SELECT
                index_id,
                contact_id,
                address_id
            FROM
                indexes
            WHERE
                overview_id = ?
        ";
        $stmt = $mysqli->prepare($index_query);
        $stmt->bind_param('i', $this->overview_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->index_id = $row['index_id'];
            $this->contact_id = $row['contact_id'];
            $this->address_id = $row['address_id'];
        }
        $address_query = "
            SELECT
                line_one, line_two, city, state, zip_code
            FROM
                addresses
            WHERE
                address_id = ?
        ";
        $stmt = $mysqli->prepare($address_query);
        $stmt->bind_param('i', $this->address_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->address_line_one = $row['line_one'];
            $this->address_line_two = $row['line_two'];
            $this->city = $row['city'];
            $this->state = $row['state'];
            $this->zip = $row['zip_code'];
        }
        $contact_query = "
            SELECT
                department,
                person_of_contact,
                email,
                country_code,
                area_code,
                exchange_code,
                line_number,
                extension
            FROM
                contacts
            WHERE
                contact_id = ?
        ";
        $stmt = $mysqli->prepare($contact_query);
        $stmt->bind_param('i', $this->contact_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->department = $row['department'];
            $this->person_of_contact = $row['person_of_contact'];
            $this->email = $row['email'];
            $this->country_code = $row['country_code'];
            $this->area_code = $row['area_code'];
            $this->exchange_code = $row['exchange_code'];
            $this->line_number = $row['line_number'];
            $this->extension = $row['extension'];
        }
    }

    function set_company_overview($company_name, $company_classification, $company_type, $company_description_short, $company_description_long) {
        $this->company_name = $company_name;
        $this->company_classification = $company_classification;
        $this->company_type = $company_type;
        $this->company_description_short = $company_description_short;
        $this->company_description_long = $company_description_long;

        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $insert_query = "
            INSERT INTO overviews (
                `company_name`,
                `company_classification`,
                `company_type`,
                `company_description_short`,
                `company_description_long`
            ) VALUES (
                ?,
                ?,
                ?,
                ?,
                ?
            );
        ";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param(
            'sssss', 
            $company_name, 
            $company_classification, 
            $company_type, 
            $company_description_short, 
            $company_description_long
        );
        $stmt->execute();
        $select_query = "SELECT LAST_INSERT_ID()";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->overview_id = $row['LAST_INSERT_ID()'];
        }
    }

    function update_company_overview($company_name, $company_classification, $company_type, $company_description_short, $company_description_long) {
        $this->company_name = $company_name;
        $this->company_classification = $company_classification;
        $this->company_type = $company_type;
        $this->company_description_short = $company_description_short;
        $this->company_description_long = $company_description_long;

        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $update_query = "
            UPDATE 
                overviews
            SET
                `company_classification` = ?,
                `company_type` = ?,
                `company_description_short` = ?,
                `company_description_long` = ?
            WHERE
                company_name = ?
        ";
        $stmt = $mysqli->prepare($update_query);
        $stmt->bind_param(
            'sssss', 
            $company_classification, 
            $company_type, 
            $company_description_short, 
            $company_description_long,
            $company_name
        );
        $stmt->execute();
        $select_query = "
            SELECT
                overview_id
            FROM
                overviews
            WHERE
                company_name = ?
        ";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->overview_id = $row['overview_id'];
        }
    }

    function set_company_address($address_line_one, $address_line_two, $city, $state, $zip) {
        $this->address_line_one = $address_line_one;
        $this->address_line_two = $address_line_two;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;

        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $insert_query = "
            INSERT INTO addresses (
                line_one,
                line_two,
                city,
                state,
                zip_code
            ) VALUES (
                ?,
                ?,
                ?,
                ?,
                ?
            );
        ";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param(
            'sssss', 
            $address_line_one, 
            $address_line_two, 
            $city, 
            $state, 
            $zip
        );
        $stmt->execute();
        $select_query = "SELECT LAST_INSERT_ID()";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->address_id = $row['LAST_INSERT_ID()'];
        }
    }

    function update_company_address($address_line_one, $address_line_two, $city, $state, $zip) {
        $this->address_line_one = $address_line_one;
        $this->address_line_two = $address_line_two;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;

        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $update_query = "
            UPDATE 
                addresses 
            SET
                line_one = ?,
                line_two = ?,
                city = ?,
                state = ?,
                zip_code = ?,
            WHERE
                address_id = ?
        ";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param(
            'sssss', 
            $address_line_one, 
            $address_line_two, 
            $city, 
            $state, 
            $zip
        );
        $stmt->execute();
        $select_query = "SELECT LAST_INSERT_ID()";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->address_id = $row['LAST_INSERT_ID()'];
        }
    }
    function set_company_contact($department, $person_of_contact, $email, $area_code, $exchange_code, $line_number, $extension, $country_code = "+1") {
        $this->department = $department;
        $this->person_of_contact = $person_of_contact;
        $this->email = $email;
        $this->country_code = $country_code;
        $this->area_code = $area_code;
        $this->exchange_code = $exchange_code;
        $this->line_number = $line_number;
        $this->extension = $extension;
        
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $insert_query = "
            INSERT INTO contacts (
                department,
                person_of_contact,
                email,
                country_code,
                area_code,
                exchange_code,
                line_number,
                extension
            ) VALUES (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            );
        ";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param(
            'ssssssss', 
            $department, 
            $person_of_contact, 
            $email,
            $country_code, 
            $area_code, 
            $exchange_code, 
            $line_number, 
            $extension
        );
        $stmt->execute();
        $select_query = "SELECT LAST_INSERT_ID()";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->contact_id = $row['LAST_INSERT_ID()'];
        }
    }

    function set_company_index() {
        $contact_id = $this->contact_id;
        $address_id = $this->address_id;
        $overview_id = $this->overview_id;

        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $insert_query = "
            INSERT INTO indexes (
                contact_id,
                address_id,
                overview_id
            ) VALUES (
                ?,
                ?,
                ?
            );
        ";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param(
            'sss', 
            $contact_id, 
            $address_id, 
            $overview_id
        );
        $stmt->execute();
        $select_query = "SELECT LAST_INSERT_ID()";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->index_id = $row['LAST_INSERT_ID()'];
        }
    }

    function update_company_index($data_source) {
        $contact_id = $this->contact_id;
        $address_id = $this->address_id;
        $overview_id = $this->overview_id;

        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_companies');
        $insert_query = "
            UPDATE
                indqexes 
            SET
                contact_id = ?,
                address_id = ?,
                overview_id = ?
            ) VALUES (
                ?,
                ?,
                ?
            );
        ";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param(
            'sss', 
            $contact_id, 
            $address_id, 
            $overview_id
        );
        $stmt->execute();
        $select_query = "SELECT LAST_INSERT_ID()";
        $stmt = $mysqli->prepare($select_query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $this->index_id = $row['LAST_INSERT_ID()'];
        }

    }

}

?>