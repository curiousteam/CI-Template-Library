<p align="center"><img src="http://www.cleiver.com/github/GitHub-CodeIgniter-Template-Library.png" alt="CodeIgniter Template Library" /></p>

I think it's odd that a framework as big as CodeIgniter doesn't have a native way of working with templates, but I'm sure they have their reasons. That's why I decided to implement my version of a class to do it. :sweat_smile:

Right now it has only the methods I need and find usefull, I'll increment it as needed in the future.

# How to use
Copy the file into your `application/libraries` folder and then load it in your controller:
```
$this->load->library('Template');
```
Or load it automatically at `autoload.php`:
```
$autoload['libraries'] = array('Template');
```

Your template files must be at `application/views/templates` folder.

You can set your template by calling the `set` method:
```
$this->template->set('template_name');
```

By default, the class will look for a `default.tpl` or `default.php` file.

In your controller methods you just have to call the method `render` the same way you would do with CodeIgniter's  `$this->load->view()` method, including it's parameters.
```
$this->template->render('view_file'[, $data, $return_view]);
```

And in your template file you print the variable `$view_content_block` where you want the pages to be loaded into.

# Additional features
You can create `<link>` tags to other CSS files, `<style>` tag in a specific page and `<script>` tags dinamically with this library. To do it, just insert the relative template variables and call the specific methods as follows:

### CSS files

|Template|Controller|
|---|---|
|`$template_css_files`|`$this->template->set_css_file('one_file')`<br />`$this->template->set_css_file(array('one_file','css/another_file'))`|

This method expects a string or an array of filenames. The path should be relative to your application root URL. The result will be:
```
<link href="http://www.yoursite.com/one_file.css" rel="stylesheet" type="text/css" />
<link href="http://www.yoursite.com/css/another_file.css" rel="stylesheet" type="text/css" />
```

### CSS inline style

|Template|Controller|
|---|---|
|`$template_css_style`|```$this->template->set_css_style(array('body'=>array('color'=>'#FFF','background'=>'#000')))```|

This will create a `<style>` tag as follows:
```
<style>
body {
  color: #FFF;
  background: #000;
}
</style>
```

### Javascript files

|Template|Controller|
|---|---|
|`$template_js_files`|`$this->template->set_js_file('one_file')`<br />`$this->template->set_js_file(array('one_file','another_file'))`|

This works just like the CSS method. The return will be:
```
<script src="http://www.yoursite.com/one_file.js" type="text/javascript"></script>
```

### Javascript inline code

|Template|Controller|
|---|---|
|`$template_js_code`|```$this->template->set_js_code('alert(\'Hello, world!\');')```|

It will create a `<script>` tag like this:
```
<script type="text/javascript">
alert('Hello, world!');
</script>
```

# The future
- [ ] Refactor the CSS method so we can use internal or external files (CDN, for exemple).
- [ ] The same with the javascript method :v:
- [ ] Organize the class file for better reading  
- [ ] Maybe some example files :thought_balloon:
