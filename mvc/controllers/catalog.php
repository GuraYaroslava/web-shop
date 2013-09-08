<?  class Controller_Catalog
	{
		function getCatalog ()
		{
			global $template;	
			$poducts = new Products;
			$category_id = $_POST['args'][0];
			$template->set ('catalog', $poducts->getCatalog ($category_id));
			$template->show ('catalog');
		}	
	}
?>
