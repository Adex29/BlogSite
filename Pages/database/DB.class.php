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

        public function __destruct(){
            $this->db = null;
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
                    $whereSql .= $pre . $key . " = :".$key;
                    $params[$key] = $value;
                    $i++;
                }
            }

            $sql = 'SELECT * FROM ' . $table . $whereSql;
            $statement = $this->db->prepare($sql);
            $statement->execute($params); 
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);

            return !empty($users) ? $users : [];
        }

        

        public function update($table, $data, $conditions) { 
            if (!empty($data) && is_array($data)) { 
                $colvalSet = []; 
                $whereSql = ''; 
                $params = [];
        
                if (!array_key_exists('updated_at', $data)) { 
                    $data['updated_at'] = date("Y-m-d H:i:s"); 
                }
        
                foreach ($data as $key => $val) { 
                    $colvalSet[] = "$key = :$key";
                    $params[":$key"] = $val;
                }
        
                if (!empty($conditions) && is_array($conditions)) { 
                    $whereSql .= ' WHERE '; 
                    $i = 0;
        
                    foreach ($conditions as $key => $value) { 
                        $pre = ($i > 0) ? ' AND ' : ''; 
                        $whereSql .= $pre . "$key = :cond_$key";
                        $params[":cond_$key"] = $value;
                        $i++; 
                    } 
                } 
        
                $sql = "UPDATE $table SET " . implode(', ', $colvalSet) . $whereSql; 
                $query = $this->db->prepare($sql); 
        
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
                    $whereSql .= $pre . $key . " = :".$key;
                    $params[$key] = $value; 
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
        
            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = :" . $key;
                    $params[$key] = $value;
                    $i++;
                }
            }
        
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
                    COUNT(DISTINCT(l.post_id)) AS total_likes,  -- Count distinct likes per post
                    COUNT(DISTINCT(c.comment_id)) AS total_comments -- Count distinct comments per post
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
    
                $statement = $this->db->prepare($sql);
                $statement->execute(['post_id' => $post_id]);
        
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            } catch (Exception $e) {
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }


        public function searchPost($table, $conditions) {
            $whereSql = '';
            $params = [];
        
            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " LIKE :" . $key;
                    $params[$key] = '%' . $value . '%'; 
                    $i++;
                }
            }
        
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
    
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        
        
        
        
        
    }
?>