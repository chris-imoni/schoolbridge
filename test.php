<?php require 'connect.php'; ?>
<?php
    $query = mysqli_query($con, "SELECT * FROM test") or die("lol");

?>
<form action="" method="post">
<?php
    while($gt=mysqli_fetch_array($query)){
?>
<p><input type="hidden" name="id[]" value="<?php echo $gt['id'];?>"><input type="text" name="name[]" value="<?php echo $gt['name'];?>"></p>
    <?php } ?>
<p><input type="submit" name="btn" value="submit"></p>
</form>

<?php
if(isset($_POST['btn'])){
    //This is working
    
   /* $row_data = array();
    foreach($_POST['name'] as $row=>$name) {
        $name=$name;
        $row_data[] = "('$name')";
    }
    if (!empty($row_data)) {
        $sql = 'INSERT INTO test (name) VALUES '.implode(',', $row_data);
        $result = mysqli_query($con, $sql ) or die(mysqli_error($con));
    }*/

$usersCount = count($_POST["name"]);
for($i=0;$i<$usersCount;$i++) {
mysqli_query($con, "UPDATE test set name='" . $_POST["name"][$i] . "' WHERE id='" . $_POST["id"][$i] . "'");
}
header("Location:test.php");
}


?>
