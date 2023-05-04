<?php

    //Requisição do BD para mostrar estoque
    $pdo = new PDO('mysql:host=localhost;dbname=gerenciador_vendas','root');
    
    $sql = $pdo->prepare("SELECT * FROM `estoque`");
    $sql->execute();
    $estoque = $sql->fetchAll();

    echo '<br><hr><center>ESTOQUE <br></center>';
    foreach ($estoque as $key => $value) {
        echo $value['nome'].'<br>';
    }


    echo '<hr>';

    echo '<center>VENDAS <br></center>';

    $sql2 = $pdo->prepare("SELECT * FROM `vendas`");
    $sql2->execute();
    $vendas = $sql2->fetchAll();

    foreach ($vendas as $key => $value) {
        echo $value['nome'].'<br>';
    }
    

    if(isset($_POST['acao']) && $_POST['acao'] == 'Registrar Venda') {
        
        $nome = strip_tags($_POST['nome-produto']);
        $quantidade = strip_tags($_POST['quantidade']);
        $preco = strip_tags($_POST['preco-unitario']);
        $data = strip_tags($_POST['data-venda']);

        $sql = $pdo->prepare("INSERT INTO `vendas` VALUES (null,?,?,?,?)");

        if($sql->execute(array($nome,$quantidade,$preco,$data))){
            echo '<script>alert("INSERIDO COM SUCESSO")</script>';
        }else{
            die("Falhou");
        }

    }

    

?>