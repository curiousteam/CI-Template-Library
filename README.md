# CodeIgniter Template Library

I think it's odd that a framework as big as CodeIgniter doesn't have a native way of working with templates, but I'm sure they have their reasons. That's why I decided to implement my version of a class to do it.

Right now it has only the methods I need and find usefull, I'll increment it as needed in the future.

### How to use

Copy the file into your `application/libraries` folder

Then load it in your controller:
```
$this->load->library('Template');
```
Or load it automatically at `autoload.php`:
```
$autoload['libraries'] = array('Template');
```

Your template files must be at `application/views/templates` folder.

You can set your template by calling the `use` method:
```
$this->template->use('template_name');
```
By default, the class will look for a `default.tpl` or `default.php`.

At the end of your controller methods just call the method `render` the same way you would do with the default CodeIgniter `$this->load->view` method, including it's parameters.
```
$this->template->render('view_file'[,$data,$return_view]);
```
:metal:
