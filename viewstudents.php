<?php ob_start(); ?>
<?php require 'connect.php'; ?>
<?php
  if(isset($_GET['cid'])){
    $cid = $_GET['cid'];
  }

  $sql=mysqli_query($con, "SELECT * FROM studentdb s, class c WHERE s.c_id='$cid' AND c.c_id='$cid'") or die("failed");

?>
<html>
<head>
<title>EMIS System</title>
</head>

<body>
<h1> Welcome to schoolbridge</h1>
<p>Actions: <a href="index.php">Home</a>, <a href="viewclasses.php">View/add classes</a>, <a href="regstudent.php">Register new student</a>, <a href="addscore.php">Add student's score</a>, <a href="results.php">view broadsheets</a></p>

<?php
  if(mysqli_num_rows($sql) < 1){
    echo "<h2>No students reg into this class. </h2>";
  }else{
?>
<table width="657" border="1">
  <tr>
    <th width="21" scope="col">SN</th>
    <th width="63" scope="col">Reg num</th>
    <th width="122" scope="col">Fullname</th>
    <th width="64" scope="col">Sex</th>
    <th width="143" scope="col">Email</th>
    <th width="92" scope="col">Class</th>
    <th width="106" scope="col">Date of reg</th>
  </tr>
  <?php
  $sn=0;
    while($get=mysqli_fetch_array($sql)){
      $sn++;
 
  ?>
  <tr>
    <td><?php echo $sn; ?></td>
    <td><?php echo $get['regno']; ?></td>
    <td><?php echo $get['name']; ?></td>
    <td><?php echo $get['sex']; ?></td>
    <td><?php echo $get['email']; ?></td>
    <td><?php echo $get['classname']; ?></td>
    <td><?php echo $get['date_reg']; ?></td>
  </tr>
  <?php } ?>
</table>
  <?php } ?>


</body>
</html>