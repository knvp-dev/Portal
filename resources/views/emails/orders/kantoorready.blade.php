<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
</head>
<body>

	<style>
		body{
			font-size:14px;
			font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
		}
		.container{
			margin:0 auto;
			width:600px;
		}

		img{
			width:600px;
		}

		.red{
			color:#FF3860;
			font-weight: bold;
		}
	</style>

	<div class="container">
		<img src="{{ asset('images/mails/header.png') }}" alt="header"><br><br>
		Beste collega's van Konvert {{ $order->user->name }}, <br><br>
		Uw bestelling voor kantoormateriaal met nummer {{ $order->id }} staat klaar voor verzending. <br><br>
		
		@if(!$order->complete)
		<br><br>
			<span class="red">Let op! De inhoud van deze levering wijkt af, er zijn producten niet leverbaar.</span>
		@endif
	
		<br><br>
		Voor meer informatie over deze bestelling, <a href="http://portal.dev/kantoormateriaal/detail/{{$order->id}}">klik hier</a>.
		<br><br>
		<hr>
		<br><br>
		Chèr Collègues de Konvert {{ $order->user->name }}, <br><br>
		Votre commande de fournitures de bureau avec numéro de commande {{ $order->id }} est prête à être livrée.<br><br>

		@if(!$order->complete)
		<br><br>
			<span class="red">Attention ! le contenu de cette commande est différente, certains produits ne sont pas disponibles ou livrables.</span>
		@endif
		<br><br>
		Pour plus d’informations, <a href="http://portal.dev/kantoormateriaal/detail/{{$order->id}}">cliquez ici</a>.
		<br><br>
		<img src="{{ asset('images/mails/footer.png') }}" alt="footer">
	</div>
	
</body>
</html>