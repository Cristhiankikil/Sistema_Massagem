<?php
$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$rg = $_POST["rg"];
$data_nasc = $_POST["data_nasc"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];
$cep = $_POST["cep"];

function get_endereco($cep){
    $cep = preg_replace("/[^0-9]/", "", $cep);
    $url = "http://viacep.com.br/ws/$cep/json/";
  
    $json = file_get_contents($url);
    $endereco = json_decode($json);

    return $endereco;
}

if (!empty($cep)) {
    $endereco = get_endereco($cep);
    $cep1 = $endereco->cep ?? '';
    $localidade = $endereco->localidade ?? '';
    $uf = $endereco->uf ?? '';
}

try {
    $host = "localhost";
    $database = "massagem";
    $username = "root";
    $password = "";

    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $conn = new PDO($dsn, $username, $password, $options);

    $sql = "INSERT INTO cadastro (nome, cpf, rg, data_nasc, telefone, email, cep , localidade, uf) VALUES (:nome, :cpf, :rg, :data_nasc, :telefone, :email, :cep, :localidade, :uf)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':data_nasc', $data_nasc);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cep', $cep1);
    $stmt->bindParam(':localidade', $localidade);
    $stmt->bindParam(':uf', $uf);

    if ($stmt->execute()) {
        error_log("Novo registro inserido.");
    } else {
        echo "Erro: " . $stmt->errorInfo()[2];
    }

    $conn = null;
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
