<?php
session_start();
if ($_SESSION['login']==false)
{
  
    echo 'You are not logged in. <a href="index.php">Click here</a> to log in.';
}
else 
{
?>
<html>
<body>
<form method="post">
<!--<table>
<tr>
    <td><br><br><font size="4" face="High Tower Text" color="black">USER:</td>
    <td><br><br><font size="4" face="High Tower Text" color="black"><?php echo  "  $_SESSION[username]"?></td>
</tr>
</table>
-->
<center>
<br>

<br>
<h2> AVAILABLE PRODUCTS </h2>
<br>


<?php include 'DBconnect.php'; 
$name =$_GET['name'];


$limit=2;
if(isset($_GET["page"]))
{
	$pno=$_GET["page"];
}
else{$pno=1;}
$start=($pno-1)*$limit;
$sql="select * from product_master limit $start,$limit";
$queryResult = $conn->query($sql);
$rowCount = mysqli_num_rows($queryResult);

 echo "<table border='1' cellpadding='10'>";
 
			
			echo "<tr>";
            echo "<th> Product ID </th>";
            echo "<th> Product Name </th>";
			echo "<th> Edit product </th>";
			echo "<th> View product </th>";
			
         echo "</tr>";
		 
		 if($rowCount > 0)
		 {
			 while($row = mysqli_fetch_array($queryResult)) 
			 {
				echo "<tr>";
				echo "<td> $row[product_id]</td>";
				echo "<td> $row[product_name]</td>";
				
				echo "<td> <a href=\"product_edit.php?name=$_SESSION[username]&id=$row[product_id]\">Edit</a></td>";
				echo "<td> <a href=\"product_view.php?name=$name&id=$row[product_id]\">View</a></td>";
				
				echo "</tr>";
			 }
		 }
		 else
		 {
				echo "<tr>";
				echo "<td colspan='7' align='center'> No product(s) found</td>";
				echo "</tr>";
		 }
         
       echo "</table>";

?>
<tr>
		<td><br><br><a href="product_add.php?name=<?php echo $name ?>"> <b>ADD A NEW PRODUCT </b></a></td>
		<td><br><br><a href="home.php?name=<?php echo $name ?>"> <b>HOME PAGE</b></a></td>
		
	</tr>
</body>
</html>
<?php
echo "<ul class='pagination'>";
$query1 = "select * from product_master";
$queryResult1 = $conn->query($query1);
$rowCount1 = mysqli_num_rows($queryResult1);
$total_pages=ceil($rowCount1/$limit);
$pagelink="";

for($i=1;$i<=$total_pages;$i++)
{
	if($i==$pno)
	{
		$pagelink.="<a class='active' href=\"product_list.php?page=$i&name=$name\">$i</a>";
		$str=" ";
		$pagelink.=$str;
	}
	else
	{
		$pagelink.="<a href=\"product_list.php?page=$i&name=$name\">$i</a>";
		$str=" ";
		$pagelink.=$str;
	}
}
echo "$pagelink";
echo "</ul>";
$conn->close();
}
?>
