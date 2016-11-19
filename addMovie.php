<!-- Page I2 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add movie information</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Add Movie Information</p>
<div>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Title:&nbsp;&nbsp;&nbsp;<input type="text" name="title"><br><br>
    Company:&nbsp;&nbsp;&nbsp;<input type="text" name="company"><br><br>
    Year:&nbsp;
    <?php
       echo '<select name="year">';       
       for ($i = 1888; $i <= 2016; $i++) {
         echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?><br><br>
    Director:&nbsp;
    <?php
       echo '<select name="director">';
       $db_connection = connect();
       $query = "SELECT first, last FROM Director;";
       $rs_dir = mysql_query($query, $db_connection);
       while ($row = mysql_fetch_row($rs_dir)) {
         echo "<option>" . $row[0] . " " . $row[1] . "</option>";
       }
       echo '</select>';
    ?><br><br>
    MPAA:&nbsp;
    <select name="rating">
      <option value="G">G</option>
      <option value="PG">PG</option>
      <option value="PG-13">PG-13</option>
      <option value="R">R</option>
      <option value="NC-17">NC-17</option>
      <option value="surrendere">surrendere</option>
    </select><br><br>
    Actor:&nbsp;
    <?php
       echo '<select name="actor">';
       $query = "SELECT first, last FROM Actor;";
       $rs_dir = mysql_query($query, $db_connection);
       while ($row = mysql_fetch_row($rs_dir)) {
         echo "<option>" . $row[0] . " " . $row[1] . "</option>";
       }
       echo '</select>';
    ?>&nbsp;&nbsp;
    Role:&nbsp;
    <input type="text" name="role">
    <br><br>
    Genre:&nbsp;<br>    
    <input type = "checkbox" name = "genre[]" value = "Action">Action
    <input type = "checkbox" name = "genre[]" value = "Adult">Adult
    <input type = "checkbox" name = "genre[]" value = "Adventure">Adventure
    <input type = "checkbox" name = "genre[]" value = "Animation">Animation
    <input type = "checkbox" name = "genre[]" value = "Comedy">Comedy
    <input type = "checkbox" name = "genre[]" value = "Crime">Crime
    <input type = "checkbox" name = "genre[]" value = "Documentary">Documentary
    <input type = "checkbox" name = "genre[]" value = "Drama">Drama
    <input type = "checkbox" name = "genre[]" value = "Family">Family
    <input type = "checkbox" name = "genre[]" value = "Fantasy">Fantasy
    <input type = "checkbox" name = "genre[]" value = "Horror">Horror
    <input type = "checkbox" name = "genre[]" value = "Musical">Musical
    <input type = "checkbox" name = "genre[]" value = "Mystery">Mystery
    <input type = "checkbox" name = "genre[]" value = "Romance">Romance
    <input type = "checkbox" name = "genre[]" value = "Sci-Fi">Sci-Fi
    <input type = "checkbox" name = "genre[]" value = "Short">Short
    <input type = "checkbox" name = "genre[]" value = "Thriller">Thriller
    <input type = "checkbox" name = "genre[]" value = "War">War
    <input type = "checkbox" name = "genre[]" value = "Western">Western
    <br><br>
    <input type="submit" value="Submit">
  </form>

<br>

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $title = $_POST["title"];
     $company = $_POST["company"];
     $year = $_POST["year"];
     $director = $_POST["director"];
     $s1 = $s1 = split(" ", $director);
     $dir_first = $s1[0];
     $dir_last = $s1[1];
     $actor = $_POST["actor"];
     $s2 = split(" ", $actor);
     $act_first = $s2[0];
     $act_last = $s2[1];
     $role = $_POST["role"];
     $rating = $_POST["rating"];
     $genre = $_POST["genre"];
   }
   if (empty($title) or empty($company) or empty($genre)) {
     echo "*Please enter the title, company, year, rating and genre of your movie.";
   }
   else {
     $query = "SELECT id FROM MaxMovieID;";
     $rs = mysql_query($query, $db_connection);
     $row = mysql_fetch_row($rs);
     $maxID = $row[0] + 1;

     $query = "UPDATE MaxMovieID SET id = $maxID;";
     mysql_query($query, $db_connection);
     $query = "INSERT INTO Movie VALUES ($maxID, '$title', $year, '$rating', '$company');";     
     mysql_query($query, $db_connection);

     $query = "SELECT id FROM Director WHERE first = '$dir_first' AND last = '$dir_last';";
     $rs = mysql_query($query, $db_connection);
     $row = mysql_fetch_row($rs);
     $did = $row[0];
     $query = "INSERT INTO MovieDirector VALUES ($maxID, $did);";     
     mysql_query($query, $db_connection);   

     $query = "SELECT id FROM Actor WHERE first = '$act_first' AND last = '$act_last';";
     $rs = mysql_query($query, $db_connection);
     $row = mysql_fetch_row($rs);
     $aid = $row[0];
     $query = "INSERT INTO MovieActor VALUES ($maxID, $aid, '$role');";     
     mysql_query($query, $db_connection);   

     foreach ($genre as $g) { 
       $query = "INSERT INTO MovieGenre VALUES ($maxID, '$g')";
       mysql_query($query, $db_connection);
     }     
     echo "$title was successfully inserted!";
   }
   mysql_close($db_connection);
?>
</div>

</body>
</html>
