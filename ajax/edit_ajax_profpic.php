<?php
global $con;

$con = mysqli_connect('localhost','root','12345678','hotel');

if(!$con)
{
  echo 'unable to connect with db';
  die();
}

if(isset($_FILES["file"]["type"]) && isset($_POST['userName']) && isset($_POST['id']))
{
$validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 1000000)//Approx. 100000=100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "../upload/".$_FILES['file']['name']; // Target path where file is to be stored

$id = $_POST['id'];
$company= $_POST['userName'];
$image=$_FILES["file"]["name"];


  $sql = $con->prepare("UPDATE tbl_prof SET image=?, userName=? WHERE id=?");
  $sql->bind_param("ssi",$image,$company,$id);
  $sql->execute();
  if(!$sql)
  {
   echo $MySQLiconn->error;
  }

move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file

echo "<div class='alert alert-success'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Success!</strong>.Profile Pic Updated</div>";
}
}
else
{
echo "<div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Sorry!</strong>Invalid file Size or Type
         </div>";
}
}
?>
