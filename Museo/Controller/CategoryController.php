<?php

/**
 * Controller class for Category actions
 *
 * @package : Museo test for Naoned
 *
 * @author Vibby <vincent.beauvivre@gmail.com>
 */
 
namespace Museo\Controller;

use Museo\Model\CategoryManager;
use Museo\Model\Category;
use Museo\Lib\Controller;

class CategoryController extends controller
{
	// Action : List categories
	function listAction() {	

		$categoryManager = new CategoryManager($this->db);
		$dbCategories = $categoryManager->getAll();
		$tree = $categoryManager->buildTree($dbCategories);
		
		return (array("collection" => $tree));
	}

	// Action : Confirmation alert before deleting a category
	function deleteAction() {
		
		$category = $this->getOneById();
		return (array("category" => $category));
	}

	// Action : Delete a category
	function eraseAction() {
		
		$category = $this->getOneById();
		
		$categoryManager = new CategoryManager($this->db);
		// If requested, let's move children to upper level in hierachy before deletion
		if($_POST['childrenInherit'] == 'liftUp') {
			$categoryManager->replaceParentId($category->getId(), $category->getParentId());
		}
		$categoryManager->delete($category->getId());
				
		return (array("category" => $category));
	}		
	
	// Retrieve a museum from its id
	protected function getOneById($id = false) {
	
		if (!$id) {
			$id = $this->requireParam('id', \FILTER_VALIDATE_INT);
		}
		
		$categoryManager = new CategoryManager($this->db);
		$collection = $categoryManager->getOneById($id);
				
		return ($collection);
	}

	// Action : Access to form to create a category
	function newAction() {
	
		// get errors and data from session, so user do not lose inserted data in case of error
		$sessionNamePrefix = 'category_insert';
		list($data, $errors) = $this->initNewAction($sessionNamePrefix);
		
		return (array(
			'categories' => $this->getCategoriesTree(),
			'token'      => $this->generateCrsf('category_insert'),
			'errors'     => $errors,
			'values'     => $data,
		));
	}
	
	// Get the tree of categories
	private function getCategoriesTree() {

		$categoryManager = new CategoryManager($this->db);
		return $categoryManager->getCategoriesTree();
		
	}
		
	// Action : Create a category
	function createAction()	{

		$createdId = $this->treateForm('insert');

		if ($createdId) {
			// redirect to categories list
			$_SESSION['message'] = "La catégorie a été créé avec succès.";
			$redirect = 'categories.php'; 
		} else {
			// redirect to form
			$redirect = 'newCategory.php'; 
		}
		header('Location: '.$redirect);

	}	
	
	// Treat form submission for both creation or edition
	private function treateForm($action)	{
		
		// Security and other initialisation
		$id = $this->getParam('id', \FILTER_VALIDATE_INT);
		$sessionNamePrefix = 'category_'.$action . $id;
		$this->initTreatForm($sessionNamePrefix);
		
		// Clear data
		$categoryManager = new CategoryManager($this->db);
		$taintedData = $_POST['category'];
		$data = $categoryManager->sanitizeData($taintedData);
				
		// Treat submitted form 
		if (!($errors = $categoryManager->validateData($data))) {		
			// try to store data in db
			$storeReport = $categoryManager->$action($data);
			if ($storeReport['hasError'] === true) {
				$errors = $storeReport['errors'];
			} else {
				// It is a success !
				unset ($_SESSION[$sessionNamePrefix.'_errors']);
				unset ($_SESSION[$sessionNamePrefix.'_data']);

				return $storeReport['categoryId'];
			}
		}
		
		// set errors and data in session, so user do not lose inserted data in case of error
		$_SESSION[$sessionNamePrefix.'_errors'] = $errors;
		$_SESSION[$sessionNamePrefix.'_data'] = $data;
		
		return false;
	}	
	
	// action : show edit from
	function editAction() {
	
		$id = $this->requireParam('id', \FILTER_VALIDATE_INT);
		$sessionNamePrefix = 'category_update'.$id;
		list($data, $errors) = $this->initEditAction($sessionNamePrefix);
		unset ($_SESSION[$sessionNamePrefix.'_errors']);
					
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
			$_SESSION['message'] = "La catégorie a été modifiée avec succès.";
			$redirect = 'categories.php'; 
		} else {
			// redirect to form
			$redirect = 'editCategory.php?id=' . $id;
		}
		
		return (array('redirect' => $redirect));
	}
	
}
