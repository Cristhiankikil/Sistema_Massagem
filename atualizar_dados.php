<?php

$host = "localhost";
$database = "massagem";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_POST['id'];
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $rg = $_POST["rg"];
    $data_nasc = $_POST["data_nasc"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $cep = $_POST["cep"];
   
    $sql = "UPDATE cadastro SET nome = :nome, cpf = :cpf, rg = :rg, data_nasc = :data_nasc, telefone = :telefone, email = :email, cep = :cep, localidade = :localidade, uf = :uf WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':data_nasc', $data_nasc);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cep', $cep1);
    $stmt->bindParam(':localidade', $localidade);
    $stmt->bindParam(':uf', $uf);


    // Aqui, você precisa verificar se o CEP não está vazio antes de realizar a consulta
    if (!empty($cep)) {
        $endereco = get_endereco($cep);
        $cep1 = $endereco->cep;
        $localidade = $endereco->localidade;
        $uf = $endereco->uf;
        $stmt->bindParam(':cep', $cep1);
        $stmt->bindParam(':localidade', $localidade);
        $stmt->bindParam(':uf', $uf);
    } else {
        $stmt->bindParam(':cep', null, PDO::PARAM_NULL);
        $stmt->bindParam(':localidade', null, PDO::PARAM_NULL);
        $stmt->bindParam(':uf', null, PDO::PARAM_NULL);
    }

    if ($stmt->execute()) {
        // Se a atualização for bem-sucedida, envie uma resposta de sucesso
        echo 'success';
    } else {
        // Se ocorrer um erro na atualização, envie uma resposta de erro
        echo 'error';
    }
} catch (PDOException $e) {
    // Em caso de erro na conexão com o banco de dados
    echo 'error';
}

function get_endereco($cep) {
    $cep = preg_replace("/[^0-9]/", "", $cep);
    $url = "http://viacep.com.br/ws/$cep/xml/";
    $xml = simplexml_load_file($url);
    return $xml;
}
?>