<?php
namespace Sarah\Paginator;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Stdlib\Hydrator\HydratorInterface;

class DoctrineHydratingArrayAdapter extends DoctrinePaginator
{
	/**
	 * @var HydratorInterface
	 */
	protected $hydrator;
	
	/**
	 * @var object
	 */
	protected $prototype;
	
	public function __construct($paginator, HydratorInterface $hydrator = null, $prototype = null)
	{
		parent::__construct($paginator);
		$this->hydrator = $hydrator;
		$this->prototype = $prototype ?: new \stdClass;
	}
	
	public function getItems($offset, $itemCountPerPage)
	{
		$items = parent::getItems($offset, $itemCountPerPage);
		if (!$this->hydrator instanceof HydratorInterface) {
			return $items;
		}
		
		$hydrated = array();
		foreach ($items as $item) {
			$hydrated[] = $this->hydrator->hydrate($item, clone $this->prototype);
		}
		
		return new \ArrayIterator($hydrated);
	}
}
