<!DOCTYPE html>
<html>

<head>
    <title>Encomenda Fechada</title>
</head>

<body>
    <p>Encomenda Numero {{ $order->id }} -> encontra se Fechada</p>
    <p>Agradecemos a sua compra </p>
    <p><a href="{{ route('minhasencomendas.show.pdf', $order) }}">clique aqui para opter o recibo</a></p>
</body>

</html>
