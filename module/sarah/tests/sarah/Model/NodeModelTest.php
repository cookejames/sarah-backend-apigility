<?php
/**
 * NodeModel test case.
 */
class NodeModelTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var NodeModel
	 */
	private $nodeModel;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$bootstrap = PHPUnitBootstrap::getInstance();
		$serviceManager = $bootstrap->getServiceManager();
		$this->nodeModel = $serviceManager->get('NodeModel');
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated NodeModelTest::tearDown()
		$this->nodeModel = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests NodeModel->getNodes()
	 */
	public function testGetNodes() 
	{
		$nodes = $this->nodeModel->getNodes();
		
		$this->assertInternalType('array', $nodes);
		
		$this->assertGreaterThan(0, count($nodes));
		
		foreach ($nodes as $node) {
			$this->assertInstanceOf('sarah\Entity\Node', $node);
		}
	}
	
	/**
	 * Tests NodeModel->getNodeById()
	 */
	public function testGetNodeById() 
	{
		$id = 1;
		$node = $this->nodeModel->getNodeById($id);
		$this->assertInstanceOf('sarah\Entity\Node', $node);
		$this->assertEquals($id, $node->getId());
		
		$node = $this->nodeModel->getNodeById('foo');
		$this->assertNull($node); 
	}
	
	/**
	 * Tests NodeModel->getNodeByName()
	 */
	public function testGetNodeByName() {
		// TODO Auto-generated NodeModelTest->testGetNodeByName()
		$this->markTestIncomplete ( "getNodeByName test not implemented" );
		
		$this->nodeModel->getNodeByName(/* parameters */);
	}
}

