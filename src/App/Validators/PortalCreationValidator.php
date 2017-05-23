<?php
namespace App\Validators;

use Respect\Validation\Validator as V;

class PortalCreationValidator
{
	/**
	 * List of constraints
	 *
	 * @var array
	 */
	protected $rules = [];

	/**
	 * List of customized messages
	 *
	 * @var array
	 */
	protected $messages = [];

	/**
	 * List of returned errors in case of a failing assertion
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Just another constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->initRules();
		$this->initMessages();
	}

	/**
	 * Set the user subscription constraints
	 *
	 * @return void
	 */
	public function initRules()
	{
//		$dateFormat = 'd-m-Y';
//		$now = (new \DateTime())->format($dateFormat);
//		$tenYears = (new \DateTime('+10 years'))->format($dateFormat);

		$this->rules[ 'portal_code' ] = V::alnum('_')->noWhitespace()->length(1, 30)->setName('PortalCode');
		$this->rules[ 'portal_name' ] = V::alnum('_')->noWhitespace()->length(1, 40)->setName('PortalName');
		$this->rules[ 'root_directory' ] = V::alnum('_')->noWhitespace()->length(1, 40)->setName('RootDirectory');

	}

	/**
	 * Set portal custom error messages
	 *
	 * @return void
	 */
	public function initMessages()
	{
		$this->messages = [
			'alpha'        => '{{name}} must only contain alphabetic characters.',
			'alnum'        => '{{name}} must only contain alpha numeric characters and dashes.',
			'numeric'      => '{{name}} must only contain numeric characters.',
			'noWhitespace' => '{{name}} must not contain white spaces.',
			'length'       => '{{name}} must be of length between {{minValue}} and {{maxValue}}.',
			'date'         => 'Make sure you typed a valid date for the {{name}} ({{format}}).'
		];
	}

	/**
	 * Assert validation rules.
	 *
	 * @param array $inputs
	 *   The inputs to validate.
	 * @return boolean
	 *   True on success; otherwise, false.
	 */
	public function assert(array $inputs)
	{
		foreach ($this->rules as $rule => $validator) {
			try {
				$validator->assert($rule);
			}
			catch (\Respect\Validation\Exceptions\NestedValidationException $ex) {
				$this->errors = $ex->findMessages($this->messages);

				return false;
			}
		}

		return true;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getErrorsConcat()
	{
		$returnValue = '';
		foreach ($this->errors as $key => $value) {
			if (empty($value)) {

			}
			else {
				$returnValue .= $value . ' ';
			}
		}

		return $returnValue;
	}
}