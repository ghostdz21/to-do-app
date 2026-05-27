<?php
   session_start();


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
</head>
<body>
<?php
  if (isset($_SESSION['errors'])){
    foreach ($_SESSION['errors'] as $error)
    echo  "<p style='color: red'>{$error}</p>"."<br>";
  }elseif(isset($_SESSION['success'])){
    echo "<p style='color: green'>{$_SESSION['success']}</p>";
  }
  unset ($_SESSION['errors']);
  unset($_SESSION['success']);
?>
<form action="process.php" method="POST">
  <input type="text" name="task" placeholder="Enter new Task" value="<?php echo $_SESSION['old']??''?>"><br><br>
  <input type="hidden" name="action" value="add" >
  <button type="submit">Submit</button>

</form>
<ul>
<?php
 $lines = file('task.txt')?>
 <?php foreach ($lines as $line): ?>
   <?php list($id, $title, $status) = explode('|', $line)?>
   <li>
     <?=$title ?> (<?=$status ?>)
     <form method ='POST' action="process.php" style="display:inline">
       <input type="hidden" name="action" value="complete">
       <input type="hidden" name="id" value="<?php echo $id ?>">
       <button>complete</button>
     </form>

     <form method="POST" action="process.php" style="display:inline">
       <input type="hidden" name="action" value="delete">
       <input type="hidden" name="id" value="<?php echo $id?>" >
       <button>delete</button>
     </form>

     <form action="process.php" method="POST" style="display: inline"></form>
     <input type="hidden" name="action" value="edit">
     <input type="hidden" name="id" value="<?= $id?>">
     <button>Edit</button>

   </li>

<?php endforeach;?>



</ul>


</body>
</html>

<?php
unset($_SESSION['old']);
