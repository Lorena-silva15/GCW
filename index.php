<?php

require 'conexao.php';

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

$pdo->exec("set names utf8");

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Smelly Food</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comic+Relief:wght@400;700&family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

<style>

body{
background-image: url('img/image.png');
font-family:"Comic Relief", system-ui;
padding:30px;
scroll-behavior: smooth;
}

/* NAVBAR LADO A LADO */
nav{
display:flex;
align-items:center;
justify-content:space-between;
flex-wrap:wrap;
gap:20px;
}

nav ul{
display:flex;
align-items:center;
gap:15px;
margin:0;
padding:0;
list-style:none;
}

nav ul li{
display:inline-block;
}

nav form{
display:flex;
gap:8px;
}

section{

background:rgba(255,255,255,0.4);
backdrop-filter:blur(15px);

border-radius:10px;
padding:15px;
margin-bottom:20px;

}

footer{

background:rgba(255,255,255,0.4);
backdrop-filter:blur(15px);

padding:20px;
border-radius:10px;

text-align:center;

}
.section-title{
margin-top:40px;
margin-bottom:20px;
}

//* CONTAINER */

.carousel-container{
position:relative;
width:100%;
overflow:hidden;
}

/* TRILHO */

.carousel-track{
display:flex;
gap:20px;

overflow-x:auto;
scroll-behavior:smooth;

padding:10px;

scroll-snap-type:x mandatory;
}

.carousel-track::-webkit-scrollbar{
display:none;
}

/* CARDS */

.card-receita{

min-width:260px;
max-width:260px;

flex:0 0 auto;

border-radius:12px;

transition:0.25s;

scroll-snap-align:start;

display:flex;
flex-direction:column;

}

.card-receita img{
width:100%;
height:170px;
object-fit:cover;
}

/* BOTÕES */

.scroll-btn{

position:absolute;

top:45%;

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

.scroll-btn:hover{
background:#1f8f86;
}
</style>

</head>

<body>
<nav class="navbar ">

<div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="img/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Smelly Food
    </a>
  </div>
    <form method="GET" class="mb-5">

<div class="input-group">

<input 
type="text"
name="busca"
class="form-control"
placeholder="Pesquisar receita..."
value="<?= htmlspecialchars($busca) ?>"
>

<button class="btn btn-success">Pesquisar</button>

<a href="index.php" class="btn btn-secondary">Limpar</a>

</div>

</form>
<ul class="nav">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#ini">Receitas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#med">Carrossel</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" href="#ult">Mais Receitas</a>
  </li>
</ul>
</nav>
<h1 class="text-center mb-4">
Receitas Naturais para Pets
</h1>
<div class="container">







<?php if($busca != ""){ ?>

<h3 class="section-title">Resultados</h3>

<div class="carousel-container">

<button class="scroll-btn scroll-left" onclick="scrollCarousel('busca',-300)">❮</button>

<div class="carousel-track" id="busca">

<?php foreach($receitas as $r){ ?>

<div class="card card-receita">
<img src="<?= (!empty($r['imagem']) && file_exists($r['imagem'])) ? $r['imagem'] : 'uploads/padrao.jpg' ?>" class="card-img-top">

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

<?php } else { ?>


<section id='apre'>
  <img src="img/logo.png" class="img-fluid" alt="...">
  <div>
    <h2>

    </h2>
  </div>

</section>

<section id='ini' class='row'>
  <div>
    <h3 class="section-title"> Receitas Saudáveis para Bichinhos</h3><br>
<a href="formreceita.php" class="add-recipe-btn">
Adicionar Receita
</a>
  </div>



<div class="carousel-container">


<button class="scroll-btn scroll-left" onclick="scrollCarousel('car1',-300)">❮</button>

<div class="carousel-track" id="car1">

<?php foreach($secao1 as $r){ ?>

<div class="card card-receita">

<img src="<?= $r['imagem'] ?>" class="card-img-top">
<div class="card-body">

<h5><?= $r['nome'] ?></h5>

<p><b>Ingredientes:</b><br><?= limitarTexto($r['ingredientes']) ?></p>

<p><b>Modo:</b><br><?= limitarTexto($r['modPrep']) ?></p>

<a href="receita.php?id=<?= $r['id'] ?>" class="btn btn-success w-100">
Ver Receita
</a>

</div>

</div>

<?php } ?>

</div>

<button class="scroll-btn scroll-right" onclick="scrollCarousel('car1',300)">❯</button>

</div>
</section>



<section id='med'>
<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/carrousel1.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Conheça novas receitas.</h5>
       
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/carrousel2.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Descubra o melhor da Alimentação para se pet.</h5>
        
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/carrousel3.png" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Seja mais saudável,mais feliz.</h5>
    
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</section>

<section id='ult'>

<h3 class="section-title">Mais Receitas</h3>

<div class="carousel-container">

<button class="scroll-btn scroll-left" onclick="scrollCarousel('car2',-300)">❮</button>

<div class="carousel-track" id="car2">

<?php foreach($secao2 as $r){ ?>

<div class="card card-receita">

<img src="<?= (!empty($r['imagem']) && file_exists($r['imagem'])) ? $r['imagem'] : 'uploads/padrao.jpg' ?>" class="card-img-top">

<div class="card-body">

<h5><?= $r['nome'] ?></h5>

<p><b>Ingredientes:</b><br><?= limitarTexto($r['ingredientes']) ?></p>

<p><b>Modo:</b><br><?= limitarTexto($r['modPrep']) ?></p>

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
</section>

<footer>
  <h2>
    Projeto de GCW (Gerênciamento de Conexões Web) 
    <br>
    Profª.:Edilma Bindá
    <br>
    Lorena da Silva Rodrigues - 3º C
  </h2>
   

  
</footer>



<script>

/* BOTÕES */

function scrollCarousel(id,amount){

const track=document.getElementById(id);

track.scrollBy({
left:amount,
behavior:"smooth"
});

}


/* DRAG COM MOUSE */

document.querySelectorAll(".carousel-track").forEach(track=>{

let isDown=false;
let startX;
let scrollLeft;

track.addEventListener("mousedown",e=>{

isDown=true;

track.classList.add("dragging");

startX=e.pageX-track.offsetLeft;

scrollLeft=track.scrollLeft;

});

track.addEventListener("mouseleave",()=>{

isDown=false;

});

track.addEventListener("mouseup",()=>{

isDown=false;

});

track.addEventListener("mousemove",e=>{

if(!isDown)return;

e.preventDefault();

const x=e.pageX-track.offsetLeft;

const walk=(x-startX)*2;

track.scrollLeft=scrollLeft-walk;

});

});

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>