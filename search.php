<!-- Page S1 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Search actor/movie information</title>
</head>

<body>
<?php require_once('homepage.php');?><br>

<div>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Search Actor/Movie Information:&nbsp;
    <input type="text" name="search"> <br><br>
    <input type="submit" value="Submit"><br><br>
  </form>

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $search = $_POST["search"];
   }
   if (empty($search)) {
     echo "*Please enter the name of the actor/movie.";
   }
   else {
     echo "<h3>*You are searching [$search] results.</h4><br>";
     $db_connection = connect();
     $query1 = "SELECT id, title FROM Movie WHERE 1";
     $s = split(" ", $search);
     foreach ($s as $word) {
       $query1 .= " AND TITLE LIKE '%$word%'";
     }
     $query1 .= " ORDER BY title ASC;";
     echo "<h4>Matching records in Movie database:</h4>";
     $rs1 = mysql_query($query1, $db_connection);
     if (mysql_num_rows($rs1) == 0) {
       echo "Record not found.<br>";
     }
     else {
       $num_movie = 0;
       while ($row1 = mysql_fetch_row($rs1)) {
         $num_movie += 1;
	 echo "<a href=./showMovie.php?id=\"$row1[0]\">" . $row1[1] . "</a><br>";
       }
       echo "<br>" . "Total number of movies: " . $num_movie . "<br><br>";
     }
   
     echo "<h4>Matching records in Actor database:</h4>";
     $query2 = "SELECT id, first, last FROM Actor WHERE 1";
     foreach ($s as $name) {
       $query2 .= " AND (first LIKE '%$name%' OR last LIKE '%$name%')";
     }
     $query2 .= " ORDER BY last ASC;";
     $rs2 = mysql_query($query2, $db_connection);
     if (mysql_num_rows($rs2) == 0) {
       echo "Record not found.<br>";
     }
     else {
       $num_actor = 0;
       while ($row2 = mysql_fetch_row($rs2)) {
         $num_actor += 1;
         echo "<a href=./showActor.php?id=\"$row2[0]\">" . $row2[1] . " " . $row2[2] . "</a><br>";
       }
       echo "<br>" . "Total number of actors: " . $num_actor . "<br><br>";
     }
     mysql_close($db_connection);
   }
?>
</div>

</body>
</html>
