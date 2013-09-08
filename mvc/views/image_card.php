<?	require_once 'header.php';
	global $template;
	$helper = $template->get ('image');?>
	<div id="content">
		<hr><h2>Редактирование изображения</h2><hr><br>
		<table class="table_cart">
			<tr>
				<th>Изображение</th>
				<td>
					<a href="<?=$helper['image']['normal']?>">
						<image src="<?=$helper['image']['thumb']?>" />
					</a>
					<form enctype="multipart/form-data" method="POST" action="/admin/loadImage/<?=$helper['id']?>">
						<input type="file" name="userfile" />
						<input type="submit" value="Загрузить" />
					</form>					
				</td>	
				<td>
					<image src="<?=$helper['image']['normal']?>" />
				</td>
			</tr>
			<tr>
				<form action="/admin/editTable/products" method="POST">
					<td><input type="submit" value="Сохранить"></td>  
					<td colspan="2"><button type="button" onClick="history.back();">Назад</button></td> 
				</form>	
			</tr>
		</table>		
	</div>	
<?	require_once 'footer.php';?>