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
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($users);
         $path = "\\routes\\JSON\\users.json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($users));
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
        $users = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($users);
        $path = "\\routes\\JSON\\userid_".$id.".json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($users));
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
//Get sessions
$app->get('/api/sesion', function(Request $request, Response $response){
    $sql = "SELECT * FROM sesion";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $sesions = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($sesions);
        $path = "\\routes\\JSON\\sesions.json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($sesions));
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
        $sesions = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($sesions);
        $path = "\\routes\\JSON\\sesionid_".$id.".json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($sesions));
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

        echo '{"notice": {"text": "Sesion Added"}';

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

// Get projects
$app->get('/api/projects', function(Request $request, Response $response){
    $sql = "SELECT * FROM project_info";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $projects = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($projects);
        $path = "\\routes\\JSON\\projects.json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($projects));
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single project
$app->get('/api/project/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM project_info WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $projects = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($projects);
        $path = "\\routes\\JSON\\projectid_".$id.".json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($projects));
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add project to client
$app->post('/api/project/add', function(Request $request, Response $response){
    $id = $request->getParam('id');
    $Name = $request->getParam('Name');
    $Details = $request->getParam('Details');
    $StartDate = $request->getParam('StartDate');
    $EndDate = $request->getParam('EndDate');
    $cat_id = $request->getParam('cat_id');
   
    

    $sql = "INSERT INTO project_info (id,Name,Details,StartDate,EndDate,cat_id) VALUES
    (:id,:Name,:Details,:StartDate,:EndDate,:cat_id)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        

        $stmt->bindParam(':id',          $id);
        $stmt->bindParam(':Name', 		 $Name);
        $stmt->bindParam(':Details'		,$Details);
        $stmt->bindParam(':StartDate', $StartDate);
        $stmt->bindParam(':EndDate',     $EndDate);
        $stmt->bindParam(':cat_id',     $cat_id);
       
      

        $stmt->execute();

        echo '{"notice": {"text": "Project Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Add project to server
$app->post('/api/project_server/add/{user_id}', function(Request $request, Response $response){
    $user_id =$request->getAttribute('user_id');
    $proj_id = $request->getParam('id');
    $proj_subject = $request->getParam('Name');
    $proj_post_date = $request->getParam('StartDate');
    $proj_cat = $request->getParam('cat_id');
    $proj_by = $user_id;

   
    

    $sql = "INSERT INTO topics (proj_id,proj_subject,proj_post_date,proj_cat,proj_by) VALUES
    (:proj_id,:proj_subject,:proj_post_date,:proj_cat,:proj_by)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        

        $stmt->bindParam(':proj_id',          $proj_id);
        $stmt->bindParam(':proj_subject', $proj_subject);
        $stmt->bindParam(':proj_post_date'     ,$proj_post_date);
        $stmt->bindParam(':proj_cat', $proj_cat);
        $stmt->bindParam(':proj_by',     $proj_by);
        
       
      

        $stmt->execute();

        echo '{"notice": {"text": "Project Added to server "}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update project on client
$app->put('/api/project/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $Name = $request->getParam('Name');
    $Details = $request->getParam('Details');
    $StartDate = $request->getParam('StartDate');
    $EndDate = $request->getParam('EndDate');
    $cat_id = $request->getParam('cat_id');



    $sql = "UPDATE project_info SET
                id          = :id,
                Name  = :Name,
                Details       = :Details,
                StartDate    = :StartDate,
                EndDate  = :EndDate,
                cat_id   = :cat_id

            WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

       
        $stmt->bindParam(':id',          $id);
        $stmt->bindParam(':Name', 		 $Name);
        $stmt->bindParam(':Details'		,$Details);
        $stmt->bindParam(':StartDate', $StartDate);
        $stmt->bindParam(':EndDate',     $EndDate);
        $stmt->bindParam(':cat_id',     $cat_id);
       

       
        $stmt->execute();

        echo '{"notice": {"text": "Project Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

// Update project on server
$app->put('/api/project_server/update/{id}/{user_id}', function(Request $request, Response $response){
    $proj_id= $request->getAttribute('id');
    $user_id =$request->getAttribute('user_id');
    $proj_subject = $request->getParam('Name');
    $proj_post_date = $request->getParam('StartDate');
    $proj_cat = $request->getParam('cat_id');
    $proj_by = $user_id;

    $sql = "UPDATE topics SET
                proj_id          = :proj_id,
                proj_subject  = :proj_subject,
                proj_post_date       = :proj_post_date,
                proj_cat  = :proj_cat,
                proj_by  = :proj_by

            WHERE proj_id = $proj_id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
                

        $stmt = $db->prepare($sql);

       
        $stmt->bindParam(':proj_id',          $proj_id);
        $stmt->bindParam(':proj_subject',     $proj_subject);
        $stmt->bindParam(':proj_post_date',   $proj_post_date);
        $stmt->bindParam(':proj_cat',         $proj_cat);
        $stmt->bindParam(':proj_by',          $proj_by);
       

       var_dump($stmt);
        $stmt->execute();

        echo '{"notice": {"text": "Project Updated on Server"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});


// Delete project from Client
$app->delete('/api/project/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM project_info WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Project Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Delete project from Server
$app->delete('/api/project_server/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM topics WHERE proj_id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Project Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get ideas
$app->get('/api/ideas', function(Request $request, Response $response){
    $sql = "SELECT * FROM ideas";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $ideas = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($ideas);
                $path = "\\routes\\JSON\\ideas.json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($ideas));
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single idea
$app->get('/api/idea/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM ideas WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $ideas = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($ideas);
        $path = "\\routes\\JSON\\idea_id".$id.".json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($ideas));
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add project
$app->post('/api/idea/add', function(Request $request, Response $response){
    $id = $request->getParam('id');
    $Name = $request->getParam('Name');
    $Details = $request->getParam('Details');
    $project_id = $request->getParam('project_id');
    $EndDate = $request->getParam('EndDate');
   
    

    $sql = "INSERT INTO ideas (id,Name,Details,project_id) VALUES
    (:id,:Name,:Details,:project_id)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        

        $stmt->bindParam(':id',     	 $id);
        $stmt->bindParam(':Name', 		 $Name);
        $stmt->bindParam(':Details'		,$Details);
        $stmt->bindParam(':project_id', $project_id);
      
       
      

        $stmt->execute();

        echo '{"notice": {"text": "Idea Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update project
$app->put('/api/idea/update/{id}', function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
    $Name = $request->getParam('Name');
    $Details = $request->getParam('Details');
    $project_id = $request->getParam('project_id');
   



     $sql = "UPDATE ideas SET 
     	id = :id,
     	Name = :Name,
     	Details = :Details,
     	project_id = :project_id

     
     	WHERE id =$id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

       
        $stmt->bindParam(':id',     $id);
        $stmt->bindParam(':Name', 		 $Name);
        $stmt->bindParam(':Details'		,$Details);
        $stmt->bindParam(':project_id', $project_id);

      
        $stmt->execute();

        echo '{"notice": {"text": "Idea Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }


});

// Delete idea
$app->delete('/api/idea/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM ideas WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Idea Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get category
$app->get('/api/categories', function(Request $request, Response $response){
    $sql = "SELECT * FROM categories";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($categories);
        $path = "\\routes\\JSON\\categories.json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($categories));
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single category
$app->get('/api/category/{cat_id}', function(Request $request, Response $response){
    $cat_id = $request->getAttribute('cat_id');

    $sql = $sql = "SELECT * FROM categories WHERE cat_id = $cat_id" ;

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $categories = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($categories);
        $path = "\\routes\\JSON\\categoryid_".$cat_id.".json";
        $myfile = fopen(dirname(__DIR__).''.$path.'', "w+");
   		fwrite($myfile, json_encode($categories));
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add category
$app->post('/api/category/add', function(Request $request, Response $response){
    $cat_id = $request->getParam('cat_id');
    $cat_name = $request->getParam('cat_name');
    $cat_description = $request->getParam('cat_description');
    
    

    $sql = "INSERT INTO categories (cat_id,cat_name,cat_description) VALUES
    (:cat_id,:cat_name,:cat_description)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        

        $stmt->bindParam(':cat_id',          $cat_id);
        $stmt->bindParam(':cat_name', 		 $cat_name);
        $stmt->bindParam(':cat_description', $cat_description);

       
      

        $stmt->execute();

        echo '{"notice": {"text": "Category Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update category
$app->put('/api/category/update/{cat_id}', function(Request $request, Response $response){
    $cat_id = $request->getAttribute('cat_id');
    $cat_name = $request->getParam('cat_name');
    $cat_description = $request->getParam('cat_description');



    $sql = "UPDATE categories SET
                cat_id          = :cat_id,
                cat_name        = :cat_name,
                cat_description = :cat_description
                
             
            WHERE cat_id = $cat_id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

       
        $stmt->bindParam(':cat_id',       $cat_id);
        $stmt->bindParam(':cat_name', 	  $cat_name);
        $stmt->bindParam(':cat_description' ,$cat_description);


      
        $stmt->execute();

        echo '{"notice": {"text": "Category Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

// Delete category
$app->delete('/api/project/delete/{id}', function(Request $request, Response $response){
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
        echo '{"notice": {"text": "Category Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
});
?>