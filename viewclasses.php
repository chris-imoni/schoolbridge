<?php require 'connect.php'; ?>
<?php
//Remove a class from the table
if(isset($_GET['cid'])){
  $cid = $_GET['cid'];
  $sql = mysqli_query($con, "DELETE FROM class WHERE c_id='$cid' LIMIT 1") or die("Delete Failed");
  header('Location: viewclasses.php');
}

//Adding class to the table
if(isset($_POST['btn'])){
  $class= $_POST['class'];
  $sql= mysqli_query($con, "INSERT INTO class(classname) VALUES('$class')") or die("cannot insert");
}
?>
<html>
<head>
<title>EMIS System</title>
</head>

<body>
<h1> Welcome to schoolbridge</h1>
<p>Actions: <a href="index.php">Home</a>, <a href="regstudent.php">Register new student</a>, <a href="addscore.php">Add student's score</a>, <a href="results.php">view broadsheets</a></p>

<form action="" method="post">
<p>Enter class: <input type="text" name="class" placeholder="Enter class name, e.g. SS1" size="30"> 
<input type="submit" name="btn" value="Add Class">
</p>
</form>
<br><br>

<?php
  $sql=mysqli_query($con, "SELECT * FROM class") or die("Cannot fetch");
  if(mysqli_num_rows($sql) < 1){
    echo '<h2>No class added</h2>';
  }else{

?>

<table width="486" border="1">
  <tr>
    <th width="21" scope="col">SN</th>
    <th width="52" scope="col">Classes</th>
    <th width="123" scope="col">View Students</th>
    <th width="131" scope="col">View/Add subjects</th>
    <th width="125" scope="col">Remove</th>
  </tr>
  <?php
  $sn=0;
    while($row=mysqli_fetch_array($sql)){
      $sn++;
  ?>
  <tr>
    <td><?php echo $sn; ?></td>
    <td><?php echo $row['classname']; ?></td>
    <td><a href="viewstudents.php?cid=<?php echo $row['c_id']; ?>">View</a></td>
    <td><a href="viewsubjects.php?cid=<?php echo $row['c_id']; ?>">View/Add</a></td>
    <td><a href="viewclasses.php?cid=<?php echo $row['c_id']; ?>" onclick="return confirm('Are you sure you want to remove this class?')">Remove</a></td>
  </tr>
    <?php }?>
</table>
  <?php }?>
</body>
</html>