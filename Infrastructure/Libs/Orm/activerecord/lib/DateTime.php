<?php
namespace ActiveRecord;

class DateTime extends \DateTime
{
	private $model;
	private $attribute_name;

	public function attribute_of($model, $attribute_name)
	{
		$this->model = $model;
		$this->attribute_name = $attribute_name;
	}

	private function flag_dirty()
	{
		if ($this->model)
			$this->model->flag_dirty($this->attribute_name);
	}

	#[\ReturnTypeWillChange]
	public function setDate($year, $month, $day)
	{
		$this->flag_dirty();
		call_user_func_array(array($this,'parent::setDate'),func_get_args());
	}

	#[\ReturnTypeWillChange]
	public function setISODate($year, $week , $day=null)
	{
		$this->flag_dirty();
		call_user_func_array(array($this,'parent::setISODate'),func_get_args());
	}

	#[\ReturnTypeWillChange]
	public function setTime(int $hour, int $minute, int $second = 0, int $microsecond = 0)
	{
		$this->flag_dirty();
		// Llama al método padre con los parámetros actualizados
		parent::setTime($hour, $minute, $second, $microsecond);
	}

	#[\ReturnTypeWillChange]
	public function setTimestamp($unixtimestamp)
	{
		$this->flag_dirty();
		call_user_func_array(array($this,'parent::setTimestamp'),func_get_args());
	}
}
?>