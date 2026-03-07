<?php
include 'conexao.php';

$busca = $_GET['busca'] ?? '';

if($busca){
$sql = "SELECT * FROM receitas WHERE nome LIKE ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$busca%"]);
$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
$sql = "SELECT * FROM receitas";
$stmt = $pdo->query($sql);
$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total = count($receitas);
$metade = ceil($total/2);

$primeira = array_slice($receitas,0,$metade);
$segunda = array_slice($receitas,$metade);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<title>Receitas Naturais para Pets</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== NAVBAR ===== */

nav.navbar{
display:flex;
align-items:center;
justify-content:space-between;
gap:20px;

background:rgba(255,255,255,0.35);
backdrop-filter:blur(15px);
-webkit-backdrop-filter:blur(15px);

border-radius:12px;
padding:10px 20px;

box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

nav ul.nav{
display:flex;
align-items:center;
gap:15px;
margin:0;
}

nav ul.nav li a{
transition:0.25s;
border-radius:8px;
}

nav ul.nav li a:hover{
background:rgba(255,255,255,0.35);
}

/* ===== SECTIONS ===== */

section{
background:rgba(255,255,255,0.35);
backdrop-filter:blur(15px);

padding:25px;
margin:30px auto;
border-radius:12px;
max-width:1200px;
}

/* ===== FOOTER ===== */

footer{
background:rgba(255,255,255,0.35);
backdrop-filter:blur(15px);

padding:20px;
margin-top:40px;
text-align:center;
border-radius:12px;
}

/* ===== BOTÃO ADD ===== */

.add-recipe-btn{
background:#6abf69;
border:none;
color:white;
padding:10px 18px;
border-radius:8px;
text-decoration:none;
transition:0.2s;
}

.add-recipe-btn:hover{
background:#57a856;
transform:translateY(-2px);
}

/* ===== CARDS ===== */

.recipe-card{
min-width:250px;
max-width:250px;
margin-right:15px;

border-radius:10px;
overflow:hidden;

transition:0.25s;
}

.recipe-card:hover{
transform:translateY(-6px);
box-shadow:0 8px 25px rgba(0,0,0,0.15);
}

.recipe-card img{
width:100%;
height:150px;
object-fit:cover;
}

/* ===== CARROSSEL ===== */

.carousel-container{
overflow:hidden;
position:relative;
}

.carousel-track{
display:flex;
transition:transform 0.4s ease;
}

.carousel-btn{
position:absolute;
top:40%;
background:white;
border:none;
font-size:25px;
padding:5px 12px;
cursor:pointer;
}

.prev{
left:0;
}

.next{
right:0;
}

/* scroll suave */

html{
scroll-behavior:smooth;
}

</style>
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-light">

<div class="container-fluid">

<a class="navbar-brand">PetReceitas</a>

<form class="d-flex" method="GET">
<input class="form-control me-2" type="search" placeholder="Buscar receita" name="busca">
<button class="btn btn-outline-success">Buscar</button>
</form>

<ul class="nav">
<li class="nav-item">
<a class="nav-link active" href="#ini">Receitas</a>
</li>

<li class="nav-item">
<a class="nav-link" href="adicionar.php">Adicionar</a>
</li>
</ul>

</div>
</nav>


<!-- PRIMEIRA SEÇÃO -->

<section id="ini">

<h2 class="section-title">Receitas Naturais</h2>

<a href="adicionar.php" class="add-recipe-btn">
Adicionar Receita
</a>

<div class="carousel-container">

<button class="carousel-btn prev" onclick="slide(-1,0)">❮</button>

<div class="carousel-track" id="track0">

<?php foreach($primeira as $r): ?>

<div class="card recipe-card">

<img src="<?= $r['imagem'] ?>">

<div class="card-body">

<h5 class="card-title">
<?= $r['nome'] ?>
</h5>

<p class="card-text">
<?= substr($r['ingredientes'],0,80) ?>...
</p>

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success">
Ver receita
</a>

</div>
</div>

<?php endforeach; ?>

</div>

<button class="carousel-btn next" onclick="slide(1,0)">❯</button>

</div>

</section>


<!-- SEGUNDA SEÇÃO -->

<?php if(!$busca): ?>

<section>

<h2>Mais Receitas</h2>

<div class="carousel-container">

<button class="carousel-btn prev" onclick="slide(-1,1)">❮</button>

<div class="carousel-track" id="track1">

<?php foreach($segunda as $r): ?>

<div class="card recipe-card">

<img src="<?= $r['imagem'] ?>">

<div class="card-body">

<h5 class="card-title">
<?= $r['nome'] ?>
</h5>

<p class="card-text">
<?= substr($r['ingredientes'],0,80) ?>...
</p>

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success">
Ver receita
</a>

</div>
</div>

<?php endforeach; ?>

</div>

<button class="carousel-btn next" onclick="slide(1,1)">❯</button>

</div>

</section>

<?php endif; ?>


<!-- FOOTER -->

<footer>
<p>© 2026 PetReceitas - Receitas naturais para pets</p>
</footer>


<script>

let pos=[0,0];

function slide(dir,id){

const track=document.getElementById("track"+id);

const card=track.querySelector(".recipe-card");

const largura=card.offsetWidth+15;

pos[id]+=dir;

if(pos[id]<0)pos[id]=0;

track.style.transform=`translateX(${-pos[id]*largura}px)`;

}

</script>

</body>
</html>