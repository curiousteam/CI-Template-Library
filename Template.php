<?php if ( ! defined('BASEPATH')) exit('No direct script acccess allowed');

/**
 * Template Class
 *
 * This class enables the use of templates with your views. 
 *
 * Use $this->Template->render instead
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Libraries
 * @author 		Cleiver C. Carneiro
 * @version		1.0.0
 * @link 		https://github.com/cleiver
 */
class Template
{
	/**
	 * CodeIgniter instance
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Template to use when rendering the views
	 *
	 * @var string
	 */
	private $template;



	public function __construct()
	{
		$this->CI =& get_instance();
		$this->use('default');
	}


	public function use($template)
	{
		$this->template = 'templates/' . $template;
	}


	/**
	 * Renders the view inside the template
	 *
	 * @param 	array	$views			Views to render into the template
	 * @param 	array 	$data 			Dynamic data to show in the views
	 * @param 	boolean	$return_data	Whether the data will be returned or rendered
	 * @return 	string 					HTML content of the view
	 */
	public function render($views = array(), $data = array(), $return_data = FALSE)
	{
		if ( ! is_array($views))
		{
			$views = array($views);
		}

		$template = $this->get_file($this->template);

		$main_content = '';
		foreach ($views as $view) 
		{
			$view = $this->get_file($view);

			$main_content .= $this->CI->load->view($view, $data, TRUE);
		}

		$data['view_content_block'] = $main_content;

		return $this->CI->load->view($template, $data, $return_data);
	}


	/**
	 * Return the file name to be rendered
	 *
	 * @param 	string 	$filename 	File name
	 * @return 	string 				File name
	 */
	private function get_file($filename)
	{
		if (file_exists(APPPATH.'/views/'.$filename.'.php'))
		{
			return $filename.'.php';
		}
		elseif (file_exists(APPPATH.'/views/'.$filename.'.tpl'))
		{
			return $filename.'.tpl';
		}
		else
		{
			return $filename;
		}
	}
}