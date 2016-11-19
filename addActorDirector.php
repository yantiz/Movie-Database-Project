<!-- Page I1 -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add actor or director information</title>
</head>

<body>
<?php require_once('homepage.php');?>

<p style="font-size:120%;">Add Actor/Director</p>
<div>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Indentity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="identity" value="Actor" checked>Actor
    <input type="radio" name="identity" value="Director">Director<br><br>
    First Name:&nbsp;&nbsp;&nbsp;<input type="text" name="firstname"><br><br>
    Last Name:&nbsp;&nbsp;&nbsp;<input type="text" name="lastname"><br><br>
    Gender:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="gender" value="male" checked>Male
    <input type="radio" name="gender" value="female">Female<br><br>
    Date of Birth:&nbsp;&nbsp;&nbsp;
    Year&nbsp;
    <?php
       echo '<select name="birthyear">';
       for ($i = 1888; $i <= 2016; $i++) {
         echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?>&nbsp;&nbsp;&nbsp;
    Month&nbsp;
    <?php
       echo '<select name="birthmonth">';
       for ($i = 1; $i <= 12; $i++) {
	 echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?>&nbsp;&nbsp;&nbsp;
    Day&nbsp;
    <?php
       echo '<select name="birthday">';
       for ($i = 1; $i <= 31; $i++) {
	 echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?><br><br>       
    Date of Death:&nbsp;&nbsp;&nbsp;Year&nbsp;
    <?php
       echo '<select name="deathyear">';
       echo "<option>" . "N/A" . "</option>";
       for ($i = 1888; $i <= 2016; $i++) {
         echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?>&nbsp;&nbsp;&nbsp;
    Month&nbsp;
    <?php
       echo '<select name="deathmonth">';
       echo "<option>" . "N/A" . "</option>";
       for ($i = 1; $i <= 12; $i++) {
	 echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?>&nbsp;&nbsp;&nbsp;
    Day&nbsp;
    <?php
       echo '<select name="deathday">';
       echo "<option>" . "N/A" . "</option>";
       for ($i = 1; $i <= 31; $i++) {
	 echo "<option>" . $i . "</option>";
       }
       echo '</select>';
    ?><br><br>              
    <input type="submit" value="Submit">
  </form>

<br>

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $identity = $_POST["identity"];
     $firstname = $_POST["firstname"];
     $lastname = $_POST["lastname"];
     $gender = $_POST["gender"];
     $birthyear = $_POST["birthyear"];
     $birthmonth = $_POST["birthmonth"];
     $birthday = $_POST["birthday"];
     $deathyear = $_POST["deathyear"];
     $deathmonth = $_POST["deathmonth"];
     $deathday = $_POST["deathday"];
   }
   if (empty($firstname) or empty($lastname)) {
     echo "*Please type the full name and choose the correct date of birth of your actor/director.";
   }
   else {
     $birth = formatdate($birthyear, $birthmonth, $birthday);
     $death = formatdate($deathyear, $deathmonth, $deathday);
     $db_connection = connect();
     $query = "SELECT id FROM MaxPersonID;";
     $rs = mysql_query($query, $db_connection);
     $row = mysql_fetch_row($rs);
     $maxID = $row[0] + 1;
     $query = "UPDATE MaxPersonID SET id = $maxID;";
     mysql_query($query, $db_connection);
     if ($identity == "Actor") {
       $query = "INSERT INTO Actor VALUES($maxID, '$lastname', '$firstname', '$gender', $birth, $death);";
     } 
     else {
         $query = "INSERT INTO Director VALUES($maxID, '$lastname', '$firstname', $birth, $death);";
     }
     mysql_query($query, $db_connection);
     mysql_close($db_connection);
     echo "$firstname $lastname ($identity) was successfully inserted!";
   }
?>
</div>

</body>
</html>
