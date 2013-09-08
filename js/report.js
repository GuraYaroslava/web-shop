$(function()
{
   var seachContainer = new Seacher (document.getElementById('seachContainer'));
});

function Seacher (targetelement)
{	
	this.fieldSelect;
	this.conditionSelect;
	this.fields = new Array ('', 'имя заказщика', 'e-mail', 'телефон', 'адрес', 'номер клиента');
	this.createSeachContainer ();
	this.table;
	this.container = $(targetelement); 
	this.container.append (this.table);
}
			
Seacher.prototype.createSeachContainer = function ()
{
	this.table = $('<table></table>')/*.addClass('calendar')*/;//Создали таблицу и дабивили CSS-класс 'calendar' (см. Epoch.css) 
	var tr = $('<tr></tr>'), td = $('<td></td>');//Создали строку и ячейку
	var tbody = $('<table></table>').append(tr.append(td.append(this.createMainHeading ())));//Создали таблицу и сделали ее предком строки, которая является предком ячейки. Ячейка предок div, который возвращает ф-я this.createMainHeading() 	
	//tbody.append(tr.append(td.append(this.createDayHeading())));//К  tbody добавили еще одну строку, которая является предком ячейки. Ячейка содердит таблицу, которую возвращает ф-я this.createDayHeading()
	//tr = $('<tr></tr>'), td = $('<td></td>');//Создали строку и ячейку
	//this.calCellContainer = td;//Зпомнили, что calCellContainer - это ячейка, содержащая календарные дни 
	//tbody.append(tr.append(td.append(this.createCalCells())));//К  tbody добавили еще одну строку, которая является предком ячейки. Ячейка содердит таблицу, которую возвращает ф-я this.createCalCells()
	//tr = $('<tr></tr>'), td = $('<td></td>');//Создали строку и ячейку
	//tbody.append(tr.append(td.append(this.createFooter())));//К  tbody добавили еще одну строку, которая является предком ячейки. Ячейка содердит div, который возвращает ф-я this.createFooter()
	$(this.table).append (tbody);//tbody потомок таблицы calendar
};
			
Seacher.prototype.createMainHeading = function ()
{	
	var container = $('<div></div>')/*.addClass('mainheading')*/;//Создали таблицу и дабивили CSS-класс 'mainheading' (см. Epoch.css)	
	this.fieldSelect = document.createElement('select'), this.conditionSelect = document.createElement('select');	
	var fieldSelect = document.createElement('select'), conditionSelect = document.createElement('select');	
	var value = document.createElement('input'), opt, i;
	for (i = 0; i < 6; i++)
	{	
		opt = $('<option></option>').attr('value', i).text(this.fields[i]);
		$(this.fieldSelect).append(opt);//Теперь оpt потомок monthSelect
	}
	opt = $('<option></option>').attr('value', i).text('');//Установили значение атрибута value и новое текстовое содержимое для opt
	$(this.conditionSelect).append(opt);
	opt = $('<option></option>').attr('value', i).text('содержит');//Установили значение атрибута value и новое текстовое содержимое для opt
	$(this.conditionSelect).append(opt);
	opt = $('<option></option>').attr('value', i).text('равно');//Установили значение атрибута value и новое текстовое содержимое для opt
	$(this.conditionSelect).append(opt);//Теперь Opt потомок yearSelect			
	this.fieldSelect.owner = this.conditionSelect.owner = value.owner = this;//Ссылка на объект - Epoch
	this.fieldSelect.onchange = function()//При изменении месяца в комбобоксе месяцев
	{	
		//this.owner.displayField = this.owner.fieldSelect.value;//Меняем значение displayMonth на значение, выбранное пользователем в комбобоксе месяцев
		//this.owner.reFresh();//Вызываем у обекта Epoch функцию reFresh()
	};
	this.conditionSelect.onchange = function()//При изменении месяца в комбобоксе годов
	{	
		//this.owner.displayCondition = this.owner.conditionSelect.value;//Меняем значение displayYear на значение, выбранное пользователем в комбобоксе годов 
		//this.owner.reFresh();//Вызываем у обекта Epoch функцию reFresh()
	};
	$(container).append(this.fieldSelect).append(this.conditionSelect).append(value);//К container	добавили monthDn, потом this.monthSelect, затем this.yearSelect и, наконец, monthUp
	alert ('Caption!');
	return container;//Функция createMainHeading() возвращает div
};