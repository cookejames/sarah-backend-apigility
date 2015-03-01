<?php
namespace SarahTest\Database;

use Zend\ServiceManager\ServiceLocatorInterface;
use SarahTest\Database\DataSet\ArrayDataSet;
use Doctrine\ORM\EntityManager;

/**
 * Base TestCase which clears the existing database as configured in 
 * Doctrines entities and creates it using the schema built from those entites. 
 * @author James Cooke
 *
 */
abstract class TestCase extends \PHPUnit_Extensions_Database_TestCase
{
	protected $schema = '';
	
	/**
	 * @return ServiceLocatorInterface
	 */
	abstract protected function getServiceLocator();
	
	/**
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}
	
	/* (non-PHPdoc)
	 * @see PHPUnit_Extensions_Database_TestCase::getConnection()
	 */
	protected function getConnection()
	{
		$pdo = $this->getEntityManager()->getConnection()->getWrappedConnection();
		
		// Pass to PHPUnit
		return $this->createDefaultDBConnection($pdo);
	}
	
	/**
	 * Creates a DataSet from an array
	 * @param array $data
	 * @return \VrApi\VrDatabaseTest\Database\DataSet\ArrayDataSet
	 */
	protected function createArrayDataSet(array $data, $classNames = NULL)
	{
		$classes = array();
		$entityManager = $this->getEntityManager();
		$entityManager->clear();
		
		// Schema Tool to process our entities
		$tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
		if (!is_null($classNames)) {
			foreach($classNames as $className)
			{
				$classes[] = $entityManager->getMetadataFactory()->getMetadataFor($className);
			}
		} else {
			$classes = $entityManager->getMetaDataFactory()->getAllMetaData();
		}
		$tool->dropSchema($classes);
		$tool->createSchema($classes);
		
		return new ArrayDataSet($data);
	}
}
