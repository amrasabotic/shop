<html>
<head>
<title>Edit Colors</title>
</head>
<body>
<h2>Edit Colors</h2>
<form method="post">
<p>Color ID:<input type="text" name="colorID" /></p>
<p>Color:<input type="text" name="color" /></p>
<input type="submit" name="edit" value="Edit Color" />
<input type="submit" name="add" value="Add Color" />
</form>

<?php
include "config.php";
if(isset($_POST['edit']))
{
  //edit color
  $colorid = $_POST['colorID'];
  $color = $_POST['color'];
  
  $sql = "UPDATE color SET color='$color' WHERE colorID=$colorid";
  $result = mysqli_query($conn,$sql);
  if($result)
    echo "Color updated successfully!";
  else
    echo "Error updating color!";
}

if(isset($_POST['add']))
{
  //add color
  $color = $_POST['color'];
  
  $sql = "INSERT INTO color (color) VALUES ('$color')";
  $result = mysqli_query($conn,$sql);
  if($result)
    echo "Color added successfully!";
  else
    echo "Error adding color!";
}

//display colors
$sql = "SELECT * FROM color";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0)
{
  echo "<table><tr><th>Color ID</th><th>Color</th><th>Edit</th><th>Delete</th></tr>";
  while($row = mysqli_fetch_assoc($result))
  {
    echo "<tr><td>".$row['colorID']."</td><td>".$row['color']."</td><td><a href='proba.php?id=".$row['colorID']."'>Edit</a></td><td><a href='proba.php?id=".$row['colorID']."'>Delete</a></td></tr>";
  }
  echo "</table>";
}
?>
</body>
</html>