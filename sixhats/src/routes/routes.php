<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get All Users
$app->get('/api/users', function(Request $request, Response $response){
    $sql = "SELECT * FROM users";

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

// Get Single User
$app->get('/api/user/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM users WHERE id = $id";

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
    $email = $request->getParam('email');
    $level = $request->getParam('level');

    $sql = "INSERT INTO users (id,First_Name,Last_Name,login,password,email,level) VALUES
    (:id,:First_Name,:Last_Name,:login,:password,:email,:level)";

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
        $stmt->bindParam(':email',   $email);
        $stmt->bindParam(':level',   $level);  

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update User
$app->put('/api/user/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('First_Name');
    $last_name = $request->getParam('Last_Name');
    $login = $request->getParam('login');
    $password = $request->getParam('password');
    $email = $request->getParam('email');
    $level = $request->getParam('level');

    $sql = "UPDATE users SET
				id 	        = :id,
				First_Name 	= :First_Name,
                Last_Name	= :Last_Name,
                login		= :login,
                password 	= :password,
                email       = :email,
                level       = :level
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
        $stmt->bindParam(':email',   $email);
        $stmt->bindParam(':level',   $level);

        $stmt->execute();

        echo '{"notice": {"text": "User Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete User
$app->delete('/api/user/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM users WHERE id = $id";

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
$app->get('/api/sesion/{id}', function(Request $request, Response $response){
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


// Add Sesion
$app->post('/api/sesion/add', function(Request $request, Response $response){
    $id = $request->getParam('id');
    $Domain_Name = $request->getParam('Domain_Name');
    $Project_Name = $request->getParam('Project_Name');
    $Nr_of_users = $request->getParam('Nr_of_users');
    $StartDate = $request->getParam('StartDate');
    $EndDate = $request->getParam('EndDate');
    $password = $request->getParam('password');
    $Details = $request->getParam('Details');
    $project_id = $request->getParam('project_id');

    $sql = "INSERT INTO sesion (id,Domain_Name,Project_Name,Nr_of_users,StartDate,EndDate,password,Details,project_id) VALUES
    (:id,:Domain_Name,:Project_Name,:Nr_of_users,:StartDate,:EndDate,:password,:Details,:project_id)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        

        $stmt->bindParam(':id',          $id);
        $stmt->bindParam(':Domain_Name', $Domain_Name);
        $stmt->bindParam(':Project_Name',$Project_Name);
        $stmt->bindParam(':Nr_of_users', $Nr_of_users);
        $stmt->bindParam(':StartDate',   $StartDate);
        $stmt->bindParam(':EndDate',     $EndDate);
        $stmt->bindParam(':password',    $password);
        $stmt->bindParam(':Details',     $Details);
        $stmt->bindParam(':project_id',     $project_id);
      

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update sesion
$app->put('/api/sesion/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $Domain_Name = $request->getParam('Domain_Name');
    $Project_Name = $request->getParam('Project_Name');
    $Nr_of_users = $request->getParam('Nr_of_users');
    $StartDate = $request->getParam('StartDate');
    $EndDate = $request->getParam('EndDate');
    $password = $request->getParam('password');
    $Details = $request->getParam('Details');
    $project_id = $request->getParam('project_id');




    $sql = "UPDATE sesion SET
                id          = :id,
                Domain_Name  = :Domain_Name,
                Project_Name   = :Project_Name,
                Nr_of_users       = :Nr_of_users,
                StartDate    = :StartDate,
                EndDate  = :EndDate,
                password   = :password,
                Details       = :Details,
                project_id    = :project_id

            WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':id',          $id);
        $stmt->bindParam(':Domain_Name', $Domain_Name);
        $stmt->bindParam(':Project_Name',$Project_Name);
        $stmt->bindParam(':Nr_of_users', $Nr_of_users);
        $stmt->bindParam(':StartDate',   $StartDate);
        $stmt->bindParam(':EndDate',     $EndDate);
        $stmt->bindParam(':password',    $password);
        $stmt->bindParam(':Details',     $Details);
        $stmt->bindParam(':project_id',     $project_id);
      
        $stmt->execute();

        echo '{"notice": {"text": "Sesion Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }


});

// Delete session
$app->delete('/api/sesion/delete/{id}', function(Request $request, Response $response){
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
        echo '{"notice": {"text": "Sesion Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

?>