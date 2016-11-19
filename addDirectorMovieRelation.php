<!-- Page I5 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add director to movie relation</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Add Director to Movie Relation</p>
<div>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Title and Year:&nbsp;
    <?php
       echo '<select name="movieinfo">';
       $db_connection = connect();
       $query1 = "SELECT title, year FROM Movie;";
       $rs1 = mysql_query($query1, $db_connection);
       while ($row = mysql_fetch_row($rs1)) {
         echo "<option>" . $row[0] . " - " . $row[1] . "</option>";
       }
       echo '</select>';
    ?><br><br>
    Director:&nbsp;
    <?php
       $query2 = "SELECT first, last FROM Director;";
       $rs2 = mysql_query($query2, $db_connection);
       echo '<select name="director">';
       while ($row = mysql_fetch_row($rs2)) {
         echo "<option>" . "$row[0]" . " " . "$row[1]" . "</option>";
       }
       echo '</select>';
    ?><br><br>
    <input type="submit" value="Submit">
  </form>

<br>

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $movieinfo = $_POST["movieinfo"];   
     $s1 = split("-", $movieinfo);
     $title = $s1[0];
     $year = $s1[1];
     $director = $_POST["director"];
     $s2 = split(" ", $director);
     $firstname = $s2[0];
     $lastname = $s2[1];
     $query1 = "SELECT id FROM Movie WHERE title = '$title' and year = $year";
     $query2 = "SELECT id FROM Director WHERE first = '$firstname' and last = '$lastname';";
     $rs1 = mysql_query($query1, $db_connection);
     $rs2 = mysql_query($query2, $db_connection);
     $row1 = mysql_fetch_row($rs1);
     $row2 = mysql_fetch_row($rs2);
     $mid = $row1[0];
     $did = $row2[0];
     $query = "SELECT * FROM MovieDirector WHERE mid = $mid and did = $did;";
     $rs = mysql_query($query, $db_connection);
     if (mysql_num_rows($rs) != 0) {
       echo "Relation already exists! Please choose another director or movie to add.";
     }
     else {
       $query = "INSERT INTO MovieDirector VALUES ($mid, $did);";
       mysql_query($query, $db_connection);
       echo "Relation between the director and movie was successfully inserted!";
     }
   }
   mysql_close($db_connection);
?>
</div>

</body>
</html>
