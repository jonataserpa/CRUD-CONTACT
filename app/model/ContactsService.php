<?php

require_once 'ContactsGateway.php';
require_once 'ValidationException.php';
require_once 'Database.php';

class ContactsService extends ContactsGateway
{

	private $contactsGateway = null;

	public function __construct()
	{
		$this->contactsGateway = new ContactsGateway();
	}

	public function getAllContacts($order)
	{
		try
		{
			self::connect();
			$result = $this->contactsGateway->selectAll($order);
			self::disconnect();
			return $result;
		}
		catch(Exception $e)
		{	
			self::disconnect();
			throw $e;
		}
	}
	
	public function filterByContact($filter)
	{
		try
		{
			self::connect();
			$result = $this->contactsGateway->filterByContact($filter);
			self::disconnect();
			return $result;
		}
		catch(Exception $e)
		{	
			self::disconnect();
			throw $e;
		}
	}
	
	public function filterByLogin($login)
	{
		try
		{
			self::connect();
			$result = $this->contactsGateway->filterByLogin($login);
			self::disconnect();
			return $result;
		}
		catch(Exception $e)
		{	
			self::disconnect();
			throw $e;
		}
	}

	public function getContact($id)
	{
		try
		{
			self::connect();
			$result = $this->contactsGateway->selectById($id);
			self::disconnect();
		}
		catch(Exception $e)
		{	
			self::disconnect();
			throw $e;
		}
		return $this->contactsGateway->selectById($id);
	}

	private function validateContactParams($name, $email, $address)
	{
		$errors = array();

		if ( !isset($name) || empty($name) ) { 
		    $errors[] = 'Name is required'; 
		}
		if ( !isset($email) || empty($email) ) { 
		    $errors[] = 'Email is required'; 
		}
		if ( !isset($address) || empty($address) ) { 
		    $errors[] = 'address is required'; 
		}
		if (empty($errors))
		{
			return;
		}
		throw new ValidationException($errors);
	}

	public function createNewContact($name, $email, $address, $phones)
	{
		try 
		{
			self::connect();
			$this->validateContactParams($name, $email, $address);
			$result = $this->contactsGateway->insert($name, $email, $address, $phones);
			self::disconnect();
			return $result;
		}
		catch(Exception $e)
		{
			self::disconnect();
			throw $e;
		}
	}

	public function editContact($id, $name, $email, $address, $phones)
	{
		try 
		{
			self::connect();
			$result = $this->contactsGateway->edit($id, $name, $email, $address, $phones);
			self::disconnect();
		}
		catch(Exception $e) {
			self::disconnect();
			throw $e;
		}
	}
	public function deleteContact($id)
	{
		try
		{
			self::connect();
			$result = $this->contactsGateway->delete($id);
			self::disconnect();
		}
		catch(Exception $e)
		{
			self::disconnect();
			throw $e;
		}
	}
	public function validaEmail($email)
	{
		try
		{
			self::connect();
			$result = $this->contactsGateway->verifyExistsEmail($email);
			self::disconnect();
			return $result;
		}
		catch(Exception $e)
		{
			self::disconnect();
			throw $e;
		}
	}

}

?>
