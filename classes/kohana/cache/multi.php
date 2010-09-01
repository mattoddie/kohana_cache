<?php

class Kohana_Cache_Multi
{
	/**
	 * @var  string
	 */
	protected $_default = NULL;

	/**
	 * @var  Kohana_Config
	 */
	protected $_config;

	/**
	 * Ensures singleton pattern is observed, loads the default expiry
	 * 
	 * @param  array     configuration
	 */
	public function __construct(array $config)
	{
		$this->_config = $config;
	}

	/**
	 * Overload the __clone() method to prevent cloning
	 *
	 * @return  void
	 * @throws  Kohana_Cache_Exception
	 */
	public function __clone()
	{
		throw new Kohana_Cache_Exception('Cloning of Kohana_Cache objects is forbidden');
	}

	/**
	 * Attempt call on all instances.
	 * If performing a "get" action stop at first success.
	 * 
	 * @param  string    function
	 * @param  array     arguments
	 */
	public function __call($function, array $arguments)
	{
		$last_exception = NULL; // store last exception
		$success = FALSE;

		// check for get/find call and change success to default value
		if ($getter = (bool) preg_match('#^(get|find)#', $function))
		{
			$success = $this->_default = Arr::get($arguments, 'default', $this->_default);
		}

		// loop over instances
		foreach($this->_config['instances'] AS $c)
		{
			try
			{
				$i = Cache::instance($c);
				if ($getter)
				{
					// if get/find call and we've not got a default, store response and stop processing
					if ($this->_default !== ($v = call_user_func_array(array($i, $function), $arguments)))
					{
						$success = $v;
						break;
					}
				}
				else
				{
					// set/delete, so just call on instance
					call_user_func_array(array($i, $function), $arguments);
					$success = TRUE;					
				}
			}
			catch (Kohana_Cache_Exception $e)
			{
				// store last exception
				$last_exception = $e;
			}
		}

		// if the call wasn't successful, but no exceptions occured, return default
		if ( ! $success && NULL !== $last_exception)
		{
			return $this->_default;
		}

		// return value for get/find, otherwise self
		return ($getter) ? $success : $this;
	}
}