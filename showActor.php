<!-- Page B1 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Show actor information</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Show Actor Information</p>
<div>
<?php
   if ($_SERVER["REQUEST_METHOD"] == "GET") {     
     $id = $_GET["id"];
   }
   if ($id) {
     echo "<h4>-- Show Actor Info --</h4>";
     $db_connection = connect();
     $query = "SELECT * FROM Actor WHERE id = $id;";
     $rs = mysql_query($query, $db_connection);
     $row = mysql_fetch_row($rs);
     $cols = mysql_num_fields($rs);
     echo "<table border='1' style='width:50%'>";
     echo "<tr>";
     for ($i = 0; $i < $cols; $i++) {
       echo "<th>" . mysql_field_name($rs, $i) . "</th>";
     }
     echo "</tr>";
     echo "<tr>";
     foreach ($row as $value) {
       $value = ($value ? $value : 'N/A');
       echo "<td style='text-align:center'>" . $value . "</td>";
     }
     echo "</table><br>";

     echo "<h4>-- Movie Acted In --</h4>";
     $query = "SELECT mid, role FROM MovieActor WHERE aid = $id;";
     $rs = mysql_query($query, $db_connection);
     if (mysql_num_rows($rs) == 0) {
       echo "No movie information can be found for this actor.";
     }
     else {
       while ($row = mysql_fetch_row($rs)) {
         $query_movie = "SELECT title FROM Movie WHERE id = $row[0];";
         $rs_movie = mysql_query($query_movie, $db_connection);
         $row_movie = mysql_fetch_row($rs_movie);
         echo "Acted in <a href=./showMovie.php?id=\"$row[0]\">" . $row_movie[0] . "</a> as '$row[1]'.<br>";
       }
     }
     mysql_close($db_connection);
   }
   else {
     echo "*Please refer to the <a href=./search.php>search interface</a> first.<br>";
   }
?>
</div>

</body>
</html>
