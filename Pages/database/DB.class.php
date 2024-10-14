<?php 
    // include "../constants.php";
    class DB
    { 
        private $db;
        private $dbHost     = "localhost"; 
        private $dbUsername = "root"; 
        private $dbPassword = ""; 
        private $dbName     = "blogsite"; 
         
        public function __construct()
        { 
            if(!isset($this->db))
            { 
                // Connect to the database 
                try{ 
                    $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword); 
                    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                    $this->db = $conn; 
                }catch(PDOException $e)
                { 
                    die("Failed to connect with MySQL: " . $e->getMessage()); 
                } 
            } 
        } 

        /*INSERT*/
        public function insert($table, $data)
        { 
            if(!empty($data) && is_array($data))
            { 
                $columns = ''; 
                $values  = ''; 
                $i = 0; 
     
                $columnString = implode(',', array_keys($data)); 
                $valueString = ":".implode(',:', array_keys($data)); 

                $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")"; 

                $query = $this->db->prepare($sql); 

                foreach($data as $key=>$val)
                { 
                     $query->bindValue(':'.$key, $val); 
                } 
                $insert = $query->execute(); 

                return $insert ? $this->db->lastInsertId() : false; 
            }else
            { 
                return false; 
            } 
        }

        public function getRows($table = "", $conditions = array()){
            $whereSql = '';
            $params = [];

            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i = 0;

                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = :".$key; // Use named placeholders
                    $params[$key] = $value; // Store the values for binding
                    $i++;
                }
            }

            $sql = 'SELECT * FROM ' . $table . $whereSql;
            $statement = $this->db->prepare($sql);
            $statement->execute($params); // Bind the parameters

            // Fetch results
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);

            return !empty($users) ? $users : [];
        }

        

        public function update($table, $data, $conditions) { 
            if (!empty($data) && is_array($data)) { 
                // Prepare SET clause
                $colvalSet = []; 
                $whereSql = ''; 
                $params = []; // Array for storing parameters for prepared statement
        
                // Check if 'modified' is not present and set it
                if (!array_key_exists('updated_at', $data)) { 
                    $data['updated_at'] = date("Y-m-d H:i:s"); 
                }
        
                foreach ($data as $key => $val) { 
                    $colvalSet[] = "$key = :$key"; // Use named placeholders
                    $params[":$key"] = $val; // Store the actual value for binding
                }
        
                if (!empty($conditions) && is_array($conditions)) { 
                    $whereSql .= ' WHERE '; 
                    $i = 0;
        
                    foreach ($conditions as $key => $value) { 
                        $pre = ($i > 0) ? ' AND ' : ''; 
                        $whereSql .= $pre . "$key = :cond_$key"; // Use named placeholders for conditions
                        $params[":cond_$key"] = $value; // Store condition value for binding
                        $i++; 
                    } 
                } 
        
                $sql = "UPDATE $table SET " . implode(', ', $colvalSet) . $whereSql; 
                $query = $this->db->prepare($sql); 
        
                // Execute the query with bound parameters
                $update = $query->execute($params); 
                return $update ? $query->rowCount() : false; 
            } else { 
                return false; 
            } 
        } 

        public function delete($table, $conditions){
            $whereSql = '';
            $params = [];
        
            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = :".$key;  // Use placeholders
                    $params[$key] = $value;  // Bind values
                    $i++;
                }
            }
        
            $sql = "DELETE FROM " . $table . $whereSql;
            $statement = $this->db->prepare($sql);
            $delete = $statement->execute($params);
        
            return $delete ? $statement->rowCount() : false;
        }        
    }
?>