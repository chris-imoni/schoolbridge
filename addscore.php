<?php require 'connect.php'; ?>
<html>
<head>
<title>EMIS System</title>
</head>

<body>
<h1> Welcome to schoolbridge</h1>
<p>Actions: <a href="index.php">Home</a>, <a href="viewclasses.php">View/add classes</a>, 
<a href="regstudent.php">Register new student</a>, <a href="results.php">view broadsheets</a></p>

<h2>Select Class and subject to enter students scores</h2>

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
<p>Select Subject: 
    <select name="subject">
    <option>...select subject...</option>
    <?php
        $sql= mysqli_query($con,"SELECT * FROM subjects") or die("cannot view");
        while($row=mysqli_fetch_array($sql)){

        
    ?>
    <option value="<?php echo $row['sub_id']; ?>"><?php echo $row['subject']; ?></option>
        <?php } ?>
    </select>
</p>

<p><input type="submit" name="btn" value="View"></p>
</form>
<br><br>

<?php
    if(isset($_POST['btn'])){
        $class= $_POST['class'];
        $subject= $_POST['subject'];
        $sn=0;
        $sql=mysqli_query($con, "SELECT * FROM subjects WHERE c_id='$class' AND sub_id='$subject'")or die('failed'.mysqli_error($sql));
        if(mysqli_num_rows($sql)< 1){
            echo"No record for this selection";
        }else{
            $row=mysqli_fetch_array($sql);
            $cid=$row['c_id'];
            $sub=$row['sub_id'];

            $query=mysqli_query($con,"SELECT c.classname, s.subject FROM class c, subjects s WHERE c.c_id='$cid' AND s.sub_id='$sub'") or die('no'.mysqli_error($con));
            $get = mysqli_fetch_array($query);

       


?>

<form action="" method="post">

<h3><?php echo $get['subject']; ?> scores for <?php echo $get['classname']; ?></h3>
 <?php
 $sql2=mysqli_query($con,"SELECT * FROM studentdb s,  scoretb t WHERE t.sub_id='$sub' AND t.regno=s.regno") or die('error '.mysqli_error($con));
 ?>
<table width="680" border="1">
  <tr>
    <th width="21" scope="col">SN</th>
    <th width="44" scope="col">Regno</th>
    <th width="135" scope="col">Fullname</th>
    <th width="144" scope="col">CA 20%</th>
    <th width="146" scope="col">CA20%</th>
    <th width="150" scope="col">Exam 60%</th>
  </tr>
  <?php
    while($row2=mysqli_fetch_array($sql2)){
        $sn++;
?>
  <tr>
  <input type="hidden" name="sub[]" size="20" value="<?php echo $sub; ?>">
    <td><?php echo $sn; ?></td>
    <td><input type="hidden" name="regno[]" size="20" value="<?php echo $row2['regno']; ?>"><?php echo $row2['regno']; ?></td>
    <td><?php echo $row2['name']; ?></td>
    <td><input type="text" name="ca1[]" size="20" value="<?php echo $row2['ca1'];?>"></td>
    <td><input type="text" name="ca2[]" size="20" value="<?php echo $row2['ca2'];?>"></td>
    <td><input type="text" name="exam[]" size="20" value="<?php echo $row2['exam'];?>"></td>
  </tr>
    <?php } 
    
    ?>
</table><br>
 <input type="submit" name="button" value="Save scores">
        <?php } ?>
</form>
    <?php }?>

<?php
    if(isset($_POST['button'])){
        $usersCount = count($_POST["sub"]);
        for($i=0;$i<$usersCount;$i++) {
            $ca1=$_POST['ca1'][$i];
            $ca2=$_POST['ca2'][$i];
            $exam=$_POST['exam'][$i];
            $regno=$_POST['regno'][$i];
            $sub=$_POST['sub'][$i];
            $total=$ca1+$ca2+$exam;
            mysqli_query($con, "UPDATE scoretb SET ca1='$ca1', ca2='$ca2', exam='$exam', total='$total' WHERE sub_id='$sub' AND regno='$regno'") or die('failed');
        }
        echo '<script>alert("Records saved"); window.location="addscore.php";</script>';
    }
            
    ?>
</body>
</html>
