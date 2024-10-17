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
        
        
        public function getPostLikesComments($table, $conditions) {
            $whereSql = '';
            $params = [];
        
            // Build the WHERE clause based on conditions
            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = :" . $key;  // Use placeholders
                    $params[$key] = $value;  // Bind values
                    $i++;
                }
            }
        
            // SQL Query to get posts with likes and comments using LEFT JOIN
            $sql = "
                SELECT 
                    p.id as post_id, 
                    p.title, 
                    p.category, 
                    p.summary, 
                    p.status, 
                    p.content, 
                    p.created_at, 
                    p.updated_at, 
                    p.img, 
                    COUNT(l.post_id) AS total_likes,  -- Count distinct likes per post
                    COUNT(c.comment_id) AS total_comments -- Count distinct comments per post
                FROM $table p
                LEFT JOIN likes l ON p.id = l.post_id  -- LEFT JOIN to include posts without likes
                LEFT JOIN comments c ON p.id = c.post_id  -- LEFT JOIN to include posts without comments
                $whereSql
                GROUP BY p.id
            ";
        
            $statement = $this->db->prepare($sql);
            $statement->execute($params);
        
            // Fetch the result
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getPostCommentsWithAuthors($post_id) {
            try {
                // SQL Query to get all comments associated with a post and their author information
                $sql = "
                    SELECT 
                        c.comment_id, 
                        c.post_id, 
                        c.content, 
                        c.created_at, 
                        u.id AS user_id,          -- Alias to clarify which table the ID is from
                        CONCAT(u.first_name, ' ', u.last_name) AS full_name,  -- Concatenate first and last name
                        u.email                    -- Select additional user fields as needed
                    FROM comments c
                    LEFT JOIN users u ON c.user_id = u.id  -- Left join to include all comments regardless of user existence
                    WHERE c.post_id = :post_id              -- Filter by post_id
                    ORDER BY c.created_at DESC;             -- Optional: Order comments by creation date
                ";
        
                // Prepare and execute the statement
                $statement = $this->db->prepare($sql);
                $statement->execute(['post_id' => $post_id]);
        
                // Fetch the result
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            } catch (Exception $e) {
                // Handle any other exceptions
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }
        
        
        
        
        
        
        
    }
?>