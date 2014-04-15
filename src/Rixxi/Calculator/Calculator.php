<?php

namespace Rixxi\Calculator;

use Kdyby;
use Kdyby\Money\Money;
use Nette;


/**
 * @method mixed add(mixed $a, mixed $b)
 * @method mixed subtract(mixed $a, mixed $b)
 * @method mixed multiply(mixed $a, mixed $b)
 * @method mixed divide(mixed $a, mixed $b)
 */
class Calculator extends Nette\Object
{

	const DEFAULT_PRECISION = 8;


	/** @var array */
	private $operations = array(
		'add',
		'subtract',
		'multiply',
		'divide',
	);


	private $adapter;

	private $comparator;


	public function __construct($adapter = NULL, IComparator $comparator = NULL)
	{
		$this->adapter = $adapter === NULL || is_numeric($adapter) ? $this->createAdapter($adapter ?: self::DEFAULT_PRECISION) : $adapter;
		if ($comparator === NULL && !$this->adapter instanceof IComparator) {
			throw new \InvalidArgumentException('Please provide valid comparator.');
		}
		$this->comparator = $comparator === NULL ? $this->adapter : $comparator;
	}


	public function __call($name, $arguments)
	{
		if (in_array($name, $this->operations, TRUE)) {
			return $this->convertToResult(call_user_func_array(array($this->adapter, $name), $this->convertArguments($arguments)));

		} else {
			return parent::__call($name, $arguments);
		}
	}


	protected function convertToResult($value)
	{
		return $this->adapter->unpack($value);
	}


	protected function convertArguments($arguments)
	{
		$converted = array();
		foreach ($arguments as $argument) {
			if ($argument instanceof Money) {
				$argument = $argument->toDecimal();
			}
			$converted[] = $this->adapter->pack($argument);
		}
		return $converted;
	}


	private function createAdapter($precision)
	{
		if (extension_loaded('bcmath')) {
			return new Adapters\BcMathAdapter($precision);

		} else {
			throw new RuntimeException("BcMath extension must be enabled.");
		}
	}

}
