<?php
namespace Blog\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;


class UserprofileTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAllusers()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getUsersbyParentId($id)
	{
		/*$sql = new Sql($this->adapter);
		$select = $sql->select();
		$select->from($this->table)
				->join('users', 'users.id = user_profile.parent_id');
		$where  =	new where();
		$where->equalto('parent_id', $id);
		$select->where($where);

		//echo $select->getSqlString();
		$statement = $sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();

		return $result;*/

		$parent_id  = (int) $id;
        $resultset = $this->tableGateway->select(array('parent_id' => $parent_id));
        //$row = $rowset->current();
        /*if (!$row) {
            throw new \Exception("Could not find row $id");
        }*/
        return $resultset->toArray();

	}

}


?>