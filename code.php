<?php
    // Conexão com o banco de dados
    $conn = mysqli_connect("localhost", "root", "", "gerenciador_vendas");

    // Verificação de erro na conexão
    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    // Requisição do BD para mostrar estoque
    $sql = "SELECT * FROM `estoque`";
    $result_estoque = mysqli_query($conn, $sql);

    echo '<br><hr><center>ESTOQUE <br></center>';
    while ($row = mysqli_fetch_assoc($result_estoque)) {
        echo $row['nome'] . ' - ' . $row['quantidade'] . ' - R$' . $row['preco_uni'] . '<br>';
    }

    echo '<hr>';
    echo '<center>VENDAS <br></center>';

    $sql2 = "SELECT * FROM `vendas`";
    $result_vendas = mysqli_query($conn, $sql2);

    foreach ($result_vendas as $key => $value) {
            // Calcula o valor total da venda antes do desconto
            $total_venda = $value['quantidade'] * $value['preco_uni'];

            //Aplicando o desconto
            if($value['quantidade'] <= 5) {
                // sem desconto
            }
            //desconto de 5%
            elseif($value['quantidade'] <= 10){
                $desconto = $total_venda * 0.05;
                $total_venda -= $desconto;
            }
            //desconto de 10%
            else{
                $desconto = $total_venda * 0.1;
                $total_venda -= $desconto;

            }

            echo 'Produto: '.$value['nome'].'<br>'.'Quantidade: '.$value['quantidade'].'<br>'
            .'Preço:'.$value['preco_uni'].'<br>'.
            'Valor Total: '.$total_venda.'<hr>';

        }

    // Verificação da submissão do formulário de venda
    if (isset($_POST['acao']) && $_POST['acao'] == 'Registrar Venda') {
        $nome = strip_tags($_POST['nome-produto']);
        $quantidade = strip_tags($_POST['quantidade']);
        $preco = strip_tags($_POST['preco-unitario']);
        $data = strip_tags($_POST['data-venda']);

        // Inserção de nova venda no BD
        $sql = "INSERT INTO vendas (nome, quantidade, preco_uni, data_venda) VALUES ('$nome', '$quantidade', '$preco', '$data')";
        if (mysqli_query($conn, $sql)) {

            // Atualização da tabela estoque
            $sql = "UPDATE estoque SET quantidade = quantidade - '$quantidade' WHERE nome = '$nome'";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("VENDA REALIZADA COM SUCESSO")</script>';
                echo '<script>alert("ESTOQUE INSERIDO COM SUCESSO")</script>';
                header('Refresh:0');
            } else {
                die("Falhou");
            }
            
        } else {
            die("Falhou");
        }
    }  
 ?>