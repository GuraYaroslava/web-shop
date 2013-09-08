<script type="text/javascript" src="/js/jquery-1.10.2.js" ></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/js/jquery.treeview.js"></script>
<div id="menu">
	<div><p class="title">Меню</p></div>
	<form>
<?		require_once '/mvc/models/categories.php';
		global $template;		
		$c = new Categories;
		$tree = $c->getTree ();
		function build_tree ($cats, $parent_id)
		{
			if (is_array ($cats) && isset ($cats[$parent_id]))
			{
				$tree = '<ul>';
				foreach ($cats[$parent_id] as $cat)
				{
					$tree .= '<li><a href="/catalog/getCatalog/'.$cat['id'].'">'.$cat['name'].'</a>';
					$tree .= build_tree ($cats, $cat['id']);
					$tree .= '</li>';
				}
				$tree .= '</ul>';
			}
			else
				return null;
			return '<ul id="selector">'.$tree.'</ul>';
		}
		echo build_tree ($tree, 0);?>
	</form>		
</div>
<script type="text/javascript">
	$(document).ready(function(){
	  $("#selector").treeview({
	    persist: "location",
		collapsed: false,
		unique: true,
	  });
	});
</script>