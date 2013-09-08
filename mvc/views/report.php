<?	require_once 'header.php';?>
	<script>
		$(function()
		{
		   var seachContainer = new Seacher (document.getElementById('seachContainer'));
		});

		function Seacher (targetelement)
		{	
			this.tableSelect;
			this.fieldSelect;
			this.conditionSelect;
			this.tables = new Array ('products', 'categories', 'cart', 'orders', 'users');
			this.fields;
			this.conditions = new Array ('>', '>=', '<', '<=', '=', 'содержит');
			this.createSeachContainer ();
			this.table;
			this.container = $(targetelement); 
			this.container.append (this.table);
		}
					
		Seacher.prototype.createSeachContainer = function ()
		{
			this.table = $('<table></table>')/*.addClass('calendar')*/;//Создали таблицу и дабивили CSS-класс 'calendar' (см. Epoch.css) 
			var tr = $('<tr></tr>'), td = $('<td></td>');
			var tbody = $('<table></table>').append(tr.append(td.append(this.createMainHeading ()))); 	
			$(this.table).append (tbody);//tbody потомок таблицы calendar
		};
					
		Seacher.prototype.createMainHeading = function ()
		{	
			var container = $('<div></div>')/*.addClass('mainheading')*/;//Создали таблицу и дабивили CSS-класс 'mainheading' (см. Epoch.css)	
			this.tableSelect = document.createElement('select');
			
			for (i = 0; i < 5; i++)
			{	
				opt = $('<option></option>').attr('value', i).text(this.tables[i]);
				$(this.tableSelect).append(opt);//Теперь оpt потомок monthSelect
			}
			
			//this.fieldSelect.owner = this.conditionSelect.owner = value.owner = this;//Ссылка на объект - Seacher
			this.tableSelect.owner = this;//Ссылка на объект - Seacher
			
			this.tableSelect.onchange = function()
			{	
				//if (this.owner.tableSelect.value == 'products') alert ('products');
				this.owner.displayTable = this.owner.tableSelect.value;
			};
			
			this.fieldSelect = document.createElement('select'), this.conditionSelect = document.createElement('select');	
			var valueInput = document.createElement('input'), opt, i;
			
			//this.fields = <?=$fields?>;
			/*for (i = 0; i < 5; i++)
			{	
				opt = $('<option></option>').attr('value', i).text(this.fields[i]);
				$(this.fieldSelect).append(opt);//Теперь оpt потомок monthSelect
			}*/
			$(container).append(this.tableSelect);//К container	добавили monthDn, потом this.monthSelect, затем this.yearSelect и, наконец, monthUp
			return container;
		};
	</script>
	<div id="content">
		<div id="seachContainer"></div>		
	</div>
<?	require_once 'footer.php';?>