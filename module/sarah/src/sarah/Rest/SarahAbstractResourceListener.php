<?php
namespace sarah\Rest;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\AbstractHydrator;
use sarah\Model\SarahModelAbstract;
use sarah\Entity\SarahEntityInterface;
use ZF\Rest\AbstractResourceListener;

class SarahAbstractResourceListener extends AbstractResourceListener
{
	/**
	 * @var SarahModelAbstract
	 */
	protected $model;
	
	/**
	 * @var HydratorInterface
	 */
	protected $hydrator;
	
	/**
	 * @var object
	 */
	protected $prototype;
	
	/**
	 * @var SarahEntityInterface
	 */
	protected $doctrinePrototype;
	
	/**
	 * @var AbstractHydrator
	 */
	protected $doctrineHydrator;
	
	public function __construct(SarahModelAbstract $model, HydratorInterface $hydrator = null, $prototype = null)
	{
		$this->model = $model;
		$this->hydrator = $hydrator;
		$this->prototype = $prototype;
	}
	

	/**
	 * @param \sarah\Entity\SarahEntityInterface $doctrinePrototype
	 */
	public function setDoctrinePrototype(SarahEntityInterface $doctrinePrototype) {
		$this->doctrinePrototype = $doctrinePrototype;
		return $this;
	}
	
	/**
	 * @param \Zend\Stdlib\Hydrator\AbstractHydrator $doctrineHydrator
	 */
	public function setDoctrineHydrator(AbstractHydrator $doctrineHydrator) {
		$this->doctrineHydrator = $doctrineHydrator;
		return $this;
	}
}