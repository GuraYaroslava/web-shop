<?	require_once 'header.php';
	require_once 'menu.php';
	global $template;
	$enter = $template->get ('check');
	$error = $template->get ('error');?>
	<div id="content">
		<?if ($enter):?>
			<table cellspacing="10"  align="center">
				<tr  align="center"> 
					<td class="title"  align="center">Личный кабинет <b><?=$_COOKIE['login'];?></b>.</td>
				</tr>
				<tr><td  align="center">Это секретный контент.</td></tr>
			<?if ($_COOKIE['login'] == 'admin'):?>
				<tr><td class="border_black"><a href="/admin/editTable/products">Редактирование товаров</a></td></tr>
				<tr><td class="border_black"><a href="/admin/editTable/categories">Редактирование категорий</a></td></tr>
				<tr><td class="border_black"><a href="/admin/editTable/product_category">Редактирование категорий товаров</a></td></tr>
				<tr><td  align="center"><a href="/admin/report">Отчет</a></td></tr>
				<br>
			<?endif;?>
				<tr><td  align="center"><a href="/enter/clearFace">Удалить аккаунт</a></td></tr>
				<tr><td  align="center"><a href="/enter/out">Выйти</a></td></tr>
			</table>
		<?else:?>
			<table align="center">
				<?if (!empty ($error))
					print '<tr><td style="color:#FF6666"><strong><i><ins>'.$error.'</ins></i></strong></td></tr>';?>
				<tr>
					<td style="vertical-align: top; padding: 0 100px 10px 100px;">
						<?require_once $_SERVER['DOCUMENT_ROOT'].'/mvc/views/reg_form.php';?>					
					</td>
					
					<td style="vertical-align: top; padding: 0 50px 10px 0;">
						<?require_once $_SERVER['DOCUMENT_ROOT'].'/mvc/views/auth_form.php';?>
					</td>
				</tr>
			</table>		
		<?endif;?>
	</div>
<?	require_once 'footer.php';?>