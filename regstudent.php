<?php require 'connect.php'; ?>
<html>
<head>
<title>EMIS System</title>
</head>

<body>
<h1> Welcome to schoolbridge</h1>
<p>Actions: <a href="index.php">Home</a>, <a href="viewclasses.php">View/add classes</a>, <a href="addscore.php">Add student's score</a>, <a href="results.php">view broadsheets</a></p>

<form action="" method="post">
<h2>Students registration form </h2>
<p>Reg. number: <input type="text" name="regno" placeholder="e.g. reg100"></p>
<p>Fullname: <input type="text" name="name"></p>
<p>Sex: <input type="radio" name="sex" value="Male">Male <input type="radio" name="sex" value="Female">Female</p>
<p>Email: <input type="text" name="email"></p>
<p>Select class: 
    <select name="class">
    <option>...Select class..</option>
    <?php
        $sql= mysqli_query($con,"SELECT * FROM class") or die("cannot view");
        while($row=mysqli_fetch_array($sql)){

        
    ?>
    <option value="<?php echo $row['c_id']; ?>"><?php echo $row['classname']; ?></option>
        <?php } ?>
    </select>

</p>
<p><input type="submit" name="btn" value="Register"></p>
</form>
<?php
if(isset($_POST['btn'])){
    $regno = $_POST['regno'];
    $fname = $_POST['name'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $class = $_POST['class'];

    $sql = mysqli_query($con, "INSERT INTO studentdb VALUES('$regno', '$fname', '$sex', '$email', '$class', now())")or die("cannot insert");
    
    $query = mysqli_query($con, "SELECT * FROM subjects WHERE c_id='$class'") or die("error " .mysqli_error($con));
    while($get = mysqli_fetch_array($query)){
        $sub_id = $get['sub_id'];
        $cid = $get['c_id'];

        mysqli_query($con, "INSERT INTO scoretb(sub_id, c_id, regno) VALUES('$sub_id', '$cid', '$regno')") or die("error ".mysqli_error($con));
    }
    
    echo 'Registration successfull';
}


?>
</body>
</html>