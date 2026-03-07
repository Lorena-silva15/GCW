<?php

require 'conexao.php';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

$nome = $_POST['nome'] ?? '';
$ingredientes = $_POST['ingredientes'] ?? '';
$modPrep = $_POST['modPrep'] ?? '';
$imagem = null;


if (!empty($_FILES['img']['name'])) {

    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

    $permitidas = ['jpg','jpeg','png','webp'];

    if (in_array($ext,$permitidas)) {

        $nomeImagem = uniqid('img_').".".$ext;

        $caminhoDestino = "uploads/".$nomeImagem;

        if (!is_dir('uploads')) {
            mkdir('uploads',0777,true);
        }

        move_uploaded_file($_FILES['img']['tmp_name'],$caminhoDestino);

        $imagem = $caminhoDestino;
    }
}

$sql = "INSERT INTO receitas (nome, ingredientes, modPrep, imagem)
        VALUES (:nome, :ingredientes, :modPrep, :imagem)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':nome',$nome);
$stmt->bindParam(':ingredientes',$ingredientes);
$stmt->bindParam(':modPrep',$modPrep);
$stmt->bindParam(':imagem',$imagem);

if($stmt->execute()){

    header("Location: index.php");
    exit;

}else{

    echo "Erro ao adicionar receita";

}

?>