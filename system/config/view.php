<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
class View
{
    private $pageVars = array();
    private $template;

    public function __construct($template)
    {
        $this->template = APPS_DIR . 'views/' . $template . '.php';
    }

    public function set($var, $val)
    {
        $this->pageVars[$var] = $val;
    }

	/*protected function object_to_array($object)
	{
		return is_object($object) ? get_object_vars($object) : $object;
	}*/
	
    public function render()
    {
        extract($this->pageVars);
        ob_start();
        require($this->template);
        echo ob_get_clean();
    }

}
