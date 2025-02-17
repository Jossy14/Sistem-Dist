<?php
/**
 * @package ActiveRecord
 */
namespace ActiveRecord;
use XmlWriter;

/**
 * Base class for Model serializers.
 *
 * All serializers support the following options:
 *
 * <ul>
 * <li><b>only:</b> a string or array of attributes to be included.</li>
 * <li><b>exclude:</b> a string or array of attributes to be excluded.</li>
 * <li><b>methods:</b> a string or array of methods to invoke. The method's name will be used as a key for the final attributes array
 * along with the method's returned value</li>
 * <li><b>include:</b> a string or array of associated models to include in the final serialized product.</li>
 * <li><b>skip_instruct:</b> set to true to skip the <?xml ...?> declaration.</li>
 * </ul>
 *
 * Example usage:
 *
 * <code>
 * # include the attributes id and name
 * # run $model->encoded_descripcion() and include its return value
 * # include the comments association
 * # include posts association with its own options (nested)
 * $model->to_json(array(
 *   'only' => array('id','name', 'encoded_descripcion'),
 *   'methods' => array('encoded_descripcion'),
 *   'include' => array('comments', 'posts' => array('only' => 'id'))
 * ));
 *
 * # exclude the password field from being included
 * $model->to_xml(array('exclude' => 'password')));
 * </code>
 *
 * @package ActiveRecord
 * @link http://www.phpactiverecord.org/guides/utilities#topic-serialization
 */
abstract class Serialization
{
	protected $model;
	protected $options;
	protected $attributes;

	/**
	 * Set this to true if the serializer needs to create a nested array keyed
	 * on the name of the included classes such as for xml serialization.
	 *
	 * Setting this to true will produce the following attributes array when
	 * the include option was used:
	 *
	 * <code>
	 * $user = array('id' => 1, 'name' => 'Tito',
	 *   'permissions' => array(
	 *     'permission' => array(
	 *       array('id' => 100, 'name' => 'admin'),
	 *       array('id' => 101, 'name' => 'normal')
	 *     )
	 *   )
	 * );
	 * </code>
	 *
	 * Setting to false will produce this:
	 *
	 * <code>
	 * $user = array('id' => 1, 'name' => 'Tito',
	 *   'permissions' => array(
	 *     array('id' => 100, 'name' => 'admin'),
	 *     array('id' => 101, 'name' => 'normal')
	 *   )
	 * );
	 * </code>
	 *
	 * @var boolean
	 */
	protected $includes_with_class_name_element = false;

	/**
	 * Constructs a {@link Serialization} object.
	 *
	 * @param Model $model The model to serialize
	 * @param array &$options Options for serialization
	 * @return Serialization
	 */
	public function __construct(Model $model, &$options)
	{
		$this->model = $model;
		$this->options = $options;
		$this->attributes = $model->attributes();
		$this->parse_options();
	}

	private function parse_options()
	{
		$this->check_only();
		$this->check_except();
		$this->check_methods();
		$this->check_include();
	}

	private function check_only()
	{
		if (isset($this->options['only']))
		{
			$this->options_to_a('only');

			$exclude = array_diff(array_keys($this->attributes),$this->options['only']);
			$this->attributes = array_diff_key($this->attributes,array_flip($exclude));
		}
	}

	private function check_except()
	{
		if (isset($this->options['except']) && !isset($this->options['only']))
		{
			$this->options_to_a('except');
			$this->attributes = array_diff_key($this->attributes,array_flip($this->options['except']));
		}
	}

	private function check_methods()
	{
		if (isset($this->options['methods']))
		{
			$this->options_to_a('methods');

			foreach ($this->options['methods'] as $method)
			{
				if (method_exists($this->model, $method))
					$this->attributes[$method] = $this->model->$method();
			}
		}
	}

	private function check_include()
	{
		if (isset($this->options['include']))
		{
			$this->options_to_a('include');

			$serializer_class = get_class($this);

			foreach ($this->options['include'] as $association => $options)
			{
				if (!is_array($options))
				{
					$association = $options;
					$options = array();
				}

				try {
					$assoc = $this->model->$association;

					if (!is_array($assoc))
					{
						$serialized = new $serializer_class($assoc, $options);
						$this->attributes[$association] = $serialized->to_a();;
					}
					else
					{
						$includes = array();

						foreach ($assoc as $a)
						{
							$serialized = new $serializer_class($a, $options);

							if ($this->includes_with_class_name_element)
								$includes[strtolower(get_class($a))][] = $serialized->to_a();
							else
								$includes[] = $serialized->to_a();
						}

						$this->attributes[$association] = $includes;
					}

				} catch (UndefinedPropertyException $e) {
					;//move along
				}
			}
		}
	}

	final protected function options_to_a($key)
	{
		if (!is_array($this->options[$key]))
			$this->options[$key] = array($this->options[$key]);
	}

	/**
	 * Returns the attributes array.
	 * @return array
	 */
	final public function to_a()
	{
		$date_format = Config::instance()->get_date_format();

		foreach ($this->attributes as &$value)
		{
			if ($value instanceof \DateTime)
				$value = $value->format($date_format);
		}
		return $this->attributes;
	}

	/**
	 * Returns the serialized object as a string.
	 * @see to_s
	 * @return string
	 */
	final public function __toString()
	{
		return $this->to_s();
	}

	/**
	 * Performs the serialization.
	 * @return string
	 */
	abstract public function to_s();
};

/**
 * JSON serializer.
 *
 * @package ActiveRecord
 */
class JsonSerializer extends Serialization
{
	public static $include_root = false;

	public function to_s()
	{
		return json_encode(self::$include_root ? array(strtolower(get_class($this->model)) => $this->to_a()) : $this->to_a());
	}
}

/**
 * XML serializer.
 *
 * @package ActiveRecord
 */
class XmlSerializer extends Serialization
{
	private $writer;

	public function __construct(Model $model, &$options)
	{
		$this->includes_with_class_name_element = true;
		parent::__construct($model,$options);
	}

	public function to_s()
	{
		return $this->xml_encode();
	}

	private function xml_encode()
	{
		$this->writer = new XmlWriter();
		$this->writer->openMemory();
		$this->writer->startDocument('1.0', 'UTF-8');
		$this->writer->startElement(strtolower(denamespace(($this->model))));
		$this->write($this->to_a());
		$this->writer->endElement();
		$this->writer->endDocument();
		$xml = $this->writer->outputMemory(true);

		if (@$this->options['skip_instruct'] == true)
			$xml = preg_replace('/<\?xml version.*?\?>/','',$xml);

		return $xml;
	}

	private function write($data, $tag=null)
	{
		foreach ($data as $attr => $value)
		{
			if ($tag != null)
				$attr = $tag;

			if (is_array($value) || is_object($value))
			{
				if (!is_int(key($value)))
				{
					$this->writer->startElement($attr);
					$this->write($value);
					$this->writer->endElement();
				}
				else
					$this->write($value, $attr);

				continue;
			}

			$this->writer->writeElement($attr, $value);
		}
	}
}
?>
