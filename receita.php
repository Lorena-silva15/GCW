<?php

require 'conexao.php';



$id = $_GET['id'];

$sql = "SELECT * FROM receitas WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id",$id);
$stmt->execute();

$receita = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<title><?= $receita['nome'] ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f7f9fc;
font-family:Segoe UI;
padding:40px;
}

.receita-box{
max-width:700px;
margin:auto;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 6px 15px rgba(0,0,0,0.05);
}

.receita-box img{
width:100%;
border-radius:10px;
margin-bottom:20px;
}

</style>

</head>

<body>

<div class="receita-box">

<h2><?= $receita['nome'] ?></h2>

<img src="<?= $receita['imagem'] ?>">

<h4>Ingredientes</h4>

<p>
<?= nl2br($receita['ingredientes']) ?>
</p>

<h4>Modo de Preparo</h4>

<p>
<?= nl2br($receita['modPrep']) ?>
</p>

<a href="index.php" class="btn btn-secondary mt-3">
Voltar
</a>

</div>

</body>
</html>