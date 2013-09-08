<?	require_once 'header.php';?>
	<div id="content">
		<?if (!$smal_cart['empty']):?>	
			<hr><h2>Корзина</h2><hr><br>
			<table class="table_cart">
				<form action="/cart/refresh" method="post">
					<tr>
						<th>№</th>
						<th>Артикул</th>
						<th>Наименование</th>
						<th>Стоимость</th>
						<th>Кол-во</th>
						<th>Сумма</th>
						<th><img src="/images/delete.png" /></th>
					</tr>
					<?	$i=1;
					foreach ($smal_cart['goods'] as $product_id => $product):?>
					<tr>
						<td><?=$i++?></td>
						<td><?=$product['label']?></td>
						<td><?=$product['name']?></td>
						<td><?=$product['price']?> $</td>
						<td><input size="4" type="text" name="edi_<?=$product_id?>" value="<?=$product['amount']?>" /></td>
						<td><?=$product['cost']?> $</td>
						<td><input type="checkbox" name="del_<?=$product_id?>" value="<?=$product_id?>" /></td>
					</tr>
					<?endforeach;?>
					<tr>
						<td colspan="5"><strong>К оплате: </strong></td>
						<td colspan="2">
						<strong><?=$smal_cart['cart_price']?> $</strong></td>
					</tr>					
					<tr><td colspan="7"><input type="submit" name="refresh" value="Пересчитать"  /></td></tr>
				</form>	
			</table>
			<a href="/order"><img src="/images/carts.png" /></a>
		<?else:?>
		<p class="border">Ваша корзина пуста!</p>
		<?endif;?>
	</div>
<?	require_once 'footer.php';?>