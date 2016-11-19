<!-- Page B2 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Show movie information</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Show Movie Information</p>
<div>
<?php
   if ($_SERVER["REQUEST_METHOD"] == "GET") {     
     $id = $_GET["id"];
   }
   if ($id) {
     echo "<h4>-- Show Movie Info --</h4>";
     $db_connection = connect();
     $query = "SELECT * FROM Movie WHERE id = $id;";
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
     $query = "SELECT genre FROM MovieGenre WHERE mid = $id;";
     $rs = mysql_query($query, $db_connection);
     if (mysql_num_rows($rs) != 0) {
       echo '<h4>-- Movie Genre --</h4>';
       $row = mysql_fetch_row($rs);
       echo "$row[0]";
       while ($row = mysql_fetch_row($rs)) {
         echo ", $row[0]";
       }
       echo "<br><br>";
     }

     echo "<h4>-- Actors in this movie --</h4>";
     $query = "SELECT aid, role FROM MovieActor WHERE mid = $id;";
     $rs = mysql_query($query, $db_connection);
     if (mysql_num_rows($rs) == 0) {
       echo "No actor information can be found for this movie.";
     }
     else {
       while ($row = mysql_fetch_row($rs)) {
         $query_actor = "SELECT first, last FROM Actor WHERE id = $row[0];";
         $rs_actor = mysql_query($query_actor, $db_connection);
         $row_actor = mysql_fetch_row($rs_actor);
         echo "<a href=./showActor.php?id=\"$row[0]\">" . $row_actor[0] . " " . $row_actor[1] . "</a> acted as '$row[1]'.<br>";
       }
       echo "<br>";
     }
     
     echo '<h4>-- User Review --</h4>';
     $query = "SELECT name, time, rating, comment FROM Review WHERE mid = $id;";
     $rs = mysql_query($query, $db_connection);
     if (mysql_num_rows($rs) == 0) {
       echo "Review not found.<br><br>";
     }
     else {
       $total_score = 0;
       $total_review = 0;
       while ($row = mysql_fetch_row($rs)) {
         echo "Reviewer: $row[0]<br>";
         echo "Time: $row[1]<br>";
         echo "Rating: $row[2]<br>";
         echo "Comments: $row[3]<br><br>";
         $total_score += $row[2];
         $total_review += 1;
       }
       $avg_score = number_format($total_score / $total_review, 2);
       echo "The average score of rating based on the $total_review reviews is $avg_score<br><br>";
     }
     echo "<a href=addComment.php?id=$id>Add Comment</a>";
     mysql_close($db_connection);
   }
   else {
     echo "*Please refer to the <a href=./search.php>search interface</a> first.<br>";
   }
?>
</div>

</body>
</html>
