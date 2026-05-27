<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
  header('location:index.php');
  exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'add'){
  $task = $_POST['task'] ?? '';

  $errors = [];
  $_SESSION['success']= '';

  if(empty(trim($task))){
    $errors[] = "your task is empty";}

  if(strlen(trim($task))<3){
    $errors[] = "Task must be at least 3 caracters";}

  if(is_numeric($task)){
    $errors[] = "a number is not a task";
  }

  if(!empty($errors)){
    $_SESSION['old'] = $task;
    $_SESSION['errors'] = $errors;
  }else{
    $id = uniqid();
    $data = "$id|$task|pending";
    file_put_contents("task.txt",$data.PHP_EOL,FILE_APPEND);
    $_SESSION['success'] = "task submitted successfully";
  }
}
// complete action code

if ($action === 'complete'){
  $id = $_POST['id'] ?? '';
  $taskArray = [];
  $tasks = file('task.txt',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
  foreach ($tasks as $taskElement){

    list($taskId, $title, $status) = explode('|', $taskElement);

    if($taskId === $id){
        $status = 'Done';
    }

     $taskArray[] = "$taskId|$title|$status";


  }
    file_put_contents("task.txt",implode(PHP_EOL,$taskArray));
  $_SESSION['success'] = "task marked as done !";
}

// delete action

if($action === 'delete' && $id !==''){
 $id = $_POST['id'];
 $tasks = file('task.txt',FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
 $newArray = [];
 foreach ($tasks as $taskElement){
   list($taskid, $title, $status) = explode('|',$taskElement);
   if ($id !== $taskid ){
   $newArray [] = "$taskid|$title|$status";
   }
 }
   file_put_contents('task.txt',implode(PHP_EOL,$newArray));
   $_SESSION['success'] = 'Task deleted successfully';
}








header('Location: index.php');
exit;

