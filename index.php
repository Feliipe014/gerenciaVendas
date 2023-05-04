<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Registro de Vendas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <h1>Registro de Vendas</h1>
    <form method="post">
      <label for="nome-produto">Nome do Produto</label>
      <input type="text" id="nome-produto" name="nome-produto">
      
      <label for="quantidade">Quantidade</label>
      <input type="number" id="quantidade" name="quantidade" min="1">
      
      <label for="preco-unitario">Preço Unitário</label>
      <input type="number" id="preco-unitario" name="preco-unitario" step="0.01">
      
      <label for="data-venda">Data da Venda</label>
      <input type="date" id="data-venda" name="data-venda">
      
      <input type="submit" class="centralizado" name="acao" value="Registrar Venda">
    </form>

    

    <?php include('code.php'); ?>

  </body>
  </html>
  