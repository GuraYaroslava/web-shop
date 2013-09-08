<?	require_once 'header.php';?>
	<div id="content">
		<table id="table"></table>
		<div id="pager" style="text-align:center;"></div><br><br>
		<script type="text/javascript">
			jQuery (document).ready (function ()
			{
			<?	global $template;
				$objName	= $_POST['args'][0];	
				$obj 		= new $objName ();
				$caption 	= $obj->tableName[1];?>
				var lastSel = -1;
				var grid 	= jQuery ('#table');				
				grid.jqGrid
				({
					data: 			<?=$template->get ('data');?>,
					datatype: 		'local',
					mtype: 			'POST',
					treeGrid:		false,	
					colNames:		<?=$template->get ('colNames')?>,
					colModel: 		<?=$template->get ('colModel')?>,
					pager: 			$('#pager'),
					width: 			980,
					height: 		'100%',
					rowNum: 		10,		
					rownumbers: 	true,
					rownumWidth:	20,
					caption: 		'<?=$caption?>',
					sortname: 		'id',
					sortorder: 		'asc',
					hoverrows: 		true, 	
					multiselect:	true,	
					ondblClickRow: 	function (id) 
									{
										if (id && id != lastSel) 
										{
											grid.restoreRow (lastSel); 	
											grid.editRow (id, true); 	
											lastSel = id; 				
										}
									},
					editurl: 		'/admin/edit/<?=$objName?>',
					
				});
					
				grid.navGrid
				(
					'#pager', 
					{ 
						edit:  	true, 	edittext: 	'Редактировать', 
						add:  	true, 	addtext: 	'Создать', 
						del: 	true, 	deltext: 	'Удалить', 
						view: 	false,
						search: false
					}, 
					{ //edit
						viewPagerButtons:	false, 	
						closeAfterEdit: 	true, 	
					},
					{ //add
						reloadAfterSubmit: 	false,
						viewPagerButtons:	false, 
						clearAfterAdd: 		true, 	
						closeAfterAdd: 		true, 	
						addedrow: 			'last',
						afterSubmit:		function( response, postdata)
											{							
												window.location.reload ();	
												return [true, '', response.responseText];
											},						
					},
					{ //del
						closeAfterAdd: 		true,	
						viewPagerButtons: 	false, 	
					}
				);			
				jQuery ('#pager').css ('height', 30); 
				grid.jqGrid
				(
					'filterToolbar', 
					{
						stringResult: 	true, 
						searchOnEnter: 	false, 
						defaultSearch: 	'cn'	
					}
				);
			});
		</script>		
		<?if ($objName == 'categories'):?>
			<table id="tableRoot"></table>
			<script type="text/javascript">
				var tableRoot 	= jQuery ('#tableRoot');	
				<?$selectData 	= json_encode ($obj->fields['parent_id']['refData']);?>
				var currRoot 	= <?=$obj->getRoot ();?>;
				tableRoot.jqGrid
				({
					data: 			[{Root: currRoot}],
					datatype: 		'local',
					mtype: 			'POST',
					treeGrid:		false,	
					colNames:		['Корень'],
					colModel: 		[
										{
											name: 			'Root', 
											editable: 		true, 
											formatter: 		'select', 
											sortable: 		false,
											edittype: 		'select', 
											editoptions: 	{value: <?=$selectData?>}
										}
									],
					height: 		'100%',
					ondblClickRow: 	function (id) 
									{
										tableRoot.editRow (id, true); 	
									},
					editurl: 		'/admin/edit/<?=$objName?>/changeRoot',
				});
			</script>			
		<?endif;?>
	</div>
<?	require_once 'footer.php';?>