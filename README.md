# FormBuilder
A helper to abstract the work with Forms with Bootstrap support.
![Easy Generate Beautyfull Forms like this](https://raw.githubusercontent.com/NewtonMan/FormBuilder/master/examples/screenshot2.png)
![Need hurry? generate simple Forms like this](https://raw.githubusercontent.com/NewtonMan/FormBuilder/master/examples/screenshot1.png)
[Let me see some example of use](examples/form.php)

# Documentation
This maintain a clear syntax that we will be detailled here, after instanciate FormBuilder.

## Complete Example
```
// instance FormBuilder as $form
$userForm = new Form('user');
// open form
echo $userForm->open();
// wrap fields inside fieldset
echo $userForm->fieldset(
    'FormBuilder Example', // legend of the fieldset
    // after the first arg every arg is concat to fieldset body
    $userForm->row( // show a form row to grid field as colums, each col is an arg
        $userForm->input('name', ['required' => true, 'col' => 'md-6', 'prepend-icon' => 'fa fa-user', 'help-text' => 'Please type your Name']),
        $userForm->input('email', ['type' => 'email', 'col' => 'md-6', 'prepend-icon' => 'fa fa-envelope', 'required' => true, 'help-text' => 'Please type your Email Address'])
    ),
    $userForm->row(
        $userForm->input('password', ['type' => 'password', 'col' => 'md-6', 'prepend-icon' => 'fa fa-lock', 'required' => true, 'help-text' => 'Please type your Password']),
        $userForm->input('level', ['type' => 'select', 'col' => 'md-6', 'prepend-icon' => 'fa fa-arrow-up', 'required' => true, 'help-text' => 'Please select your Level', 'empty' => ' - chose one - ', 'options' => ['Junior', 'Pleno', 'Senior']])
    ),
    $userForm->input('gender', ['type' => 'radio', 'required' => true, 'help-text' => 'Please chose your Gender', 'options' => ['Male', 'Female']]),
    $userForm->input('resume', ['type' => 'textarea', 'required' => true, 'help-text' => 'Please type a resume about you']),
    $userForm->submit('Save') // this is a submit / success button
);
// close form tag
echo $userForm->close();
```
## FormBuilder\Form Detailed Options
```
$name = 'user';
echo $userForm->open($name, $options);
```
| Form Option | Description | Default Value |
| --- | --- | --- |
| `action` | URL submit the form data | `$_SERVER['REQUEST_URI']` |
| `class` | Custom CSS classes to apply to Form tag | `needs-validation` |
| `charset` | The charset of the form | `utf-8` |
| `method` | Form method | `POST` |
| `type` | Type can be `normal` or `file`, when `file` supports upload | `normal` |

## FormBuilder\Field Detailed Options
```
echo $userForm->input($name, $options);
```
| Field Option | Description | Default Value |
| --- | --- | --- |
| `type` | What input type shall apply to inputs? `text`,`password`,`url`,`number`,`email`,`textarea`,`checkbox`,`radio`,`select` | `string` |
| `label` | Text to label a field, `string` or `false` to hide label | `string` |
| `col` | Class for grid forms, ex: `md-6` will produce a class `col-md-6` | `string` |
| `class` | Custom CSS classes to apply to input tag | `string` |
| `value` | Value or default value to apply to a field | `$_POST[formdata][form->name][field->name]` or `$_GET[formdata][form->name][field->name]` |
| `required` | Tell if the input is required, `true` or `false` | `true` or `false` |
| `prepend-text` | Text to place as input-group before field | `string` |
| `append-text` | Text to place as input-group after field | `string` |
| `prepend-icon` | Icon class to input-group before field | `string` |
| `append-icon` | Icon class to input-group after field | `string` |
| `help-text` | Text to instruct the user | `string` |
| `valid-feedback` | Feedback text to inform | `string` |
| `invalid-feedback` | Feedback text to inform | `string` |
| `options` | Array to populate `select` with `option`, `checkbox` or `radio` | `array[]` |
| `empty` | If you need a first empty `option` or false to hide | `string` |

## TODO
 - [x] Form as Grid
 - [x] Field Prepend/Append Text/Icon
 - [x] Field Help Text
 - [x] Abstract Form Data
 - [x] Basic Validation, Invalid/Valid Text
 - [ ] Integrate to DataGrid Component to provide automatic CRUD
 - [ ] Server-side Validation
 - [ ] VueJS Validation