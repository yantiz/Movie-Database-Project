<!-- Page I4 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add actor to movie relation</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Add Actor to Movie Relation</p>
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
    Actor:&nbsp;
    <?php
       $query2 = "SELECT first, last FROM Actor;";
       $rs2 = mysql_query($query2, $db_connection);
       echo '<select name="actor">';
       while ($row = mysql_fetch_row($rs2)) {
         echo "<option>" . "$row[0]" . " " . "$row[1]" . "</option>";
       }
       echo '</select>';
    ?><br><br>
    Role:&nbsp;<input type="text" name="role"><br><br>
    <input type="submit" value="Submit">
  </form>

<br>

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $movieinfo = $_POST["movieinfo"];   
     $s1 = split("-", $movieinfo);
     $title = $s1[0];
     $year = $s1[1];
     $actor = $_POST["actor"];
     $s2 = split(" ", $actor);
     $firstname = $s2[0];
     $lastname = $s2[1];
     $role = $_POST["role"];
   }
   if (empty($role)) {
     echo "*Please enter the role of your actor and choose the corresponding movie.";
   }
   else {
     $query1 = "SELECT id FROM Movie WHERE title = '$title' and year = $year";
     $query2 = "SELECT id FROM Actor WHERE first = '$firstname' and last = '$lastname';";
     $rs1 = mysql_query($query1, $db_connection);
     $rs2 = mysql_query($query2, $db_connection);
     $row1 = mysql_fetch_row($rs1);
     $row2 = mysql_fetch_row($rs2);
     $mid = $row1[0];
     $aid = $row2[0];
     $query = "SELECT * FROM MovieActor WHERE mid = $mid and aid = $aid;";
     $rs = mysql_query($query, $db_connection);
     if (mysql_num_rows($rs) != 0) {
       echo "Relation already exists! Please choose another actor or movie to add.";
     }
     else {
       $query = "INSERT INTO MovieActor VALUES ($mid, $aid, '$role');";
       mysql_query($query, $db_connection);
       echo "Relation between the actor and movie was successfully inserted!";
     }
   }
   mysql_close($db_connection);
?>
</div>

</body>
</html>
