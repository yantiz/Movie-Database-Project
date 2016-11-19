<!-- Page I3 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add comments to movie</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Add Comments to Movie</p>
<div>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Reviewer:&nbsp;&nbsp;&nbsp;<input type="text" name="reviewer" placeholder="Anonymous"><br><br>
    Title and Year:&nbsp;
    <?php
       echo '<select name="movieinfo">';
       $db_connection = connect();
       $id = $_GET["id"];
       if ($id) {
         $query = "SELECT title, year FROM Movie WHERE id = $id;";
       }
       else {
         $query = "SELECT title, year FROM Movie;";
       }
       $rs = mysql_query($query, $db_connection);
       while ($row = mysql_fetch_row($rs)) {
         echo "<option>" . $row[0] . " - " . $row[1] . "</option>";
       }
       echo '</select>';
    ?><br><br>
    Rating:&nbsp;
    <select name="rating">
      <option value="1">1 - Strongly discouraged</option>
      <option value="2">2 - Discouraged</option>
      <option value="3">3 - Fair</option>
      <option value="4">4 - Encouraged</option>
      <option value="5">5 - Strongly encouraged</option>
    </select><br><br>
    Comment:<br>
    <textarea name="comment" cols=60 rows=8></textarea><br><br>
    <input type="submit" value="Submit">
  </form>

<br>

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $reviewer = $_POST["reviewer"];
     $movieinfo = $_POST["movieinfo"];
     $s = split("-", $movieinfo);
     $title = $s[0];
     $year = $s[1];
     $rating = $_POST["rating"];
     $comment = $_POST["comment"];
     if (empty($reviewer)) {
       $reviewer = "null";
     }
   }
   if (empty($comment)) {
     echo "*Please at least enter your comment and choose the correct title and year of your movie.";
   }
   else {
     $query = "SELECT * FROM Movie WHERE title = '$title' AND year = $year;";
     $rs = mysql_query($query, $db_connection);
     $row = mysql_fetch_row($rs);
     $mid = $row[0];
     $query = "INSERT INTO Review VALUES ('$reviewer', CURRENT_TIMESTAMP, $mid, $rating, '$comment');";
     mysql_query($query, $db_connection);
     echo "Comment to <$movieinfo> was successful inserted!";
   }
   mysql_close($db_connection);
?>
</div>

</body>
</html>
