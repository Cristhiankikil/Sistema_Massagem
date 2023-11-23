<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <a href="#" onclick="abrirDivFlutuante(' . $row["id"] . ', \'' . $row["nome"] . '\', \'' . $row["cpf"] . '\', \'' . $row["rg"] . '\', \'' . $row["data_nasc"] . '\', \'' . $row["telefone"] . '\', \'' . $row["email"] . '\', \'' . $row["cep"] . '\')">
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

    <div class="modal-container" id="divFlutuante">
        <div class="modal-content">
            <form id="editarForm">
                <input type="hidden" id="editUserId" name="editUserId">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                </div>
                <div class="form-group">
                    <label for="rg">RG:</label>
                    <input type="text" class="form-control" id="rg" name="rg">
                </div>
                <div class="form-group">
                    <label for="data_nasc">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="data_nasc" name="data_nasc">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" class="form-control" id="telefone" name="telefone">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="cep">Cep:</label>
                    <input type="text" class="form-control" id="cep" name="cep">
                </div>
                <button type="button" onclick="salvarEdicao()">Salvar</button>
                <button type="button" onclick="fecharDivFlutuante()">Fechar</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function abrirDivFlutuante(id, nome, cpf, rg, data_nasc, telefone, email, cep) {
            $('#editUserId').val(id);
            $('#nome').val(nome);
            $('#cpf').val(cpf);
            $('#rg').val(rg);
            $('#data_nasc').val(data_nasc);
            $('#telefone').val(telefone);
            $('#email').val(email);
            $('#cep').val(cep);
            $('#divFlutuante').show();
        }

        function fecharDivFlutuante() {
            $('#divFlutuante').hide();
        }

        function salvarEdicao() {
            var nome = $("#nome").val();
            var cpf = $("#cpf").val();
            var rg = $("#rg").val();
            var data_nasc = $("#data_nasc").val();
            var telefone = $("#telefone").val();
            var email = $("#email").val();
            var cep = $("#cep").val();

            var dados = {
                nome: nome,
                cpf: cpf,
                rg: rg,
                data_nasc: data_nasc,
                telefone: telefone,
                email: email,
                cep: cep
            };

            $.ajax({
                type: 'POST',
                url: 'atualizar_dados.php', 
                data: dados,
                success: function(response) {
                    if (response === 'success') {
                        alert('Edição salva com sucesso!');
                        fecharDivFlutuante();
                    } else {
                        alert('Erro ao salvar a edição. Tente novamente.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Erro na solicitação AJAX: ' + error);
                }
            });
        }
    </script>
    <script>
    function excluir(userId) {
        const data = {
            'id': userId
        };

        $.ajax({
            url: 'excluir.php', 
            type: 'POST',
            data: data,
            success: function(result) {
                
                alert("Excluído com sucesso");
               
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                
                alert("Erro ao excluir");
            }
        });
    }
</script>
</body>
</html>
