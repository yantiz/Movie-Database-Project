<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Web Query Interface</title>
</head>

<body>

<h4>Please type your query in the textarea below</h4>
<p>Example: SELECT * FROM Movie;</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <textarea cols="60" rows="10" name="query"></textarea><br>
    <input type="submit" value="Submit">
</form>


<?php
   function connect() {
      $db_connection = mysql_connect("localhost", "cs143", "");
      if (!$db_connection) {
         $errmsg = mysql_error($db_connection);
         echo "Connection to database failed: $errmsg<br>";
         exit(1);
      }
      mysql_select_db("CS143", $db_connection);
      return $db_connection;
   }

   function parsingResult($rs) {
      if (!$rs) {
         $errmsg = mysql_error();
         echo "Failed to run query: $errmsg<br>";
         exit(1);
      }
      $rows = mysql_num_rows($rs);
      $cols = mysql_num_fields($rs);
      if ($rows == 0) {
        echo "There is no matching record.";
        return;
      }
      echo "<table border='1' style='width:50%'>";
      echo "<tr>";
      for ($i = 0; $i < $cols; $i++){
         $attr = mysql_field_name($rs, $i);
         echo "<th>$attr</th>";
      }
      echo "</tr>";
      while($tuple = mysql_fetch_row($rs)) {
         echo"<tr>";
	 foreach ($tuple as $value) {
	    if ($value) {
               echo "<td>$value</td>";
            } else {
               echo "<td>N/A</td>";
            }
	 }
         echo"</tr>";   
      }
      echo "</table>";
   }
?>

<?php
   if($_POST["query"]) {
      $db_connection = connect();
      $rs = mysql_query($_POST["query"], $db_connection);
      parsingResult($rs);
      mysql_close($db_connection);
   }
?>

</body>
</html>
