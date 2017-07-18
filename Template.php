<?php if ( ! defined('BASEPATH')) exit('No direct script acccess allowed');
/**
 * Template Class
 *
 * This class enables the use of templates with your views. 
 *
 * Use $this->Template->render instead
 *
 * @TODO: check if the CSS and JS files are local files or URLs
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

	/**
	 * CSS files to load into the template
	 *
	 * @var array
	 */
	private $css_files;

	/**
	 * CSS style to insert into the template
	 *
	 * @var array
	 */
	private $css_styles;

	/**
	 * Javascript files to load with the template
	 *
	 * @var array
	 */
	private $js_files;

	/**
	 * Javascript code to insert into the template
	 *
	 * @var array
	 */
	private $js_code;



	public function __construct()
	{
		$this->CI =& get_instance();
		$this->set('default');
	}


	/**
	 * Define the template to be used when rendering the view
	 *
	 * @param 	string 	$template 	Template name
	 * @return 	void
	 */
	public function set($template)
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
		$data['template_css_files'] = $this->get_css_files();
		$data['template_css_styles'] = $this->get_css_styles();
		$data['template_js_files'] = $this->get_js_files();
		$data['template_js_code'] = $this->get_js_code();

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


	/**
	 * Set CSS files to be loaded on the fly to the template
	 *
	 * @param 	string|array 	$css_file 	One or more CSS files to load
	 * @return 	void
	 */
	public function set_css_file($css_file)
	{
		if ( ! is_array($css_file))
		{
			$css_file = array($css_file);
		}

		foreach ($css_file as $css)
		{
			$this->css_files[] = $css . '.css';
		}
	}


	/**
	 * Return <link> tags for each defined CSS file
	 *
	 * @return 	string 	<link> tags if any CSS file loaded or nothing if empty
	 */
	private function get_css_files()
	{
		if (count($this->css_files) > 0)
		{
			$tag = '';
			foreach ($this->css_files as $file)
			{
				$tag .= '<link href="'. site_url($file) .'" rel="stylesheet" type="text/css" />'."\n";
			}
			return $tag;
		}
		return null;
	}


	/**
	 * Define CSS style to be put into the <style> tag
	 *
	 * @param 	array 	$css_style 	Array with elements and it's styles formated
	 *								as ['element' => ['atribute' => 'value']}
	 * @return 	void
	 */
	public function set_css_style($css_style)
	{
		foreach($css_style as $element => $styles)
		{
			$this->css_styles[$element] = $styles;
		}
	}


	/**
	 * Return a <style> tag with the elements defined
	 *
	 * @return 	string 	<style> tag with the defined elements or nothing if empty
	 */
	private function get_css_styles()
	{
		if (count($this->css_styles) > 0)
		{
			$tag = '<style>'."\n";
			
			foreach($this->css_styles as $element => $styles)
			{
				$tag .= $element . " {\n";
				foreach($styles as $key => $value)
				{
					$tag .= "\t" . $key . ": " . $value . ";\n";
				}
				$tag .= "}\n";
			}

			return $tag . "</style>\n";
		}
		return null;
	}


	/**
	 * Set javascript files to be loaded on the fly with the template
	 *
	 * @param 	string|array 	$js_file 	One or more javascript files to load
	 * @return 	void
	 */
	public function set_js_file($js_file)
	{
		if ( ! is_array($js_file))
		{
			$js_file = array($js_file);
		}

		foreach ($js_file as $js)
		{
			$this->js_files[] = $js . '.js';
		}
	}


	/**
	 * Return <script> tags for each defined javascript file
	 *
	 * @return 	string 	<script> tags if any jsvascript file loaded or nothing if empty
	 */
	private function get_js_files()
	{
		if (count($this->js_files) > 0)
		{
			$tag = '';
			foreach ($this->js_files as $file)
			{
				$tag .= '<script src="'. site_url($file) .'" type="text/javascript"></script>'."\n";
			}
			return $tag;
		}
		return null;
	}


	/**
	 * Define javascript code to be put into the <script> tag
	 *
	 * @param 	string 	$js_code 	Javascript codes to be inserted into the <script> tag
	 * @return 	void
	 */
	public function set_js_code($js_code)
	{
		$this->js_code[] = $js_code;
	}


	/**
	 * Return a <script> tag with the codes defined
	 *
	 * @return 	string 	<script> tag with the defined codes or nothing if empty
	 */
	private function get_js_code()
	{
		if (count($this->js_code) > 0)
		{
			$tag = '<script type="text/javascript">'."\n";
			
			foreach($this->js_code as $js)
			{
				$tag .= $js . "\n";
			}

			return $tag . "</script>\n";
		}
		return null;
	}
 }
