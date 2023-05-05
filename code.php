<?php

    //Requisição do BD para mostrar estoque
    $pdo = new PDO('mysql:host=localhost;dbname=gerenciador_vendas','root');

    $sql = $pdo->prepare("SELECT * FROM estoque");
    $sql->execute();
    $estoque = $sql->fetchAll();

    echo '<br><hr><center>ESTOQUE <br></center>';
    foreach ($estoque as $key => $value) {
        echo $value['nome'].' - '.$value['quantidade'].' - R$'.$value['preco_uni'].'<br>';
    }


    echo '<hr>';

    echo '<center>VENDAS <br></center>';

    $sql2 = $pdo->prepare("SELECT * FROM vendas");
    $sql2->execute();
    $vendas = $sql2->fetchAll();

    foreach ($vendas as $key => $value) {
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

        echo 'Produto: '.$value['nome'].'<br>'.'Quantidade: '.$value['quantidade'].'<br>'.'Preço unitario: '.$value['preco_uni'].
        '<br>'.'Data da venda: '.$value['data_venda'].'<br>'.'Venda com desconto: '.$total_venda.'<br>'.'------------------------------------------------------------------<br>';
    }




    if(isset($_POST['acao']) && $_POST['acao'] == 'Registrar Venda') {

        $nome = strip_tags($_POST['nome-produto']);
        $quantidade = strip_tags($_POST['quantidade']);
        $preco = strip_tags($_POST['preco-unitario']);
        $data = strip_tags($_POST['data-venda']);

        $sql = $pdo->prepare("INSERT INTO vendas VALUES (null,?,?,?,?)");

        if($sql->execute(array($nome,$quantidade,$preco,$data))){
            echo '<script>alert("INSERIDO COM SUCESSO")</script>';
            header('Refresh:0');
        }else{
            die("Falhou");
        }


        // Atualizar tabela estoque
        $sql_estoque = $pdo->prepare("SELECT * FROM `estoque` WHERE `nome` = ?");
        $sql_estoque->execute(array($nome));
    
        if($sql_estoque->rowCount() > 0) { // Produto já existe na tabela estoque
            $row = $sql_estoque->fetch();
            $quantidade_disponivel = $row['quantidade'];
            $quantidade_disponivel -= $quantidade;
    
            $sql_update = $pdo->prepare("UPDATE `estoque` SET `quantidade` = ? WHERE `nome` = ?");
            $sql_update->execute(array($quantidade_disponivel, $nome));
    
            echo '<script>alert("ESTOQUE ATUALIZADO COM SUCESSO")</script>';
    
        } else { // Produto não existe na tabela estoque
            $quantidade_disponivel = -$quantidade;
    
            $sql_insert = $pdo->prepare("INSERT INTO `estoque` VALUES (null, ?, ?)");
            $sql_insert->execute(array($nome, $quantidade_disponivel));
    
            echo '<script>alert("ESTOQUE INSERIDO COM SUCESSO")</script>';
        }

    }

    
 ?>