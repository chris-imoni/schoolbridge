<?php session_start(); ?>
<?php require 'connect.php'; ?>

<?php
  if(isset($_GET['cid'])){
    $cid = $_GET['cid'];
    $_SESSION['cid']= $cid;
  }

  //Remove subject from table
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $sql = mysqli_query($con, "DELETE FROM subjects WHERE sub_id='$id' LIMIT 1") or die("Delete Failed");
  $n_id= $_SESSION['cid'];
  header("Location: viewsubjects.php?cid=$n_id");
}

//Adding Subject to the table
if(isset($_POST['btn'])){
  $sub= $_POST['subject'];
  $sql= mysqli_query($con, "INSERT INTO subjects(subject, c_id) VALUES('$sub', '$cid')") or die("cannot insert");
  header("Location: viewsubjects.php?cid=$cid");

}

?>
<html>
<head>
<title>EMIS System</title>
</head>

<body>
<h1> Welcome to schoolbridge</h1>
<p>Actions: <a href="index.php">Home</a>, <a href="viewclasses.php">View/add classes</a>, <a href="regstudent.php">Register new student</a>, <a href="addscore.php">Add student's score</a>, <a href="results.php">view broadsheets</a></p>

<form action="" method="post">
<p>Enter Subject: <input type="text" name="subject" placeholder="E.g. English"> <input type="submit" name="btn" value="Add Subject"></p>
</form>
<br>
<?php
  $sql=mysqli_query($con, "SELECT * FROM subjects s, class c WHERE s.c_id='$cid' AND c.c_id='$cid'") or die("Cannot fetch");
  if(mysqli_num_rows($sql) < 1){
    echo '<h2>No Subject added for this class</h2>';
  }else{

?>
<table width="446" border="1">
  <tr>
    <th width="21" scope="col">SN</th>
    <th width="172" scope="col">Subjects</th>
    <th width="116" scope="col">Class</th>
    <th width="109" scope="col">Remove</th>
  </tr>
  <?php
    $sn=0;
    while($row=mysqli_fetch_array($sql)){
      $sn++;
  ?>
  <tr>
    <td><?php echo $sn; ?></td>
    <td><?php echo $row['subject']; ?></td>
    <td><?php echo $row['classname']; ?></td>
    <td><a href="viewsubjects.php?id=<?php echo $row['sub_id']; ?>" onclick="return confirm('Are you sure you want to remove this subject?')">Remove</a></td>
  </tr>
  <?php } ?>
</table>
  <?php } ?>
</body>
</html>