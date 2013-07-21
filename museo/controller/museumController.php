<?php

/**
 * Controller class for Museum actions
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace museo\controller;

use museo\model\museumManager;
use museo\model\museum;
use museo\model\categoryManager;
use museo\lib\controller;

class museumController extends controller
{
	// Action : List museums
	function listAction() {
			
		$museumManager = new museumManager($this->db);
		$collection = $museumManager->getAll();
		
		return (array("collection" => $collection));
	}

	// Action : Show details of a museum
	function showAction() {
	

		$museum = $this->getOneById();
		return (array("museum" => $museum));
	}

	// Action : Confirmation page to delete a museum
	function deleteAction() {
	
		$museum = $this->getOneById();
		return (array("museum" => $museum));
	}
		
	// Retrieve a museum from its id
	protected function getOneById($id = false) {
	
		if (!$id) {
			$id = $this->requireParam('id', \FILTER_VALIDATE_INT);
		}
		
		$museumManager = new museumManager($this->db);
		$museum = $museumManager->getOneById($id);
		
		return ($museum);
	}
	
	// Action : Delete a museum
	function eraseAction() {
	
		$id = $this->requireParam('id', \FILTER_VALIDATE_INT);

		$museumManager = new museumManager($this->db);
		$museum = $museumManager->deleteOneById($id);
		
		return (true);
	}	

	// Action : Access to form to create a museum
	function newAction() {
	
		// get errors and data from session, so user do not lose inserted data in case of error
		$sessionNamePrefix = 'museum_insert';
		list($data, $errors) = $this->initNewAction($sessionNamePrefix);
		
		return (array(
			'categories' => $this->getCategoriesTree(),
			'token'      => $this->generateCrsf('museum_insert'),
			'errors'     => $errors,
			'values'     => $data,
		));
	}	
	
	// Get the tree of categories
	private function getCategoriesTree() {

		$categoryManager = new categoryManager($this->db);
		return $categoryManager->getCategoriesTree();
	}
	
	// Action : Create a museum
	function createAction()	{

		$createdId = $this->treateForm('insert');
		if ($createdId) {
			// redirect to view
			$_SESSION['message'] = "Le musée a été créé avec succès.";
			$redirect = 'showMuseum.php?id=' . $createdId; 
		} else {
			// redirect to form
			$redirect = 'newMuseum.php'; 
		}
		header('Location: '.$redirect);
	}
	
	// Treat form submission for both creation or edition
	private function treateForm($action)	{
	
		// Security and other initialisation
		$id = $this->getParam('id', \FILTER_VALIDATE_INT);
		$sessionNamePrefix = 'museum_'.$action . $id;
		$this->initTreatForm($sessionNamePrefix);
		
		// Clear data
		$museumManager = new museumManager($this->db);
		$taintedData = $_POST['museum'];
		$data = $museumManager->sanitizeData($taintedData);
		
		// Treat submitted form 
		if (!($errors = $museumManager->validateData($data))) {		
			// try to store data in db
			$storeReport = $museumManager->$action($data);
			if ($storeReport['hasError'] === true) {
				$errors = $storeReport['errors'];
			} else {
				// It is a success !
				unset ($_SESSION[$sessionNamePrefix.'_errors']);
				unset ($_SESSION[$sessionNamePrefix.'_data']);
				// redirect to edit page, or show page ?
				return $storeReport['museumId'];
			}
		}
		
		// set errors and data in session, so user do not lose inserted data in case of error
		$_SESSION[$sessionNamePrefix.'_errors'] = $errors;
		$_SESSION[$sessionNamePrefix.'_data'] = $data;
		
		return false;
	}
	
	// action : show edit form
	function editAction() {
	
		$id = $this->requireParam('id', \FILTER_VALIDATE_INT);
		$sessionNamePrefix = 'museum_update'.$id;
		list($data, $errors) = $this->initEditAction($sessionNamePrefix);
					
		return (array(
			'categories' => $this->getCategoriesTree(),
			'token'      => $this->generateCrsf($sessionNamePrefix),
			'errors'     => $errors,
			'values'     => $data,
		));
	}

	// action : treat edit from
	function modifyAction()	{
	
		$id = $this->requireParam('id', \FILTER_VALIDATE_INT);
	
		$museumId = $this->treateForm('update');
		if ($museumId) {
			// redirect to view
			$_SESSION['message'] = "Le musée a été modifié avec succès.";
			$redirect = 'showMuseum.php?id=' . $id; 
		} else {
			// redirect to form
			$redirect = 'editMuseum.php?id=' . $id;
		}
		
		return (array('redirect' => $redirect));
	}
}
	