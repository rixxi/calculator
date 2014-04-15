<?php

namespace Rixxi\Calculator;


interface IAdapter // IArithmeticAdapter
{

	/**
	 * @param mixed
	 * @param mixed
	 * @return mixed
	 */
	function add($a, $b);

	/**
	 * @param mixed
	 * @param mixed
	 * @return mixed
	 */
	function divide($a, $b);

	/**
	 * @param mixed
	 * @param mixed
	 * @return mixed
	 */
	function subtract($a, $b);

	/**
	 * @param mixed
	 * @param mixed
	 * @return mixed
	 */
	function multiply($a, $b);

	/**
	 * Converts value to internal representation used for computations
	 * @param float|string|int
	 * @return mixed
	 * @throws \Kdyby\Money\InvalidArgumentException
	 */
	function pack($value);

	/**
	 * Converts value from internal representation to scalar value
	 * @return float|string|int
	 * @throws \Kdyby\Money\InvalidArgumentException
	 */
	function unpack($value);

}
