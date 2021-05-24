<?php 

  function getPaymentID() {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/search?external_reference=jacksontavaresrod@hotmail.com&sort=date_created&criteria=desc');
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: Bearer APP_USR-334491433003961-030821-12d7475807d694b645722c1946d5ce5a-725736327'));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($c);
    $result = json_decode($result, true);
    curl_close($c);
    return $result['results'][0]['payment_method_id'];
  }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <script src="https://www.mercadopago.com/v2/security.js" view="back-url"></script>
  <title>Informações do pedido</title>
  <style>
    * {
      margin: 0;
    }

    #wrap-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin-top: 50px;
    }

    main {
      width: 100vw;
      height: 100vh;
    }

    .icon-wrap i{
      font-size: 5rem;
    }

  </style>
</head>
<body>
  <main>
    <div id="wrap-content">
    <?php if(isset($_GET['re'])) : 
            if($_GET['re'] == 'pending') :
            ?>
                <div class="icon-wrap"><i class="bi bi-exclamation-octagon-fill text-warning"></i></div>
                <h2>Pagamento pendente</h2>
            <?php elseif($_GET['re'] == 'success') :?>
              <div class="icon-wrap"><i class="bi bi-bag-check-fill text-success"></i></div>
              <h2>Pagamento Aprovado com sucesso!</h2>
              <div class="container mt-3 d-flex jutify-content-center">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">
                        payment_method_id
                      </th>
                      <th scope="col">
                        external_reference
                      </th>
                      <th scope="col">
                        payment_id
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo getPaymentID();?></td>
                      <td><?php echo $_GET['external_reference']; ?></td>
                      <td><?php echo $_GET['payment_id']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <?php elseif($_GET['re'] == 'failure'):?>
              <div class="icon-wrap"><i class="bi bi-cart-x-fill text-danger"></i></div>
              <h2>Pagamento rejeitado</h2>
            <?php endif; ?>
    <?php endif; ?>
    <a href="/mp-ecommerce-php/" class="btn btn-primary mt-5">Voltar para o site</a>
    </div>
  </main>
</body>
</html>