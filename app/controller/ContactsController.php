<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/model/Autoloader.php';
require_once ROOT_PATH . 'ContactsService.php';

class ContactsController 
{

	private $contactsService = null;

	public function __construct()
	{
		$this->contactsService = new ContactsService();
	}

	public function redirect($location)
	{
		header('Location: ' . $location);
	}

	public function handleRequest($url)
	{
		try 
		{
			$url = explode('/', $url);
			if($url[0] == "index"){
				require_once 'pages/' . $url[0] . '.php';
			}else if($url[0] == "home"){
				require_once 'pages/' . $url[0] . '.php';	
			}else if($url[0] == "contact"){
				if ($_SERVER["REQUEST_METHOD"] == "POST"):
					header('Content-Type: application/json; charset=utf-8');
					$dataJSON = file_get_contents('php://input');
					$data= json_decode($dataJSON, TRUE ); 

					if($data['action'] == "save"){
						$contact = $this->saveContact($dataJSON, $data);
						return $contact;
					}else if($data['action'] == "update"){
						$contact = $this->editContact($dataJSON, $data);
						return $contact;
					}else if($data['action'] == "delete"){
						$contact = $this->deleteContact($dataJSON);
						return $contact;
					}else if($data['action'] == "findById"){
						$contact = $this->findByIdContact($dataJSON, $data);
						return $contact;
					}else if($data['action'] == "validaEmail"){
						$contact = $this->validaEmail($dataJSON, $data);
						return $contact;
					}else if($data['action'] == "filterByContact"){
						$contact = $this->filterByContact($data);
						return $contact;
					}
				endif;
				if ($_SERVER["REQUEST_METHOD"] == "GET"):
					$contact = $this->listContacts();
					return $contact;
				endif;
			} else if($url[0] == "about"){
				header("Location: https://github.com/jonataserpa", true);
			} else if($url[0] == "logout"){
				require_once 'pages/' . $url[0] . '.php';
			} else if($url[0] == "login"){
				header('Content-Type: application/json; charset=utf-8');
				$dataJSON = file_get_contents('php://input');
				$data= json_decode($dataJSON, TRUE ); 

				$contact = $this->logon($data);
				return $contact;
			}
		}
		catch(Exception $e)
		{
			require_once 'pages/error.php';
		}
	}	

	public function listContacts()
	{
		$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : null;
		return $this->contactsService->getAllContacts($orderby);
	}
	
	public function filterByContact($filter)
	{
		return $this->contactsService->filterByContact($filter);
	}
	
	public function logon($login)
	{
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://localhost/"):
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://www.localhost/"):
                $retorno = array('mensagem' => 'Origem da requisicao nao autorizada!');
                echo json_encode($retorno);
                exit();
            endif;
        endif;
        
        if (empty($login['email'])):
            $retorno = array('codigo' => '0', 'mensagem' => 'Fill you  e-mail!');
            echo json_encode($retorno);
            exit();
        endif;
        
        if (!filter_var($login['email'], FILTER_VALIDATE_EMAIL)):
            $retorno = array('codigo' => '0', 'mensagem' => 'E-mail invalid!');
            echo json_encode($retorno);
            exit();
        endif;    
        
        if (empty($login['password'])):
            $retorno = array('codigo' => '0', 'mensagem' => 'Fill you password!');
            echo json_encode($retorno);
            exit();
		endif;
		
		return $this->contactsService->filterByLogin($login);
	}

	public function saveContact($dataJSON, $data)
	{
		$contacts = filter_var_array(json_decode($dataJSON, true), [
			'name'    => FILTER_SANITIZE_STRING,
			'email'   => [ 'filter' => FILTER_VALIDATE_EMAIL,
						   'flags'  => FILTER_NULL_ON_FAILURE ],
			'address' => FILTER_SANITIZE_STRING
		]);
			
		$name = $this->validate_input($contacts['name']);
		$email = $this->validate_input($contacts['email']);
		$address = $this->validate_input($contacts['address']);
		$phones = $data['phones'];
			
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://localhost/"):
			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://www.localhost/"):
				$retorno = array('mensagem' => 'Origen request not authorization!');
				echo json_encode($retorno);
				exit();
			endif;
		endif;
		
		if (empty($name)):
			$retorno = array('name' => '', 'mensagem' => 'Fill your name!');
			echo json_encode($retorno);
			exit();
		endif;
		
	   
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
			$retorno = array('email' => '', 'mensagem' => 'E-mail fill error!');
			echo json_encode($retorno);
			exit();
		endif;    
		
		if (empty($address)):
			$retorno = array('address' => '', 'mensagem' => 'Fill your address!');
			echo json_encode($retorno);
			exit();
		endif;
	  
		$errors = array();
		try
		{
			$contact = $this->contactsService->createNewContact($name, $email, $address, $phones);
			return json_encode(array('status' => "200", 'mensagem' => 'Contact inserted with success!'));

		}
		catch(ValidationException $e)
		{
			$errors = $e->getErrors();
			echo json_encode(array('status' => "500", 'mensagem' => "Failed inserted! $errors"));
		}
	}

	public function editContact($dataJSON, $data)
	{

		$contacts = filter_var_array(json_decode($dataJSON, true), [
			'id'    => FILTER_SANITIZE_NUMBER_INT,
			'name'    => FILTER_SANITIZE_STRING,
			'email'   => [ 'filter' => FILTER_VALIDATE_EMAIL,
						   'flags'  => FILTER_NULL_ON_FAILURE ],
			'address' => FILTER_SANITIZE_STRING
		]);
			
		$id = $this->validate_input($contacts['id']);
		$name = $this->validate_input($contacts['name']);
		$email = $this->validate_input($contacts['email']);
		$address = $this->validate_input($contacts['address']);
		$phones = $data['phones'];
		$errors = array();

		try 
		{
			 $this->contactsService->editContact($id, $name, $email, $address, $phones);
			 return json_encode(array('status' => "200", 'mensagem' => 'Contact altered with success!'));
		}
		catch(ValidationException $e)
		{
			$errors = $e->getErrors();
			echo json_encode(array('status' => "500", 'mensagem' => 'Failed altered!'));
		}
		
	}

	public function deleteContact($dataJSON)
	{
		$contacts = filter_var_array(json_decode($dataJSON, true), [
			'id'    => FILTER_SANITIZE_NUMBER_INT
		]);
			
		$idContact = $this->validate_input($contacts['id']);

		if (!$contacts):
			$retorno = array('mensagem' => 'id invalid contact administrador!');
			echo json_encode($retorno);
			exit();
		endif;   

		$errors = array();
		try{

			$this->contactsService->deleteContact($idContact);
			return json_encode(array('status' => "200", 'mensagem' => 'Contact deleted with success!'));
		} catch(ValidationException $e)
		{
			$errors = $e->getErrors();
			echo json_encode(array('status' => "500", 'mensagem' => "Failed deleted! $errors"));
		}

	}

	public function findByIdContact($dataJSON, $data)
	{
		$contacts = filter_var_array(json_decode($dataJSON, true), [
			'id'    => FILTER_SANITIZE_NUMBER_INT
		]);
			
		$idContact = $this->validate_input($contacts['id']);

		$errors = array();
		if (!$idContact)
		{
			throw new Exception('Internal error');
		}
		return $this->contactsService->getContact($idContact);

	}
	
	public function validaEmail($dataJSON, $data)
	{
		$contacts = filter_var_array(json_decode($dataJSON, true), [
			'email'   => [ 'filter' => FILTER_VALIDATE_EMAIL,
						   'flags'  => FILTER_NULL_ON_FAILURE ],
		]);
			
		$emailContact = $this->validate_input($contacts['email']);

		if (!filter_var($emailContact, FILTER_VALIDATE_EMAIL)):
			$retorno = array('email' => '', 'mensagem' => 'E-mail invalido!');
			echo json_encode($retorno);
			exit();
		endif;   

		$emailExists =  $this->contactsService->validaEmail($emailContact);
		if($emailExists != "[]"){
			$retorno = array('status' => '500', 'mensagem' => 'E-mail already exists!');
		}
		return $retorno;

	}

	public function index(){
        return 'index';
    }
	
	public function about(){
        return 'about';
    }
	
	public function contact(){
        return 'contact';
	}
	
	public function home(){
		require_once 'pages/' . $url[0] . '.php';	
	}
	
	public function login(){
		return 'login';
	}

	function validate_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}

?>
