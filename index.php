<?php

$host = "localhost";
$db = "restaurante";
$user = "root";
$pass = "";

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);

$busca = $_GET['busca'] ?? "";

/* limitar texto */
function limitarTexto($texto,$limite=12){

$palavras = explode(" ",$texto);

if(count($palavras) > $limite){
return implode(" ",array_slice($palavras,0,$limite))."...";
}

return $texto;
}

/* busca */

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Receitas Naturais para Pets</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f7f9fc;
font-family:Segoe UI;
padding:30px;
}

.section-title{
margin-top:40px;
margin-bottom:20px;
}

/* CARROSSEL */

.carousel-container{
position:relative;
}

.carousel-track{
display:flex;
overflow-x:auto;
scroll-behavior:smooth;
gap:20px;
padding:10px;
}

.carousel-track::-webkit-scrollbar{
display:none;
}

/* CARDS */

.card-receita{
min-width:250px;
max-width:250px;
flex-shrink:0;
transition:.3s;
}

.card-receita img{
height:160px;
object-fit:cover;
}

.card-receita:hover{
transform:scale(1.05);
}

.card-body{
display:flex;
flex-direction:column;
}

.card-body a{
margin-top:auto;
}

/* BOTÕES */

.scroll-btn{
position:absolute;
top:40%;
transform:translateY(-50%);
background:#26a69a;
border:none;
color:white;
width:40px;
height:40px;
border-radius:50%;
cursor:pointer;
z-index:10;
}

.scroll-left{
left:-10px;
}

.scroll-right{
right:-10px;
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

<div class="carousel-container">

<button class="scroll-btn scroll-left" onclick="scrollCarousel('busca',-300)">❮</button>

<div class="carousel-track" id="busca">

<?php foreach($receitas as $r){ ?>

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

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success w-100">
Ver Receita
</a>

</div>

</div>

<?php } ?>

</div>

<button class="scroll-btn scroll-right" onclick="scrollCarousel('busca',300)">❯</button>

</div>

<?php }else{ ?>

<!-- SEÇÃO 1 -->

<h3 class="section-title">
🥗 Receitas Saudáveis
</h3>

<div class="carousel-container">

<button class="scroll-btn scroll-left" onclick="scrollCarousel('car1',-300)">❮</button>

<div class="carousel-track" id="car1">

<?php foreach($secao1 as $r){ ?>

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

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success w-100">
Ver Receita
</a>

</div>

</div>

<?php } ?>

</div>

<button class="scroll-btn scroll-right" onclick="scrollCarousel('car1',300)">❯</button>

</div>


<!-- SEÇÃO 2 -->

<h3 class="section-title">
🍗 Mais Receitas Naturais
</h3>

<div class="carousel-container">

<button class="scroll-btn scroll-left" onclick="scrollCarousel('car2',-300)">❮</button>

<div class="carousel-track" id="car2">

<?php foreach($secao2 as $r){ ?>

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

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success w-100">
Ver Receita
</a>

</div>

</div>

<?php } ?>

</div>

<button class="scroll-btn scroll-right" onclick="scrollCarousel('car2',300)">❯</button>

</div>

<?php } ?>

</div>


<script>

function scrollCarousel(id,amount){

document.getElementById(id).scrollBy({
left:amount,
behavior:"smooth"
});

}

</script>

</body>
</html>