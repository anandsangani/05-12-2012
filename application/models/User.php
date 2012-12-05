<?php
require_once 'Zend/Db/Table.php';
    class User extends Zend_Db_Table
	{
		protected $_name="user";
		function checkUnique($username)
		{
			$select = $this->_db->select()
								->from($this->_name,array('username'))
								->where('username=?',$username);
			$result = $this->getAdapter()->fetchOne($select);
			if($result){
				return true;
			}
			return false;
		}
    }
?>