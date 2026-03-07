<?php
require 'conexao.php';

$search = trim($_GET['search'] ?? "");

if ($search !== "") {
    $sql = "SELECT * FROM receitas WHERE nome LIKE :search OR ingredientes LIKE :search ORDER BY criado_em DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':search' => "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM receitas ORDER BY criado_em DESC");
}

$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receitas</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>

<style>

body{
background:#f7f9fc;
font-family:'Segoe UI',sans-serif;
}

.card{
border-radius:15px;
overflow:hidden;
transition:0.3s;
background:#ffffff;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
cursor:pointer;
}

.card:hover{
transform:scale(1.03);
}

.card img{
width:100%;
height:140px;
object-fit:cover;
}

.card h5{
font-weight:600;
}

.card-text{
display:-webkit-box;
-webkit-line-clamp:3;
-webkit-box-orient:vertical;
overflow:hidden;
}

.section-title{
text-align:center;
margin:30px 0 15px;
color:#00796b;
font-weight:600;
}

.add-recipe-btn{
display:block;
max-width:200px;
margin:30px auto 20px;
padding:12px 20px;
background:#ff9800;
color:white;
text-align:center;
border-radius:20px;
text-decoration:none;
font-weight:600;
}

.add-recipe-btn:hover{
background:#fb8c00;
}

</style>
</head>

<body>

<nav class="navbar bg-body-tertiary">
<div class="container-fluid">

<a class="navbar-brand">Receitas</a>

<form method="GET" class="d-flex" role="search">
<input class="form-control me-2" type="search" name="search"
placeholder="Buscar receita..."
value="<?= htmlspecialchars($search) ?>">
<button class="btn btn-outline-success" type="submit">Buscar</button>
</form>

<div class="dropdown">
<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
Menu
</button>

<ul class="dropdown-menu">
<li><a class="dropdown-item" href="formreceita.html">Adicionar Receita</a></li>
<li><a class="dropdown-item" href="#">Outra opção</a></li>
</ul>
</div>

</div>
</nav>

<a href="formreceita.html" class="add-recipe-btn">
Adicionar Receita
</a>

<main class="container my-4">

<?php if(count($receitas) > 0): ?>

<h2 class="section-title">Receitas</h2>

<div class="swiper mySwiper">

<div class="swiper-wrapper">

<?php foreach($receitas as $r): ?>

<div class="swiper-slide">

<div class="card" style="width:18rem;margin:auto;">

<?php if($r['imagem']): ?>

<img src="<?= htmlspecialchars($r['imagem']) ?>" alt="<?= htmlspecialchars($r['nome']) ?>">

<?php endif; ?>

<div class="card-body">

<h5 class="card-title">
<?= htmlspecialchars($r['nome']) ?>
</h5>

<p class="card-text">
<?= htmlspecialchars($r['ingredientes']) ?>
</p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<div class="swiper-button-next swiper1-next"></div>
<div class="swiper-button-prev swiper1-prev"></div>

</div>

<?php else: ?>

<p class="text-center text-muted">
Nenhuma receita encontrada.
</p>

<?php endif; ?>

<h2 class="section-title">Destaques</h2>

<div class="swiper mySwiper2">

<div class="swiper-wrapper">

<?php foreach(array_slice($receitas,0,6) as $r): ?>

<div class="swiper-slide">

<div class="card" style="width:16rem;margin:auto;">

<?php if($r['imagem']): ?>

<img src="<?= htmlspecialchars($r['imagem']) ?>" alt="<?= htmlspecialchars($r['nome']) ?>">

<?php endif; ?>

<div class="card-body">

<h5 class="card-title">
<?= htmlspecialchars($r['nome']) ?>
</h5>

<p class="card-text">
<?= htmlspecialchars($r['ingredientes']) ?>
</p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<div class="swiper-button-next swiper2-next"></div>
<div class="swiper-button-prev swiper2-prev"></div>

</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<script>

const swiper1 = new Swiper(".mySwiper",{
slidesPerView:3,
spaceBetween:20,
navigation:{
nextEl:".swiper1-next",
prevEl:".swiper1-prev"
},
breakpoints:{
0:{slidesPerView:1},
576:{slidesPerView:2},
992:{slidesPerView:3}
}
});

const swiper2 = new Swiper(".mySwiper2",{
slidesPerView:3,
spaceBetween:20,
navigation:{
nextEl:".swiper2-next",
prevEl:".swiper2-prev"
},
breakpoints:{
0:{slidesPerView:1},
576:{slidesPerView:2},
992:{slidesPerView:3}
}
});

</script>

</body>
</html>