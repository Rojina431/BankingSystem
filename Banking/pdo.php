<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=banking','Rojina');
// See the "errors" folder for details...
//$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','fred','zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);