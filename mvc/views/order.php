<?	require_once 'header.php';
	global $template;
	$message = $template->get ('message');?>
	<div id="content">
		<?if (!empty ($message)):
			print ($message);?>
			<p>Содержание заказа:</p>
			<?$data = $template->get ('order_content');?>
			<table class="table_cart"> 
				<th>Артикул</th>
				<th>Наименование</th>
				<th>Стоимость ($)</th>
				<th>Кол-во (шт.)</th>
				<th>Сумма ($)</th>
				<?foreach ($data['goods'] as $key => $items):?>
					<tr>
					<?foreach ($items as $field => $value):?>
						<td><?=$value;?></td>
					<?endforeach;?>
					</tr>
				<?endforeach;?>
				<tr>
					<td colspan="4"><strong>Итог: </strong></td>
					<td colspan="2">
					<strong><?=$data['cart_price']?></strong></td>
				</tr>	
			</table>
			<a href="/"> Вернуться на главную страницу >>></a>
		<?else:?>
			<strong><i style="color:red">Напоминалка: Только зарегистрированный пользователь может сделать заказ.</i></strong>
			<hr><h2>Оформление заказа</h2><hr><br>
			<form action="/order/buy" method="post">
				<table class="table_cart"> 
					<tr>
						<th>Имя</th>
						<td><input size="25" type="text" name="name" value=""/></td>
					</tr>
					<tr>
						<th>E-mail<span style="color: red;">*</span></th>
						<td><input size="25" type="text" name="email" value=""/></td>
					</tr>
					<tr>
						<th>Телефон</th>
						<td><input size="25" type="text" name="phone" value=""/></td>
					</tr>
					<tr>
						<th>Адрес</th>	
						<td><textarea name="adres"></textarea></td>
					</tr>
				</table><br/>
					<input type="submit" name="to_order" value="Оформить заказ">
			</form>
		<?endif;?>
	</div>
<?	require_once 'footer.php';?>