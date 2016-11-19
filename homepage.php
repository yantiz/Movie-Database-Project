<!-- This is the base page for all other subpages -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home page</title>
    <style>
      h1.title {
      text-align:center;
      }
      p.center{
      text-align:center;
      }
      div.table{
      background-color: #B9C5C8;
      width: 250px;
      padding: 15px;
      border: 2px solid gray;

      margin-right: 30pt;
      }
      img{
      margin-right: 35pt;
      }
    </style>
</head>

<body style="background-color:lightgrey;">
<h1 class="title">Home page</h1>
<p class="center" style="color:blue;">Please feel free to insert/query any information about your favorite actors/directors or movies.</p>
<hr>

<p><img src="Supply-and-demand-movie-theater-seats.jpg" align="right" alt="Union Misalignment" style="width:700px;height:507px;">
</p>

<div class="table">
  <h3>Insert content:</h3>
  <div class="section"></div>
  <ul>
    <li><a href="./addActorDirector.php">Add actor/director</a></li>
    <li><a href="./addMovie.php">Add movie infomation</a></li>
    <li><a href="./addComment.php">Add comments to movies</a></li>
    <li><a href="./addActorMovieRelation.php">Add actor to movie relation</a></li>
    <li><a href="./addDirectorMovieRelation.php">Add director to movie relation</a></li>
  </ul>
</div>

<br>

<div class="table">
  <h3>Search content:</h3>
  <div class="section"></div>
  <ul>
    <li><a href="./showActor.php">Show actor information</a></li>
    <li><a href="./showMovie.php">Show movie information</a></li>
  </ul>
</div>

<br>

<div class="table">
  <h3>Search interface:</h3>
  <div class="section"></div>
  <ul>
    <li><a href="./search.php">Search actor/movie information</a></li>
  </ul>
</div>

<?php
   function formatdate($year, $month, $day) {
      $specify = "N/A";
      if ((strpos($year, $specify) !== false) or (strpos($month, $specify) !== false) or (strpos($day, $specify) !== false)) {
         return "null";
      } else {
          if (strlen($month) == 1) {
             $month = '0' . $month;
      }
          if (strlen($day) == 1) {
             $day = '0' . $day;
      }
          return $year . $month . $day;
      }
   }
   
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
?>

</body>
</html>
