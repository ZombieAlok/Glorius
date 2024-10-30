<?php require_once('header.php'); ?>

<?php
if ( (!isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
    $var = 1;

    // Verificar que los tokens de verificación de cuenta coincidan
    $host = $_SERVER['HTTP_HOST'];
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
    $statement->execute(array($_REQUEST['email']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        if($_REQUEST['token'] != $row['cust_token']) {
            header('location: '.BASE_URL);
            exit;
        }
    }

    // Se cambia el estatus a 1 (activado) si todo está correcto
    if($var != 0)
    {
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?, cust_status=? WHERE cust_email=?");
        $statement->execute(array('',1,$_GET['email']));

        $success_message = '<p style="color:green;">Tu cuenta ha sido verificada. Ya puedes iniciar sesión.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Haz click aquí para iniciar sesión</a></p>';     
    }
}
?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1>Registro exitoso</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php 
                        echo $error_message;
                        echo $success_message;
                    ?>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>