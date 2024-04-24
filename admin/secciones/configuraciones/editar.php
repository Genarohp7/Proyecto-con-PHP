<?php 

include("../../bd.php"); 

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']) )?$_GET['txtID']: "" ;

    $sentencia=$conexion->prepare(" SELECT * FROM tbl_configuraciones WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    
    $nombreconfiguracion=$registro['nombreconfiguracion'];
    $valor=$registro['valor'];
  

}

if($_POST){

    //recibir valores de formulario
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $nombreconfiguracion=(isset($_POST['nombreconfiguracion']))?$_POST['nombreconfiguracion']:"";
    $valor=(isset($_POST['valor']))?$_POST['valor']:"";
   

    $sentencia=$conexion->prepare("UPDATE `tbl_configuraciones` 
    SET nombreconfiguracion=:nombreconfiguracion, valor=:valor WHERE id=:id;");

    $sentencia->bindparam(":nombreconfiguracion",$nombreconfiguracion);
    $sentencia->bindparam(":valor",$valor);
    $sentencia->bindparam(":id",$txtID);
   

    $sentencia->execute();
    $mensaje="Registro agregado con exito.";
    header("Location:index.php?mensaje=" .$mensaje);

    

}

include("../../template/header.php"); ?>


<div class="card">
    <div class="card-header">Configuracion</div>
    <div class="card-body">
  
    <form action="" method="post">

    <div class="mb-3">
        <label for="txtID" class="form-label">ID:</label>
        <input
            readonly
            type="text"
            class="form-control"
            value="<?php echo $txtID; ?>"
            name="txtID"
            id="txtID"
            aria-describedby="helpId"
            placeholder="ID"
        />
    </div>
    

   

    <div class="mb-3">
        <label for="nombreconfiguracion" class="form-label">Nombre:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $nombreconfiguracion; ?>"
            name="nombreconfiguracion"
            id="nombreconfiguracion"
            aria-describedby="helpId"
            placeholder="Nombre de la configuracion"
        />
        
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Valor:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $valor; ?>"
            name="valor"
            id="valor"
            aria-describedby="helpId"
            placeholder="Valor de la configuracion"
        />
       
    </div>

    <button
    type="submit"
    class="btn btn-success"
   >
    Actualizar
   </button>

   <a
    name=""
    id=""
    class="btn btn-primary"
    href="index.php"
    role="button"
    >Cancelar</a
   >
    
    
    
    </form>

    </div>
    
</div>

<?php include("../../template/footer.php"); ?>