<?php

require'conexao.php';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);

$busca = $_GET['busca'] ?? "";

/* função para limitar texto */
function limitarTexto($texto,$limite=12){

$palavras = explode(" ",$texto);

if(count($palavras) > $limite){
return implode(" ",array_slice($palavras,0,$limite))."...";
}

return $texto;
}

/* consulta */

if($busca != ""){

$sql = "SELECT * FROM receitas 
WHERE nome LIKE :busca 
OR ingredientes LIKE :busca";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":busca","%$busca%");
$stmt->execute();

$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

}else{

$sql = "SELECT * FROM receitas";
$stmt = $pdo->query($sql);
$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

$total = count($receitas);
$metade = ceil($total/2);

$secao1 = array_slice($receitas,0,$metade);
$secao2 = array_slice($receitas,$metade);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<title>Receitas Naturais para Pets</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f7f9fc;
font-family:Segoe UI;
padding:30px;
}



.card-receita{
height:100%;
transition:.3s;
}

.card-receita img{
height:180px;
object-fit:cover;
}

.card-receita:hover{
transform:scale(1.03);
}

.section-title{
margin-top:40px;
margin-bottom:20px;
}

.card-body{
display:flex;
flex-direction:column;
justify-content:space-between;
}

.card-body a{
margin-top:auto;
}

</style>

</head>

<body>

<div class="container">

<h1 class="text-center mb-4">
🐾 Receitas Naturais para Pets
</h1>


<!-- BUSCA -->

<form method="GET" class="mb-5">

<div class="input-group">

<input 
type="text"
name="busca"
class="form-control"
placeholder="Pesquisar receita..."
value="<?= htmlspecialchars($busca) ?>"
>

<button class="btn btn-success">
Pesquisar
</button>

<a href="index.php" class="btn btn-secondary">
Limpar
</a>

</div>

</form>


<?php if($busca != ""){ ?>

<!-- RESULTADO DA BUSCA -->

<h3 class="section-title">
Resultados da busca
</h3>

<div class="row">

<?php foreach($receitas as $r){ ?>

<div class="col-md-3 mb-4">

<div class="card card-receita">

<img src="<?= $r['imagem'] ?>" class="card-img-top">

<div class="card-body">

<h5><?= $r['nome'] ?></h5>

<p>
<b>Ingredientes:</b><br>
<?= limitarTexto($r['ingredientes']) ?>
</p>

<p>
<b>Modo:</b><br>
<?= limitarTexto($r['modPrep']) ?>
</p>

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success">
Ver Receita
</a>

</div>
</div>

</div>

<?php } ?>

</div>

<?php }else{ ?>

<!-- PRIMEIRA SEÇÃO -->

<h3 class="section-title">
🥗 Receitas Saudáveis
</h3>

<div class="row">

<?php foreach($secao1 as $r){ ?>

<div class="col-md-3 mb-4">

<div class="card card-receita">

<img src="<?= $r['imagem'] ?>" class="card-img-top">

<div class="card-body">

<h5><?= $r['nome'] ?></h5>

<p>
<b>Ingredientes:</b><br>
<?= limitarTexto($r['ingredientes']) ?>
</p>

<p>
<b>Modo:</b><br>
<?= limitarTexto($r['modPrep']) ?>
</p>

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success">
Ver Receita
</a>

</div>
</div>

</div>

<?php } ?>

</div>


<!-- SEGUNDA SEÇÃO -->

<h3 class="section-title">
🍗 Mais Receitas Naturais
</h3>

<div class="row">

<?php foreach($secao2 as $r){ ?>

<div class="col-md-3 mb-4">

<div class="card card-receita">

<img src="<?= $r['imagem'] ?>" class="card-img-top">

<div class="card-body">

<h5><?= $r['nome'] ?></h5>

<p>
<b>Ingredientes:</b><br>
<?= limitarTexto($r['ingredientes']) ?>
</p>

<p>
<b>Modo:</b><br>
<?= limitarTexto($r['modPrep']) ?>
</p>

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success">
Ver Receita
</a>

</div>
</div>

</div>

<?php } ?>

</div>

<?php } ?>

</div>

</body>
</html>