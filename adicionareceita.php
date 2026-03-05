<?php
// 1. Conexão com o banco
$host = "localhost";       // servidor
$db = "seu_banco";         // nome do banco
$user = "seu_usuario";     // usuário
$pass = "sua_senha";       // senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// 2. Recebendo dados do formulário
$nome = $_POST['nome'] ?? '';
$ingredientes = $_POST['ingredientes'] ?? '';
$modoprep = $_POST['modoprep'] ?? '';
$imagem = null;

// 3. Tratando upload da imagem (opcional)
if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $nomeImagem = uniqid('img_') . "." . $ext;
    $caminhoDestino = "uploads/" . $nomeImagem;

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    move_uploaded_file($_FILES['img']['tmp_name'], $caminhoDestino);
    $imagem = $caminhoDestino;
}

// 4. Inserção segura no banco usando prepared statement
$sql = "INSERT INTO receitas (nome, imagem, ingredientes, modoprep) VALUES (:nome, :imagem, :ingredientes, :modoprep)";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':imagem', $imagem);
$stmt->bindParam(':ingredientes', $ingredientes);
$stmt->bindParam(':modoprep', $modoprep);

if ($stmt->execute()) {
    echo "Receita adicionada com sucesso!";
    // opcional: redirecionar
    // header("Location: sucesso.php");
} else {
    echo "Erro ao adicionar receita!";
}
?>