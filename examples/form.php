<?php
require_once '../src/FormBuilder/Form.php';
require_once '../src/FormBuilder/Field.php';

use FormBuilder\Form;
use FormBuilder\Field;
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        
        <!-- Font Awesome 4.7.0 -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <title>Hello, world!</title>
    </head>
    <body>
        <div class="container">
            <?php
            $userForm = new Form('user');
            echo $userForm->open();
            echo $userForm->fieldset(
                'FormBuilder Example',
                $userForm->row(
                    $userForm->input('name', ['required' => true, 'col' => 'md-6', 'prepend-icon' => 'fa fa-user', 'help-text' => 'Please type your Name']),
                    $userForm->input('email', ['type' => 'email', 'col' => 'md-6', 'prepend-icon' => 'fa fa-envelope', 'required' => true, 'help-text' => 'Please type your Email Address'])
                ),
                $userForm->row(
                    $userForm->input('password', ['type' => 'password', 'col' => 'md-6', 'prepend-icon' => 'fa fa-lock', 'required' => true, 'help-text' => 'Please type your Password']),
                    $userForm->input('level', ['type' => 'select', 'col' => 'md-6', 'prepend-icon' => 'fa fa-arrow-up', 'required' => true, 'help-text' => 'Please select your Level', 'empty' => ' - chose one - ', 'options' => ['Junior', 'Pleno', 'Senior']])
                ),
                $userForm->input('gender', ['type' => 'radio', 'required' => true, 'help-text' => 'Please chose your Gender', 'options' => ['Male', 'Female']]),
                $userForm->input('resume', ['type' => 'textarea', 'required' => true, 'help-text' => 'Please type a resume about you']),
                $userForm->submit('Save')
            );
            echo $userForm->close();
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        </script>
    </body>
</html>