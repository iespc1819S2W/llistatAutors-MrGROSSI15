<?php
$mysqli = new mysqli("localhost", "root", "", "biblioteca");
$mysqli-> set_charset("utf8mb4");
If (!$mysqli) { 
echo "Connection error: ".mysqli_connect_error(); 
}

if (mysqli_connect_errno()) {
        printf("Error: %s\n", mysqli_connect_error()); exit();
     }
     $orderby = "ID_AUT ASC";
     $autor="";
     
     if(isset($_POST['ID_AUT_ASC'])){
       $orderby = "ID_AUT ASC";
      }
      
      if(isset($_POST['ID_AUT_DESC'])){
        $orderby = "ID_AUT DESC";
      }

      if(isset($_POST['NOM_AUT_ASC'])){
        $orderby = "NOM_AUT ASC";
      }
      if(isset($_POST['NOM_AUT_DESC'])){
        $orderby = "NOM_AUT DESC";
      }

      if(isset($_POST['cercar'])){
        $autor = $_POST['cerca'];
        $query = "SELECT * FROM autors WHERE NOM_AUT LIKE '%" .$autor. "%'"; //ID_AUT = $valor or
      }else{
        $query = "SELECT * FROM autors ORDER BY $orderby";
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>

<form action="" method="POST">
<div class="container">
  <h2>BIBLIOTECA</h2>
<button name="ID_AUT_ASC" class="btn btn-dark">CODI ASCENDENT</button>
<button name="ID_AUT_DESC" class="btn btn-dark">CODI DESCENDENT</button>
<button name="NOM_AUT_ASC" class="btn btn-dark">NOM ASCENDENT</button>
<button name="NOM_AUT_DESC" class="btn btn-dark">NOM DESCENDENT</button>
<form action="/action_page.php">
      <input type="text" placeholder="Cerca.." name="cerca" id="cerca">
      <button class="btn btn-dark" id="cercar" >CERCA</button>
    </form>
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>"ID_AUT"</th>
        <th>"NOM_AUT"</th> 
      </tr>
    </thead>
    <tbody>
<?php 
// $query =("SELECT * FROM autors ORDER BY $orderby limit 10 ");
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        echo ("<tr>");
        echo ("<th scope='row'> ". $row["ID_AUT"]."</th>");
        echo("<td>". $row["NOM_AUT"] . "</td>"); 
        echo ("</tr>");
    }
}


?>
    </tbody>
  </table>
</form>
</div>

</body>
</html>
