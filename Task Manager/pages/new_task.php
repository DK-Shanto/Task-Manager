<?php
   if($_POST['task_submit']){
   	$task_name = $_POST['task_name'];
   	$task_body = $_POST['task_body'];
   	$due_date = $_POST['due_date'];
   	$list_id =$_POST['list_id'];

   	$database = new Database;

   	$database->query('INSERT INTO tasks(task_name,task_body,due_date,list_id) VALUES (:task_name,:task_body,:due_date,:list_id)');
   	$database->bind(':task_name',$task_name);
		$database->bind(':task_body',$task_body);
		$database->bind(':due_date',$due_date);
		$database->bind(':list_id',$list_id);
		$database->execute();
		if($database->lastInsertId()){
			echo '<p class="msg">Your task has been created</p>';
		}
   }
  ?>

  <?php
//Instantiate Database object
$database = new Database;

//Get logged in user
$list_user = $_SESSION['username'];

//Query
$database->query('SELECT * FROM lists WHERE list_user = :list_user');
$database->bind(':list_user',$list_user);
$rows = $database->resultset();
?>


<h1>Add a Task here</h1>
<form action="<?php $SERVER['PHP_SELF']; ?>" method ="post">
<label>Task Name</label>
<input type="text" name="task_name"><br>
<?php if($GET['listid']):?>
	<input type="hidden" name="list_id" value="<?php echo $_GET['listid'];?>">
	<?php else:?>
		<label>List</label>
		<select name ="list_id">
		 <option value="0"></option>
		<?php foreach($rows as $list):?>
			<option value="<?php echo $list['id']; ?>">
				<?php echo $list['list_name'];?>
			</option>
			<?php endforeach; ?>
		</select>
	<?php endif; ?>
	<br>
	<label>Task Body</label>
	<textarea rows="5" cols="50" name="task_body"></textarea><br>
	<input type='date' name='due_date'><br>
	<input type="submit" value ="Create" name ="task_submit">
</form>