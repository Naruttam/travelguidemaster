<?php
namespace Blog\Model;
use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fecthAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getUserByToken($token)
	{
		$rowset = $this->tableGateway->select(array('user_registration_token' => $token));
		$row = $rowset->current();
		 if (!$row) {
            throw new \Exception("Could not find row $token");
        }
        return $row;
	}
}