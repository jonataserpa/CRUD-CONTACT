<?php
require 'Database.php';

class ContactsGateway extends Database
{

	public function selectAll($order)
	{
		if (!isset($order))
		{
			$order = 'name';
		}
		$pdo = Database::connect($order);
		$sql = $pdo->prepare("SELECT * FROM contacts WHERE IFNULL(c_fdeletado, 0) =0 ORDER BY $order ");
		$sql->execute();

		$contacts = array();
		while ($obj = $sql->fetch(PDO::FETCH_OBJ))
		{
			$contacts[] = $obj;
		}
		return json_encode($contacts);
	}

	public function selectById($id)
	{
		$pdo = Database::connect();
		$sql = $pdo->prepare("SELECT * FROM phone WHERE IFNULL(p_fdeletado, 0) =0 AND p_conctacts_id = ?");
		$sql->bindValue(1, $id);
		$sql->execute();

		$contacts = array();
		while ($obj = $sql->fetch(PDO::FETCH_OBJ))
		{
			$contacts[] = $obj;
		}
		return json_encode($contacts);
	}

	public function insert($name, $email, $address, $phones)
	{
		try {
			$pdo = Database::connect();
			$sql = $pdo->prepare("INSERT INTO contacts(c_name, c_email, c_address) VALUES(?, ?, ?)");		
			$result = $sql->execute(array($name, $email, $address));
			$ultimoID = $pdo->lastInsertId();

			$convert = implode(" ", $phones);
			$array = explode("#|#", $convert);
			if ($array[0] != "") {
				foreach ($array as $each) {
					$phone = explode("*", $each);
					$pdo = Database::connect();
					$sql = $pdo->prepare("INSERT INTO phone(p_tipo, p_numero, p_conctacts_id) VALUES(?, ?, ?)");		
					$result = $sql->execute(array($phone[0], $phone[1], $ultimoID));
				}
			}

		} catch(Exception $e) {
			if($e->errorInfo[1] === 1062) echo 'Duplicate entry';
		}
	}
	
	public function edit($id, $name, $email, $address, $phones)
	{
		try {
			$pdo = Database::connect();
			$sql = $pdo->prepare("UPDATE contacts SET c_name = ?, c_email = ?, c_address = ? WHERE c_id = ? LIMIT 1");
			$result = $sql->execute(array($name, $email, $address, $id));
			$phones = $this->deletePhone($id, $phones);
			
			foreach ($phones as $each) {
				$pdo = Database::connect();
				$sql = $pdo->prepare("INSERT INTO phone(p_tipo, p_numero, p_conctacts_id) VALUES(?, ?, ?)");		
				$result = $sql->execute(array($each['p_tipo'], $each['p_numero'], $id));
			}
		} catch(Exception $e) {
			if($e->errorInfo[1] === 1062) echo 'Duplicate entry';
		}
	}

	public function deletePhone($id, $phones)
	{
		$pdo = Database::connect();
		$sql = $pdo->prepare("UPDATE phone SET p_fdeletado=1 WHERE p_conctacts_id =?");
		$sql->execute(array($id));

		return $phones;
	}
	
	public function delete($id)
	{
		$pdo = Database::connect();
		$sql = $pdo->prepare("UPDATE contacts SET c_fdeletado=1 WHERE c_id =?");
		$sql->execute(array($id));
	}

	public function verifyExistsEmail($email)
	{
		$pdo = Database::connect();
		$sql = $pdo->prepare("SELECT * FROM contacts WHERE IFNULL(c_fdeletado, 0) =0 AND c_email = ?");
		$sql->bindValue(1, $email);
		$sql->execute();

		$emailContacts = array();
		while ($obj = $sql->fetch(PDO::FETCH_OBJ))
		{
			$emailContacts[] = $obj;
		}
		return json_encode($emailContacts);
	}
	
	public function filterByContact($filter)
	{
		$pdo = Database::connect();
		$sql = $pdo->prepare("SELECT * FROM contacts WHERE IFNULL(c_fdeletado, 0) =0 AND c_name LIKE'%".$filter['filterByContact']."%' OR c_email LIKE '%".$filter['filterByContact']."%' OR c_address LIKE '%".$filter['filterByContact']."%'");
		$sql->bindValue(1, "%".$filter['filterByContact']."%");
		$sql->execute();

		$nameContacts = array();
		while ($obj = $sql->fetch(PDO::FETCH_OBJ))
		{
			$nameContacts[] = $obj;
		}
		return json_encode($nameContacts);
	}
	
	public function filterByLogin($login)
	{
		$pdo = Database::connect();
		$sql = $pdo->prepare("SELECT c_password FROM contacts WHERE IFNULL(c_fdeletado, 0) =0 AND c_email = ?");
		$sql->bindValue(1, $login['email']);
		$sql->execute();

		$aux='$2b$10$Eysb86Jw5vEK7/UzhslKIOiunco5AclOwLRoQZQxMlZr5UnkQXXTm'; //242e7eedd01aa7a57abb6f5fd506832b
        $bcrypt= $login['password'];

		while ($obj = $sql->fetch(PDO::FETCH_OBJ))
		{
			$pass = $obj->c_password;
			if(!password_verify($bcrypt, $pass)){
				$retorno = array('codigo' => 0, 'mensagem' => 'Atencao! Usuario Invalido Email/Senha!');
				$_SESSION['logado'] = false;
				return json_encode($retorno);
				exit();
			}else{
				$session = $_SESSION['logado'] = true;
				$retorno = array('codigo' => 1, 'mensagem' => 'Logon with success!', 'session', $session);
				session_start(); 
                return json_encode($retorno);
			}
		}
	}

}

?>
