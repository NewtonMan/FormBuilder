<?php
namespace FormBuilder;

class Form {
    
    public $name = null;
    
    public $type = null; // normal || file
    
    public $charset = null;
    
    public $action = null;
    
    public $options = [];
    
    public $data = [];
    
    private $fields = [];
    
    public function __construct($name, $options=[]) {
        $this->options = array_merge([
            'action' => $_SERVER['REQUEST_URI'],
            'class' => ($this->type == 'inline' ? 'form-inline':null),
            'charset' => 'utf-8',
            'method' => 'post',
            'type' => 'normal',
            'name' => $name,
            'id' => $name,
        ], $options);
        if ($this->options['type']=='file') {
            $this->options['enctype'] = 'multipart/form-data';
        }
        if ($this->options['method']=='post') {
            $this->data = (isset($_POST['formdata']) ? $_POST['formdata'][$name]:[]);
        } elseif ($this->options['method']=='get') {
            $this->data = (isset($_GET['formdata']) ? $_GET['formdata'][$name]:[]);
        }
        $this->name = $name;
        $this->type = $this->options['type'];
        $this->action = $this->options['action'];
        $this->charset = $this->options['charset'];
    }
    
    public function open(){
        $sEvents = [];
        $hiddenAttribute = ['type', 'action', 'method', 'name', 'charset'];
        foreach ($this->options as $e => $v){
            if (in_array($e, $hiddenAttribute) || is_null($v)) continue;
            $sEvents[] = "{$e}=\"{$v}\"";
        }
        $sEvents = ' '. implode(' ', $sEvents);
        return "<form action=\"" . $this->options['action'] . "\" method=\"" . $this->options['method'] . "\" name=\"" . $this->options['name'] . "\" accept-charset=\"" . $this->options['charset'] . "\"{$sEvents}>";
    }
    
    public function row(){
        return '<div class="form-row">' . implode('', func_get_args()) . '</div>';
    }
    
    public function submit($value, $options=[]){
        $sAtributes = [];
        foreach ($options as $k => $v){
            if ($k=='class') continue;
            $sAtributes[] = "{$k}=\"{$v}\"";
        }
        return "<button type=\"submit\" class=\"btn btn-success" . (isset($options['class']) ? " {$options['class']}":'') . "\"" . implode(' ', $sAtributes) . ">{$value}</button>";
    }
    
    public function reset($value, $options=[]){
        $sAtributes = [];
        foreach ($options as $k => $v){
            if ($k=='class') continue;
            $sAtributes[] = "{$k}=\"{$v}\"";
        }
        return "<button type=\"reset\" class=\"btn btn-default" . (isset($options['class']) ? " {$options['class']}":'') . "\"" . implode(' ', $sAtributes) . ">{$value}</button>";
    }
    
    public function button($value, $options=[]){
        $sAtributes = [];
        foreach ($options as $k => $v){
            if ($k=='type') continue;
            $sAtributes[] = "{$k}=\"{$v}\"";
        }
        return "<button type=\"button\"" . implode(' ', $sAtributes) . ">{$value}</button>";
    }
    
    public function fieldset(){
        $title = '';
        $body = [];
        foreach (func_get_args() as $field => $value){
            if ($field==0){
                $title = $value;
            } else {
                $body[] = $value;
            }
        }
        return "<fieldset>"
                . "<legend>{$title}</legend>"
                . implode('', $body)
                . "</fieldset>";
    }
    
    public function close(){
        return '</form>';
    }
    
    public function input($name, $options=[]){
        $field = new Field($this, $name, $options);
        return $field->render();
    }
    
}