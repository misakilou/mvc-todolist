<?php

namespace Controller;

use Service\Session;
use Model\TaskManager;
use Model\UserManager;


class TaskController extends AbstractController
{


    public function __contruct(){

        //Verifier l'user et son token , sinon retourner une 404

    }

    public function home(){

        if(Session::getInstance()->read('user_id')){

            $user_id = Session::getInstance()->read('user_id');

            $taskManager = new TaskManager();
            $userManager = new UserManager();

            $user = $userManager->selectWhere('id ='.$user_id);

            $user_api_token = $user[0]->getApiToken();
            $user_name = $user[0]->getName();

            $tasks = $taskManager->selectWhere('parent_id IS NULL AND user_id ='.$user_id);

            foreach ($tasks as $key => $task){

                $taskId = $task->getId();
                $subtask = $taskManager->selectWhere("parent_id = $taskId");
                $task->setSubtasks($subtask);

                $tasks[$key]->subtasks = $subtask;

            }

            return $this->twig->render('Task/index.html.twig', ['tasks' => $tasks , 'api_token' => $user_api_token , 'name' => $user_name]);


        }
        else{
            return $this->twig->render('Auth/login.html.twig');
        }

 
    }


    public function index()
    {
        $taskManager = new TaskManager();
        $userManager = new UserManager();
        $headers = apache_request_headers();
        $token = trim(str_replace('Bearer', '', $headers['Authorization']));
        $user = $userManager->selectWhere("api_token = '$token'");

        if($user){
            $user_id = $user[0]->getId();
            $user_name = $user[0]->getName();
            $tasks = $taskManager->selectWhere('parent_id IS NULL AND user_id ='.$user_id);

            foreach ($tasks as $key => $task){

                $taskId = $task->getId();
                $subtask = $taskManager->selectWhere("parent_id = $taskId");
                $tasks[$key]->subtasks = $subtask;
                $tasks['name'] = $user_name;

            }
            
            header('HTTP/1.1 200 Created');
            header('Content-Type:application/json');
            return json_encode($tasks);
        }
        else{
           header('HTTP/1.1 401 Forbidden');
            header('Content-Type:application/json');
            return json_encode('Not Allowed'); 
        }

    }



    public function store(){

        $headers = apache_request_headers();
        $token = trim(str_replace('Bearer', '', $headers['Authorization']));

        $userManager = new UserManager();
        $user = $userManager->selectWhere("api_token = '$token'");

        if($user){
            $user_id = $user[0]->getId();
            $user_name = $user[0]->getName();
            $title = htmlentities($_POST['title']);
            $parent_id = isset($_POST['parent']) && $_POST['parent'] != 0 ? $_POST['parent'] : NULL;


            $taskManager = new TaskManager();
            $data = array('title' => $title, 'done' => 0 , 'parent_id' => $parent_id , 'user_id' => $user_id , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s'));

            $tasks = $taskManager->insert($data); 
            /*
            header('HTTP/1.1 201 Created');
            header('Content-Type:application/json');
            */
            header('Content-Type:application/json');
            return json_encode(array('task' => $tasks , 'userName' => $user_name));
        }
        else{
           header('HTTP/1.1 401 Forbidden');
            header('Content-Type:application/json');
            return json_encode('Not Allowed'); 
        }



    } 

    public function destroy($id){
        $taskManager = new TaskManager();
        $tasks = $taskManager->selectOneById($id);

        $headers = apache_request_headers();
        $token = trim(str_replace('Bearer', '', $headers['Authorization']));

        $userManager = new UserManager();
        $user = $userManager->selectWhere("api_token = '$token'");
        if($user){
            $user_id = $user[0]->getId();

            if($tasks->getParentId() == NULL){
                $taskManager->deleteWhere("parent_id = $id AND user_id = $user_id");
            }

            $task = $taskManager->delete($id);

            header('HTTP/1.1 200');
            header('Content-Type:application/json');
            return json_encode("OK");
        }
        else{
           header('HTTP/1.1 401 Forbidden');
            header('Content-Type:application/json');
            return json_encode('Not Allowed'); 
        }


    }

    public function update($id){

        parse_str(file_get_contents('php://input'), $_PATCH);
        $title = $_PATCH["title"];
        $taskManager = new TaskManager();
        $data = array('title' => $title, 'updated_at' => date('Y-m-d H:i:s') , 'id' => $id);
        $tasks = $taskManager->update($id, $data);
        //echo json_encode('flag 2');
        header('HTTP/1.1 200');
        header('Content-Type:application/json');
        return json_encode(['task' => $tasks]);

    }

    public function markAsDone($id){
        parse_str(file_get_contents('php://input'), $_PATCH);
        $taskManager = new TaskManager();

        $task = $taskManager->selectOneById($id);
        $done = !$task->getDone();

        if(!$done){
            $done = 0;
        }
  
        $data = array('done' => $done, 'id' => $id);
        $tasks = $taskManager->update($id, $data);
        header('HTTP/1.1 201');
        header('Content-Type:application/json');
        return json_encode("OK");

    }


}
