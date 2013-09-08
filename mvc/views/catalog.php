<?  require_once 'header.php';
	require_once 'menu.php';
	global $template;
	$helper = $template->get('catalog');
	if (empty ($helper)) 
	{
		require_once 'footer.php';
		return 0;
	}
	$idx = 0;
	$column = 0;
	$count = count ($helper['tableTitles']);?>
	<div id="content" style="margin-left: 200px;">
		<?if (!empty($helper['tableRows'])):?>
			<table>
				<?foreach ($helper['tableRows'] as $k => $items):?>
					<?if ($column++ == 0):?>
						<tr>
					<?endif;?>
						<td >							
							<div class="product">
								<table>
									<tr>	
										<td>
											<table>
												<tr>
													<td rowspan="<?=$count+1;?>">
														<a href="<?=$helper['image'][$items['id']]['normal']?>"><img src="<?=$helper['image'][$items['id']]['thumb']?>" alt="" style="float:right"/><a/>
													</td>
												</tr>	
												<?$id = array_shift ($items);?>
												<?foreach ($items as $key => $item):?>	
													<tr>
														<td class="border"><i><?=$helper['tableTitles'][$idx++];?>:</i></td>
														<td class="border"><b><?=$item?></b></td>	
													</tr>	
												<?endforeach; $idx = 0;?>													
											</table>
										</td>																		
										<td rowspan="2" style="vertical-align: bottom;">
											<div class="product_buy"><a href="/cart/add/<?=$id;?>"><img src="/images/basket.png"/></a></div>
										</td>
									</tr>
								</table>	
							</div>						
						</td>
						<?if ($column == 2):
							$column = 0;?>
							</tr>
						<?endif;?>	
						
				<?endforeach;?>
			</table>
		<?else:?>
			<h4>Эта котегория товаров пока пустует :(</h4>
		<?endif;?>		
	</div>
<?	require_once 'footer.php';?>