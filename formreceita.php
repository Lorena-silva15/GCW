<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Receita</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

#loadingScreen{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(255,255,255,0.9);
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
z-index:9999;
visibility:hidden;
opacity:0;
transition:opacity .3s;
}

#loadingScreen.show{
visibility:visible;
opacity:1;
}

.spinner{
border:5px solid #f3f3f3;
border-top:5px solid #26a69a;
border-radius:50%;
width:50px;
height:50px;
animation:spin 1s linear infinite;
margin-bottom:15px;
}

@keyframes spin{
0%{transform:rotate(0deg);}
100%{transform:rotate(360deg);}
}

body{
font-family:'Segoe UI',sans-serif;
background:#f7f9fc;
padding:40px;
}

form{
max-width:600px;
margin:auto;
background:#fff;
padding:30px;
border-radius:12px;
box-shadow:0 6px 15px rgba(0,0,0,.05);
}

ul#itemList{
list-style:none;
padding-left:0;
}

ul#itemList li{
background:#e0f7fa;
padding:10px 15px;
margin-bottom:10px;
border-radius:50px;
display:flex;
justify-content:space-between;
align-items:center;
}

</style>
</head>

<body>

<!-- LOADING -->
<div id="loadingScreen">
<div class="spinner"></div>
<p>Enviando receita...</p>
</div>

<form action="adicionareceita.php" method="post" enctype="multipart/form-data">

<h2 class="mb-4 text-center">Adicionar Receita</h2>

<label>Nome da Receita</label>
<input type="text" name="nome" required class="form-control">

<label class="mt-3">Imagem da Receita</label>
<input type="file" name="img" accept="image/*" class="form-control">

<label class="mt-3">Ingredientes</label>
<input type="text" id="dynamicInput" placeholder="Digite e pressione Enter" class="form-control">

<ul id="itemList"></ul>

<!-- campo oculto que envia os ingredientes -->
<input type="hidden" name="ingredientes" id="ingredientesHidden">

<label class="mt-3">Modo de Preparo</label>
<input type="text" name="modPrep" class="form-control">

<button type="submit" class="btn btn-primary mt-4 w-100">
Adicionar Receita
</button>

</form>

<script>

const input = document.getElementById("dynamicInput");
const list = document.getElementById("itemList");
const hidden = document.getElementById("ingredientesHidden");

let items = [];

function renderList(){

list.innerHTML="";

items.forEach((item,index)=>{

const li=document.createElement("li");

const span=document.createElement("span");
span.textContent=item;

const btn=document.createElement("button");
btn.textContent="❌";

btn.onclick=()=>{
items.splice(index,1);
renderList();
};

li.appendChild(span);
li.appendChild(btn);

list.appendChild(li);

});

hidden.value = items.join(", ");

}

input.addEventListener("keydown",function(e){

if(e.key==="Enter"){

e.preventDefault();

const value=input.value.trim();

if(value!==""){

items.push(value);
input.value="";
renderList();

}

}

});

const form=document.querySelector("form");
const loading=document.getElementById("loadingScreen");

form.addEventListener("submit",function(){

hidden.value = items.join(", ");

loading.classList.add("show");

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>