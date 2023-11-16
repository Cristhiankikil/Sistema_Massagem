<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Clientes</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    $username = "root";
    $password = "";
    
    try {
        $conn = new PDO('mysql:host=localhost;dbname=massagem', $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $data = $conn->query('SELECT * FROM cadastro');
        echo '<div class="container">';
        echo '<table id="tabela01" class="table table-striped table-bordered">';
        echo ' <thead>';
        echo '<tr><th>Id</th><th>Nome</th><th>CPF</th><th>RG</th><th>Data de Nascimento</th><th>Telefone</th><th>Email</th><th>Cep</th><th>Localidade</th><th>Uf</th><th>Ações</th></tr>';
        echo ' </thead>';
    
        foreach($data as $row) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["nome"] . '</td>';
            echo '<td>' . $row["cpf"] . '</td>';
            echo '<td>' . $row["rg"] . '</td>';
            echo '<td>' . $row["data_nasc"] . '</td>';
            echo '<td>' . $row["telefone"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["cep"] . '</td>';
            echo '<td>' . $row["localidade"] . '</td>';
            echo '<td>' . $row["uf"] . '</td>';
            echo '<td>
                    <a href="#"><img onclick="excluir('.$row["id"].')" style="width:30px; height:30px;" src="https://cdn-icons-png.flaticon.com/128/2602/2602735.png"></a>
                    <a href="#" onclick="abrirDivFlutuante(' . $row["id"] . ', \'' . $row["nome"] . '\', \'' . $row["cpf"] . '\', \'' . $row["rg"] . '\', \'' . $row["data_nasc"] . '\', \'' . $row["telefone"] . '\'
                    , \'' . $row["telefone"] . '\', \'' . $row["cep"] . '\')">
                        <img style="width:30px; height:30px;" src="https://cdn-icons-png.flaticon.com/128/9268/9268098.png">
                    </a>
                    
                </td>';
            echo '</tr>';
        }
    
        echo '</table>';
        echo '</div>';
    
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    ?>
</div>

</div>