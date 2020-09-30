<?php

namespace Controller;

use Model\TaskManager;


class TaskController extends AbstractController
{


    public function __contruct(){

        //Verifier l'user et son token , sinon retourner une 404


    }

    public function home(){
        $taskManager = new TaskManager();

        $tasks = $taskManager->selectWhere('parent_id IS NULL');

        foreach ($tasks as $key => $task){

            $taskId = $task->getId();
            $subtask = $taskManager->selectWhere("parent_id = $taskId");
            $task->setSubtasks($subtask);

            $tasks[$key]->subtasks = $subtask;

        }

        return $this->twig->render('Task/index.html.twig', ['tasks' => $tasks]);

    }


    public function index()
    {
        $taskManager = new TaskManager();

        $tasks = $taskManager->selectWhere('parent_id IS NULL');

        foreach ($tasks as $key => $task){

            $taskId = $task->getId();
            $subtask = $taskManager->selectWhere("parent_id = $taskId");
            $tasks[$key]->subtasks = $subtask;

        }
        /*
        echo '<pre>';
        var_dump($tasks);
        echo '</pre>';
        */
        
        header('HTTP/1.1 200 Created');
        header('Content-Type:application/json');
        return json_encode($tasks);

    }



    public function store(){

        $title = htmlentities($_POST['title']);
        $parent_id = isset($_POST['parent']) && $_POST['parent'] != 0 ? $_POST['parent'] : NULL;


        $taskManager = new TaskManager();
        $data = array('title' => $title, 'done' => 0 , 'parent_id' => $parent_id , 'user_id' => 1 , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s'));

        $tasks = $taskManager->insert($data); 
        /*
        header('HTTP/1.1 201 Created');
        header('Content-Type:application/json');
        */
        return json_encode(array('task' => $tasks , 'userName' => 'Ludwig'));


    } 

    public function destroy($id){
        $taskManager = new TaskManager();
        $tasks = $taskManager->selectOneById($id);

        if($tasks->getParentId() == NULL){
            $taskManager->deleteWhere("parent_id = $id");
        }

        $task = $taskManager->delete($id);

        header('HTTP/1.1 200');
        header('Content-Type:application/json');
        return json_encode("OK");
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
