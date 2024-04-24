<?php 
include("../../bd.php"); 

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID']) )?$_GET['txtID']: "" ;

    $sentencia=$conexion->prepare(" SELECT * FROM tbl_equipo WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $imagen=$registro['imagen'];
    $nombrecompleto=$registro['nombrecompleto'];
    $puesto=$registro['puesto'];
    $twitter=$registro['twitter'];
    $facebook=$registro['facebook'];
    $linkedin=$registro['linkedin'];
   

}

if($_POST){

    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
    $nombrecompleto=(isset($_POST['nombrecompleto']))?$_POST['nombrecompleto']:"";
    $puesto=(isset($_POST['puesto']))?$_POST['puesto']:"";
    $twitter=(isset($_POST['twitter']))?$_POST['twitter']:"";
    $facebook=(isset($_POST['facebook']))?$_POST['facebook']:"";
    $linkedin=(isset($_POST['linkedin']))?$_POST['linkedin']:"";


    $sentencia=$conexion->prepare("UPDATE tbl_equipo 
    SET 

    nombrecompleto=:nombrecompleto,
    puesto=:puesto, 
    twitter=:twitter,
    facebook=:facebook,
    linkedin=:linkedin    
    WHERE id=:id");

    $sentencia->bindparam(":nombrecompleto",$nombrecompleto);
    $sentencia->bindparam(":puesto",$puesto);
    $sentencia->bindparam(":twitter",$twitter);
    $sentencia->bindparam(":facebook",$facebook);
    $sentencia->bindparam(":linkedin",$linkedin);
    $sentencia->bindparam(":id",$txtID);


    $sentencia->execute();

    if($_FILES["imagen"]["tmp_name"]!=""){

        $imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
        $fecha_imagen=new DateTime();
        $nombre_archivo_imagen=($imagen!="")? $fecha_imagen->getTimestamp()."_".$imagen:""; 

        $tmp_imagen=$_FILES["imagen"]["tmp_name"];
    
      
    
            move_uploaded_file($tmp_imagen, "../../../assets/img/team/".$nombre_archivo_imagen);
    
            //borado del archivo anterior
            $sentencia=$conexion->prepare("SELECT imagen FROM tbl_equipo WHERE id=:id");
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
            $registro_imagen=$sentencia->fetch(PDO::FETCH_LAZY);
        
            if(isset($registro_imagen["imagen"])){
        
                if(file_exists("../../../assets/img/team/".$registro_imagen["imagen"])){
        
                   unlink("../../../assets/img/team/".$registro_imagen["imagen"]);
        
                }
        
            }
        

        $sentencia=$conexion->prepare("UPDATE tbl_equipo SET imagen=:imagen  WHERE id=:id");
        $sentencia->bindparam(":imagen",$nombre_archivo_imagen);
        $sentencia->bindparam(":id",$txtID);
        $sentencia->execute();
        $imagen=$nombre_archivo_imagen;
        

    }

    $mensaje="Registro modificado con exito.";
        header("Location:index.php?mensaje=" .$mensaje);



    
}

include("../../template/header.php"); ?>


<div class="card">
    <div class="card-header">Agregar nuevo integrante</div>
    <div class="card-body">

    <form action="" enctype="multipart/form-data" method="post">

    <div class="mb-3">
        <label for="txtID" class="form-label">ID:</label>
        <input
            readonly
            type="text"
            class="form-control"
            value="<?php echo $txtID;?>"
            name="txtID"
            id="txtID"
            aria-describedby="helpId"
            placeholder="ID"
        />
        
    </div>

    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen:</label>
        <img width="50" src="../../../assets/img/team/<?php echo $imagen;?>"/>
        <input
            type="file"
            class="form-control"
            name="imagen"
            id="imagen"
            placeholder="Imagen"
            aria-describedby="fileHelpId"
        />
    </div>

    <div class="mb-3">
        <label for="nombrecompleto" class="form-label">Nombre Completo:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $nombrecompleto;?>"
            name="nombrecompleto"
            id="nombrecompleto"
            aria-describedby="helpId"
            placeholder="Nombre Completo"
        />
    </div>

    <div class="mb-3">
        <label for="puesto" class="form-label">Puesto:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $puesto;?>"
            name="puesto"
            id="puesto"
            aria-describedby="helpId"
            placeholder="Puesto"
        />
    </div>

    <div class="mb-3">
        <label for="twitter" class="form-label">X:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $twitter;?>"
            name="twitter"
            id="twitter"
            aria-describedby="helpId"
            placeholder="X"
        />
        
    </div>
    

    <div class="mb-3">
        <label for="facebook" class="form-label">Facebook:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $facebook;?>"
            name="facebook"
            id="facebook"
            aria-describedby="helpId"
            placeholder="facebook"
        />
    </div>

    <div class="mb-3">
        <label for="linkedin" class="form-label">Linkedin:</label>
        <input
            type="text"
            class="form-control"
            value="<?php echo $linkedin;?>"
            name="linkedin"
            id="linkedin"
            aria-describedby="helpId"
            placeholder="Linkedin"
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

<?php include("../../template/footer.php"); ?>