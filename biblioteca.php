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
      If(isset($_POST['orderby'])){
        $orderby = $_POST['orderby'];
      }
      $cerca="";
      if(isset($_POST['cerca'])){
        $cerca = $_POST['cerca'];
      }
      
      $limits = 20;
      $pagina= 0;
      if(isset($_POST['pagina'])){
        $pagina = $_POST['pagina'];
      }
      $result= $mysqli->query("SELECT * FROM autors WHERE NOM_AUT LIKE '%" .$cerca. "%' OR ID_AUT LIKE '%" .$cerca. "%'");
    
      $numRegistresPag= mysqli_num_rows($result);
      $numPag= ceil($numRegistresPag/$limits);

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
      
      
      if(isset($_POST['PRIMER'])){
        $pagina=0;
        
      }
      
      if(isset($_POST['SEGUENT'])){
        if($pagina < $numPag){
          $pagina = $pagina +1;
        }
      }
      if(isset($_POST['ANTERIOR'])){
        if($pagina > 0){
          $pagina = $pagina -1;
        }
      }
      if(isset($_POST['DARRERA'])){
        
          $pagina = $numPag;
        
      }
      
      $tuplaInici=$pagina * $limits;
      $query = "SELECT * FROM autors WHERE NOM_AUT LIKE '%" .$cerca. "%' OR ID_AUT LIKE '%" .$cerca. "%' ORDER BY $orderby LIMIT $tuplaInici,$limits"; 
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
    <title>biblioteca</title>
</head>
<body class="b">

<form action="" method="POST">
<div class="container">
  <h2>BIBLIOTECA</h2>
<button name="ID_AUT_ASC" class="btn btn-dark">CODI ASCENDENT</button>
<button name="ID_AUT_DESC" class="btn btn-dark">CODI DESCENDENT</button>
<button name="NOM_AUT_ASC" class="btn btn-dark">NOM ASCENDENT</button>
<button name="NOM_AUT_DESC" class="btn btn-dark">NOM DESCENDENT</button>
<button name="PRIMER" class="btn btn-dark">PRIMER</button>
<button name="DARRERA" class="btn btn-dark">DARRERA</button>
<button name="SEGUENT" class="btn btn-dark">SEGÜENT</button>
<button name="ANTERIOR" class="btn btn-dark">ANTERIOR</button>
  <input type="hidden" value="<?=$pagina?>" name="pagina" id="pagina">
  <input type="hidden" value="<?=$orderby?>" name="orderby" id="orderby">
      <input type="text" placeholder="Cerca NOM..." name="cerca" id="cerca" value="<?=$cerca?>">
      <button class="btn btn-dark" id="butcercar" name="butcercar">CERCA PER NOM i ID</button>
      
      
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
echo($query);
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
