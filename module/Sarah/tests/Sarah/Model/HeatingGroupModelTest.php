<?php
use Doctrine\ORM\Query;
use SarahTest\Bootstrap;
use Sarah\Model\HeatingGroupModel;
use SarahTest\Database\TestCase;
/**
 * NodeModel test case.
 */
class HeatingGroupModelTest extends TestCase 
{
	/**
	 *
	 * @var HeatingGroupModel
	 */
	private $heatingGroupModel;
	
	/* (non-PHPdoc)
	 * @see \SarahTest\Database\TestCase::getServiceLocator()
	*/
	protected function getServiceLocator ()
	{
		return Bootstrap::getServiceManager();
	}
	
	/* (non-PHPdoc)
	 * @see PHPUnit_Extensions_Database_TestCase::getDataSet()
	*/
	protected function getDataSet ()
	{
		return $this->createArrayDataSet(array(
			'heatingGroups' => array(
				array(
					'id' => 1,
					'name' => 'group1',
					'isEnabled' => true
				),
			)
		));
	}
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->heatingGroupModel = $this->getServiceLocator()->get('HeatingGroupModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated NodeModelTest::tearDown()
		parent::tearDown ();
		$this->heatingGroupModel = null;
	}
	
	public function testGetHeatingGroupsArrayHydrator() 
	{
	    $this->heatingGroupModel->setHydrationMode(Query::HYDRATE_ARRAY);
		$entities = $this->heatingGroupModel->getHeatingGroups();
		
		$this->assertInternalType('array', $entities);
		
		$this->assertGreaterThan(0, count($entities));
		
		foreach ($entities as $entity) {
			$this->assertInternalType('array', $entity);
		}
	}
	
	public function testGetHeatingGroupsObjectHydrator()
	{
	    $this->heatingGroupModel->setHydrationMode(Query::HYDRATE_OBJECT);
	    $entities = $this->heatingGroupModel->getHeatingGroups();
	
	    $this->assertInternalType('array', $entities);
	
	    $this->assertGreaterThan(0, count($entities));
	
	    foreach ($entities as $entity) {
	        $this->assertInstanceOf('Sarah\Entity\HeatingGroup', $entity);
	    }
	}
	
	public function testGetHeatingGroupById() 
	{
		$id = 1;
		$entity = $this->heatingGroupModel->getHeatingGroupById($id);
		$this->assertInstanceOf('Sarah\Entity\HeatingGroup', $entity);
		$this->assertEquals($id, $entity->getId());
		
		$entity = $this->heatingGroupModel->getHeatingGroupById('foo');
		$this->assertNull($entity); 
	}
}

