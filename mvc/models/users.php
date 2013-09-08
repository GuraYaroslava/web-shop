<?	class Users extends Entity
	{
		public
			$fields  =
            [
				'id'  	 => ['name' => 'id',   	'type' => 'int', 	 'ref' => 0],
				'login'  => ['name' => 'login', 'type' => 'varchar', 'ref' => 0], 
				'time'   => ['name' => 'time',  'type' => 'int',   	 'ref' => 0],
				'hash'   => ['name' => 'hash',  'type' => 'varchar', 'ref' => 0],
            ];
			
		function __construct ()
		{
			$this->tableName = ['users', 'Пользователи'];
			parent::__construct ();
		}
	}
?>