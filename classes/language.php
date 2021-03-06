<?php
class language
{
	public static $dir;

	public static function exists($lang)
	{
		return file_exists(self::$dir . $lang . '.php');
	}

	private $t;

	public function __construct($lang)
	{
		require self::$dir . $lang . '.php';
	}

	public function load($page)
	{
		$t = [];
		lang($t);

		$method = 'lang_' . str_replace('/', '_', $page);
		if (is_callable($method))
		{
			$method($t);
		}

		$this->t = $t;
	}

	public function translate($tpl)
	{
		foreach ($this->t as $key => $value)
		{
			$tpl->$key = $value;
		}
	}
}
?>