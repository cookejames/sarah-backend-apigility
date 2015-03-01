<?php
use Doctrine\ORM\Query;
use SarahTest\Bootstrap;
use Sarah\Model\NodeModel;
use SarahTest\Database\TestCase;
/**
 * NodeModel test case.
 */
class NodeModelTest extends TestCase 
{
	/**
	 * @var NodeModel
	 */
	private $nodeModel;
	
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
			'nodes' => array(
				array(
					'id' => 1,
					'name' => 'node1',
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
		$this->nodeModel = $this->getServiceLocator()->get('NodeModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated NodeModelTest::tearDown()
		parent::tearDown ();
		$this->nodeModel = null;
	}
	
	/**
	 * Tests NodeModel->getNodes()
	 */
	public function testGetNodesArrayHydrator() 
	{
	    $this->nodeModel->setHydrationMode(Query::HYDRATE_ARRAY);
		$nodes = $this->nodeModel->getNodes();
		
		$this->assertInternalType('array', $nodes);
		
		$this->assertEquals(1, count($nodes));
		
		foreach ($nodes as $node) {
			$this->assertInternalType('array', $node);
		}
	}
	
	public function testGetNodesObjectHydrator()
	{
	    $this->nodeModel->setHydrationMode(Query::HYDRATE_OBJECT);
	    $nodes = $this->nodeModel->getNodes();
	
	    $this->assertInternalType('array', $nodes);
	
	    $this->assertEquals(1, count($nodes));
	
	    foreach ($nodes as $node) {
	        $this->assertInstanceOf('Sarah\Entity\Node', $node);
	    }
	}
	
	/**
	 * Tests NodeModel->getNodeById()
	 */
	public function testGetNodeById() 
	{
		$id = 1;
		$node = $this->nodeModel->getNodeById($id);
		$this->assertInstanceOf('Sarah\Entity\Node', $node);
		$this->assertEquals($id, $node->getId());
		
		$node = $this->nodeModel->getNodeById('foo');
		$this->assertNull($node); 
	}
}

