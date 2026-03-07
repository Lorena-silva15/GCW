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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comic+Relief:wght@400;700&family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

<style>

body{
background-image:url('img/image.png)';
font-family:"Comic Relief", system-ui;;
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