<?php require 'connect.php'; ?>
<html>
<head>
<title>EMIS System</title>
</head>

<body>
<h1> Welcome to schoolbridge</h1>
<p>Actions: <a href="index.php">Home</a>, <a href="viewclasses.php">View/add classes</a>, <a href="regstudent.php">Register new student</a>, <a href="addscore.php">Add student's score</a></p>

<h3>View Class broadsheets</h3>



<form action="" method="post">
<p>Select Class: 
    <select name="class">
    <option>...select class...</option>
    <?php
        $sql= mysqli_query($con,"SELECT * FROM class") or die("cannot view");
        while($row=mysqli_fetch_array($sql)){

        
    ?>
    <option value="<?php echo $row['c_id']; ?>"><?php echo $row['classname']; ?></option>
        <?php } ?>
    </select>
</p>

<p><input type="submit" name="btn" value="View broadsheet"></p>
</form>
<br><br>

<?php
  if(isset($_POST['btn'])){
    $cid = $_POST['class'];
    $sql = mysqli_query($con, "SELECT * FROM scoretb WHERE c_id='$cid'") or die('failed '.mysqli_error($con));


    if(mysqli_num_rows($sql) < 1){
      echo 'No broadsheet for this class yet';
    }else{
       $row=mysqli_fetch_array($sql);
       $sub=$row['sub_id'];
       $cid=$row['c_id'];
  
?>
<table width="528" border="1">
  <tr>
    <th width="21" scope="col">&nbsp;</th>
    <th width="54" scope="col">&nbsp;</th>
    <th width="105" scope="col">&nbsp;</th>
    <?php
      $query=mysqli_query($con, "SELECT * FROM subjects WHERE c_id='$cid'") or die('Failed');
      while($get=mysqli_fetch_array($query)){
    ?>
    <th width="72" scope="col"><?php  echo $get['subject'];  ?></th>
      <?php } ?>
  </tr>
  <?php
      $query1=mysqli_query($con, "SELECT * FROM studentdb s, scoretb x WHERE x.sub_id='$sub' AND s.regno=x.regno") or die('Failed');
      $sn=0;
       while($get1=mysqli_fetch_array($query1)){
         $sn++;
         $regno = $get1['regno'];
    ?>
  <tr>
    
    <td><?php echo $sn; ?></td>
    <td><?php echo $regno;?></td>
    <td><?php echo $get1['name'];?></td>
     <?php
      $query=mysqli_query($con, "SELECT * FROM scoretb WHERE regno='$regno'") or die('Failed');
      while($get2=mysqli_fetch_array($query)){
    ?>
    <td><?php echo $get2['total'];?></td>
     <?php } ?>
  </tr>
   <?php } ?>
</table>
<?php  }
  }
  ?>
</body>
</html>