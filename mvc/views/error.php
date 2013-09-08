<?	require_once 'header.php';
	global $template;
	$errors = $template->get ('errors');?>
	<div id="content">
		<hr><h2>Ошибка</h2><hr><br>
		<form action="" name="error" method="POST">
			<table class="table_cart">
				 <!--<tr><td><img src="/images/op.jpg" /></td></tr>-->
				<?foreach ($errors as $key => $msg):?>
					<tr><td><?=$msg;?></td></tr>	
				<?endforeach;?>
				<tr>	
					<td><button type="button" onClick="history.back();">Назад</button></td>  
				</tr>
			</table>
			<img src="/images/op.jpg" />
		</form>
	</div>
<?	require_once 'footer.php';?>