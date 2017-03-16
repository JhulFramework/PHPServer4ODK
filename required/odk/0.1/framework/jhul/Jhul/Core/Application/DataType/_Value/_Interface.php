<?php namespace Jhul\Core\Application\DataType\_Value;

interface _Interface
{
	function error();
	function value(); //retirs filetere value
	function __toString();
	function isValid();
	function type(); //returns data type
}
