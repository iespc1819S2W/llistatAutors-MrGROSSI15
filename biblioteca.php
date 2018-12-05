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
      $numPag= ceil($numRegistresPag/$limits) -1 ;

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

      if(isset($_POST['borrar'])){
        $id = $_POST['borrar'];
        $result= $mysqli->query("DELETE FROM autors WHERE autors.ID_AUT = $id");
      }

      $idEditar = 0;
      if(isset($_POST['btEditar'])){
        $idEditar = $_POST['btEditar'];
        
      }
      
      echo(print_r($_POST));
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title>BIBLIOTECA</title>
    <!-- <script>
    window.onload = function () {
      document.getElementById("editar").onclick = function(){
        var fila = document.getElementById("fila");
        var input = document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("name", "edicio");
        input.setAttribute("id", "<?=$row['NOM_AUT']?>");
        fila.appendChild(input);
      }
    }
    </script> -->
    
</head>
<body class="b" style="background-color: #212529">

<div class="container">
<form action="" method="POST">
  <h1 style="color: white">BIBLIOTECA</h1>
  <h3  style="color: white">Ordenacions</h3>
  
<button name="ID_AUT_ASC" class="btn btn-dark">CODI<i class="fas fa-sort-up"></i></button>
<button name="ID_AUT_DESC" class="btn btn-dark">CODI<i class="fas fa-sort-down"></i></button>
<button name="NOM_AUT_ASC" class="btn btn-dark">NOM<i class="fas fa-sort-up"></i></button>
<button name="NOM_AUT_DESC" class="btn btn-dark">NOM<i class="fas fa-sort-down"></i></button>


  <input type="hidden" value="<?=$pagina?>" name="pagina" id="pagina">
  <input type="hidden" value="<?=$orderby?>" name="orderby" id="orderby">
  <label>
      <input type="text" placeholder="Cerca NOM o ID..." name="cerca" id="cerca" value="<?=$cerca?>">
      <button class="btn btn-dark" id="butcercar" name="butcercar">CERCA PER NOM o ID</button>
  </label>
      <label>
      <!-- <h3>Paginacions</h3> -->
<button name="PRIMER" class="btn btn-dark"><i class="fas fa-angle-double-left"></i></button>
<button name="ANTERIOR" class="btn btn-dark"><i class="fas fa-angle-left"></i></button>
<button name="SEGUENT" class="btn btn-dark"><i class="fas fa-angle-right"></i></button>
<button name="DARRERA" class="btn btn-dark"><i class="fas fa-angle-double-right"></i></button>
<button name="INSERTAR" class="btn btn-dark"><i></i>INSERTAR</button>
      </label>
      <!-- EDICIONS -->
      <!-- <button name="borrar" id="borrar" style="float: right" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
      <button name="editar" id="editar" style="float: right" class="btn btn-info"><i class="fas fa-edit"></i></button> -->
  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>"ID_AUT"</th>
        <th>"NOM_AUT"</th> 
      </tr>
    </thead>
    <tbody>

<!-- // $query =("SELECT * FROM autors ORDER BY $orderby limit 10 ");
//echo($query); -->
<?php
if ($result = $mysqli->query($query)) {
  while ($row = $result->fetch_assoc()) {?>
    <tr>
    <th id="idAut"><?=$row['ID_AUT']?></th>
   
    <td id="nomAut">
    <?php if($idEditar == $row['ID_AUT']){?> 

    <input type="text" name="edicio" id="edicio" value="<?=$row['NOM_AUT']?>">
    <button name="confirmar" id="btConfirmar" style="float: right" class="btn btn-success">CONFIRMAR</button>
    <button name="cancelar" id="btCancelar" style="float: right" class="btn btn-danger">CANCELAR</button>
    <?php 
    $idEditar = 0;
    }else{
      echo $row["NOM_AUT"]; ?>

      <button name="borrar" id="btBorrar" value="<?=$row['ID_AUT']?>" style="float: right" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
      <button name="editar" id="btEditar" value="<?=$row['ID_AUT']?>" style="float: right" class="btn btn-info"><i class="fas fa-edit"></i></button>
    <?php
    }?>
    </td>
   
    </tr>
        <!-- echo ("<tr>");
        echo ("<th scope='row'> ". $row["ID_AUT"]."</th>");
        echo("<td>". $row["NOM_AUT"] .'<button name="borrar" id="borrar" value="'.$row['ID_AUT'].'" style="float: right" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>' .  '<button name="editar" id="editar" value="'.$row['ID_AUT'].'" style="float: right" class="btn btn-info"><i class="fas fa-edit"></i></button>' . "</td>");
        echo ("</tr>"); -->
 <?php   }
}?>

<!-- // si s'autor que vull pintar es = a ID_AUT obrim la fila amb un input recollir quin es l'autor a editar dins una variable i posar en edicio l'autor -->

    </tbody>
  </table>
</form>
</div>
</body>
</html>
