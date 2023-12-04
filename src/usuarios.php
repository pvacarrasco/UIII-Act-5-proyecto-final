<?php
session_start();
$permiso = 'usuarios';
$id_user = $_SESSION['idUser'];
include "../conexion.php";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
if (!empty($_POST)) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $user = $_POST['usuario'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $ciudad = $_POST['ciudad'];
    $alert = "";
    if (empty($nombre) || empty($email) || empty($user)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todo los campos son obligatorio
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
        if (empty($id)) {
            $clave = $_POST['clave'];
            if (empty($clave)) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    La contraseña es requerido
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $clave = md5($_POST['clave']);
                $query = mysqli_query($conexion, "SELECT * FROM usuario where correo = '$email'");
                $result = mysqli_fetch_array($query);
                if ($result > 0) {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    El correo ya existe
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                } else {
                    $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave,apellidos,telefono,direccion,cp,ciudad) values ('$nombre', '$email', '$user', '$clave','$apellidos','$telefono','$direccion','$cp','$ciudad')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Registrado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    } else {
                        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al registrar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    }
                }
            }
        } else {
            $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$email' , usuario = '$user', apellidos = '$apellidos', telefono = '$telefono', direccion = '$direccion', cp = '$cp', ciudad = '$ciudad' WHERE idusuario = $id");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Modificado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al modificar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
        }
    }
}
include "includes/header.php";
?>
<div class="card">
    <div class="card-body">
        <form action="" method="post" autocomplete="off" id="formulario">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" placeholder="Ingrese Nombre" name="nombre" id="nombre">
                        <input type="hidden" id="id" name="id">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" placeholder="Ingrese apellidos" name="apellidos" id="apellidos">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" placeholder="Ingrese Usuario" name="usuario" id="usuario">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="clave">Contraseña</label>
                        <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="clave" id="clave">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" class="form-control" placeholder="Ingrese Teléfono" name="telefono" id="telefono">
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" placeholder="Ingrese direccion" name="direccion" id="direccion">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cp">CP</label>
                        <input type="text" class="form-control" placeholder="Ingrese CP" name="cp" id="cp">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" class="form-control" placeholder="Ingrese ciudad" name="ciudad" id="ciudad">
                    </div>
                </div>
            </div>
            <input type="submit" value="Registrar" class="btn btn-info" id="btnAccion">
            <input type="button" value="Nuevo" class="btn btn-dark" id="btnNuevo" onclick="limpiar()">
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>Id Usuarios</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>CP</th>
                <th>Ciudad</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conexion, "SELECT * FROM usuario");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>

                        <td><?php echo $data['idusuario']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['apellidos']; ?></td>
                        
                        <td><?php echo $data['usuario']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['correo']; ?></td>
                        <td><?php echo $data['direccion']; ?></td>
                        <td><?php echo $data['cp']; ?></td>
                        <td><?php echo $data['ciudad']; ?></td>
                        <td>
                            <a href="rol.php?id=<?php echo $data['idusuario']; ?>" class="btn btn-warning"><i class='fas fa-key'></i></a>
                            <a href="#" onclick="editarUsuario(<?php echo $data['idusuario']; ?>)" class="btn btn-success"><i class='fas fa-edit'></i></a>
                            <form action="eliminar_usuario.php?id=<?php echo $data['idusuario']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<?php include_once "includes/footer.php"; ?>