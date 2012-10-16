<?
#ä
class BaseQuery {

	protected $criterias = array();
	protected $tablename;
	protected $modelname; // name of manager class => example: "PartnerManager"
	protected $table_alias;
	protected $joins = array();
	protected $order;
	protected $groupby;
	protected $offset;
	protected $limit = 30; // default

	public function setLimit($limit){
		$this->limit = $limit;
	}

	public function setOffset($offset){
		$this->offset = $offset;
	}

	public function setTablename($string){
		$string = strtolower($string);
		$this->table_alias = substr( md5($string), 0, 12);
		$this->tablename = $string;
	}

	public function add($column, $operator = null, $expected_value = null) {
		if(!$column instanceof Criteria)
			$myCriteria = new Criteria($operator, $column, $expected_value);
		else
			$myCriteria = $column;
		$myCriteria->setType(Criteria::LOGICAL_AND);
		$this->criterias[] = $myCriteria;
	}

	public function addOr($column, $operator = null, $expected_value = null) {
		if(! $column instanceof Criteria )
			$myCriteria = new Criteria($operator, $column, $expected_value);
		else
			$myCriteria = $column;
		$myCriteria->setType(Criteria::LOGICAL_OR);
		$this->criterias[] = $myCriteria;
	}

	/*
	public function addXOr($column, $operator = null, $expected_value = null) {
		if(! $column instanceof Criteria )
			$myCriteria = new Criteria($operator, $column, $expected_value);
		else
			$myCriteria = $column;
		$myCriteria->setType(Criteria::LOGICAL_XOR);
		$this->criterias[] = $myCriteria;
	}*/

	public function addJoin(BaseQuery $myJoinQuery, $condition){
		$myJoinQuery->jointype = $condition;
		$this->joins[$myJoinQuery->tablename] = $myJoinQuery;
	}

	public function AddOrder($column, $sorttype = Criteria::DESC){
		$this->order[] = $column.' '.$sorttype;
	}

	public function AddGroupBy($column){
		$this->groupby[] = $column;
	}

	public function build() {
		$models = array();
		$models["main"] = $this->modelname;
		$models["joins"] = array();
		$params = array();

		// spalten von hauptklasse holen
		$select_rows = '';
		Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC($this->modelname));
		$cols = call_user_func(array($this->modelname.'DAO','getColumns'));
		if( is_array($cols) AND !empty($cols) )
			$select_rows = implode(', ', $cols);

		// JOINS
		$joinsql = '';
		foreach ( $this->joins as $jointable ){
			$jointable instanceof QueryBase;
			$models["joins"][] = $jointable->modelname;

			// spalten zum select hinzufügen
			Library::requireLibrary(LibraryKeys::ABSTRACTION_DAO_GENERIC($jointable->modelname));
			$cols = call_user_func(array($jointable->modelname.'DAO','getColumns'));
			if( is_array($cols) AND !empty($cols) )
				$select_rows .= ", \n".implode(', ',$cols);

			// join typ
			$joinsql .= "\n".' '. $jointable->jointype. ' ' . $jointable->tablename .' ON 1 = 1';

			// bedingungen
			foreach ($jointable->criterias as $key => $criteria){
				$criteria instanceof Criteria;

				$last = (isset($jointable->criterias[$key-1]) ? $jointable->criterias[$key-1] : null );
				$next = (isset($jointable->criterias[$key+1]) ? $jointable->criterias[$key+1] : null );

				switch ($criteria->getType()){
					case Criteria::LOGICAL_AND:
					case Criteria::LOGICAL_OR:
						$joinsql .= ' '.$criteria->getType().' ';
						break;
				}

				if( $next AND $criteria->getType() == Criteria::LOGICAL_AND AND $next->getType() == Criteria::LOGICAL_OR )
					$joinsql .= ' ( ';

					$joinsql .= $criteria->getWhereClause() ;

				if( $criteria->getType() == Criteria::LOGICAL_OR AND $last->getType() == Criteria::LOGICAL_AND )
					$joinsql .= ' ) ';

				//$joinsql .= ' '.$criteria->getType().' ';
				//$joinsql .= $criteria->getWhereClause();
			}
		}

		// wenn groupby benutzt wird dürfen nur diese spalten benutzt werden
		if( !empty($this->groupby) )
			$select_rows = implode(',', $this->groupby);

		$sql = 'SELECT '.$select_rows."\n FROM ".$this->tablename;
		$sql .= $joinsql;

		$sql .= "\n".' WHERE 1 = 1'."\n";
		// where bedingungen

		foreach ( $this->criterias as $key => $criteria ){
			$criteria instanceof Criteria;
			// type

			$last = (isset($this->criterias[$key-1]) ? $this->criterias[$key-1] : null );
			$next = (isset($this->criterias[$key+1]) ? $this->criterias[$key+1] : null );

			switch ($criteria->getType()){
				case Criteria::LOGICAL_AND:
				case Criteria::LOGICAL_OR:
					$sql .= ' '.$criteria->getType().' ';
					break;
			}

			if( $next AND $criteria->getType() == Criteria::LOGICAL_AND AND $next->getType() == Criteria::LOGICAL_OR )
				$sql .= ' ( ';

			$sql .= $criteria->getWhereClause() ;

			if( $criteria->getType() == Criteria::LOGICAL_OR AND $last->getType() == Criteria::LOGICAL_AND )
				$sql .= ' ) ';
		}

		if(!empty($this->groupby))
			$sql .= ' GROUP BY '.implode(' ,',$this->groupby);
		if(!empty($this->order))
			$sql .= ' ORDER BY '.implode(' ,',$this->order);

		if(isset($_GET['debugmode']) )
			echo "<pre>$sql</pre>";
		// select verarbeiten und result an klassen übergeben
		$myResult = BaseDAO::genericQuery($sql, Criteria::getParams(), new SQLLimit($this->limit, $this->offset));
		if( !$myResult )
			return false;

		$classname = $this->modelname.'List';
		$myList = new $classname();
		$get_references_from_database = !empty($models["joins"]);
		while($myResult->next()){
			$myBaseObject = call_user_func_array(array($this->modelname.'DAO', 'get'.$this->modelname.'FromResult'), array(&$myResult,$get_references_from_database) );
			// subs
			if( !empty($models["joins"]) )
			foreach( $models["joins"] as $classname ){
				$mySubObject = call_user_func_array( array($classname.'DAO', 'get'.$classname.'FromResult'), array(&$myResult) );
				$function = 'set'.$classname;
				if( method_exists($myBaseObject, $function) )
					$myBaseObject->$function($mySubObject);
			}
			$myList->add($myBaseObject);
		}

		Criteria::reset();
		return $myList;
	}

	public function findOne(){
		$this->setLimit(1);
		$myList = $this->build();
		return $myList->valid() ? $myList->current() : null;
	}

	public function find() {
		return $this->build();
	}

}
