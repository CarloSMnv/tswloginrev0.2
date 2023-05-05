<?php
require_once "config.php"; 
  function write_login_log($email, $error, $validation) {
    global $pdo;
    $estado = $error ? "FALLO" : "EXITO";
    $fecha_hora = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    $sistema_operativo = php_uname('s') . ' ' . php_uname('r');
    $log = "$estado|$fecha_hora|$email|$ip|$navegador|$sistema_operativo|$validation\n";
    
    // Insertar registro en la base de datos
    $stmt = $pdo->prepare("INSERT INTO login_logs (estado, fecha_hora, email, ip, navegador, sistema_operativo, validation) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$estado, $fecha_hora, $email, $ip, $navegador, $sistema_operativo, $validation]);
    
    // Escribir registro en archivo log.txt
    file_put_contents('log.txt', $log, FILE_APPEND);
}

?>