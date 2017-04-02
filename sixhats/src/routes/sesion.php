<?php


// Get All sesions
$app->get('/api/sesion', function(Request $request, Response $response){
    $sql = "SELECT * FROM sesion";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single sesion
$app->get('/api/user/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM sesion WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add User
$app->post('/api/user/add', function(Request $request, Response $response){
     $id = $request->getParam('id');
    $first_name = $request->getParam('First_Name');
    $last_name = $request->getParam('Last_Name');
    $login = $request->getParam('login');
    $password = $request->getParam('password');


    $sql = "INSERT INTO users (id,First_Name,Last_Name,login,password) VALUES
    (:id,:First_Name,:Last_Name,:login,:password)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':First_Name', $first_name);
        $stmt->bindParam(':Last_Name',  $last_name);
        $stmt->bindParam(':login',      $login);
        $stmt->bindParam(':password',   $password);
      

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update User
$app->put('/api/user/update/{id}', function(Request $request, Response $response){
    $id = $request->getParam('id');
    $first_name = $request->getParam('First_Name');
    $last_name = $request->getParam('Last_Name');
    $login = $request->getParam('login');
    $password = $request->getParam('password');



    $sql = "UPDATE users SET
				id 	        = :id,
				First_Name 	= :First_Name,
                Last_Name	= :Last_Name,
                login		= :login,
                password 	= :password
			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':First_Name', $first_name);
        $stmt->bindParam(':Last_Name',  $last_name);
        $stmt->bindParam(':login',      $login);
        $stmt->bindParam(':password',   $password);
      
        $stmt->execute();

        echo '{"notice": {"text": "User Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete User
$app->delete('/api/user/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM sesion WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "User Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
