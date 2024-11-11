<?php 
// $database = new PDO("mysql:host=localhost;charset=utf8;dbname=razum10_platform", 'razum10', 'Pzjhw6bJ');

try{
    $host = '109.68.213.4';
    $dbname = 'razumplatform';
    $user = 'admin platform';
    $pass = 'q*TG61mg,sB+EB';
    $database = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $user, $pass);
    return $database;
}
catch(PDOException $err){
    die("Ошибка подключения: " . $err);
}
?>
