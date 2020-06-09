<?php
namespace FormBuilder;

class Field {
    
    private $name = null;
    
    private $label = null;
    
    private $type = null;
    
    public $data = [];
    
    private $options = [];
    
    public function __construct($form, $name, $options=[]) {
        $this->name = $name;
        $this->data = $form->data;
        if (!isset($options['type'])) $options['type'] = 'text';
        if (!isset($options['label'])) $options['label'] = ucfirst(strtolower($name));
        if (!isset($options['name'])) $options['name'] = "formdata[{$form->name}][{$name}]";
        if (!isset($options['required'])) $options['required'] = false;
        if ($options['required'] && !isset($options['invalid-feedback'])) {
            $options['invalid-feedback'] = 'This is a required field.';
        }
        if (isset($options['prepend-icon'])) {
            $options['prepend-text'] = "<i class=\"{$options['prepend-icon']}\"></i>";
        }
        if (isset($options['append-icon'])) {
            $options['append-text'] = "<i class=\"{$options['append-icon']}\"></i>";
        }
        if (strtolower($options['type'])=='text' || strtolower($options['type'])=='textarea' || strtolower($options['type'])=='url' || strtolower($options['type'])=='number' || strtolower($options['type'])=='password' || strtolower($options['type'])=='email' || strtolower($options['type'])=='file'){
            $this->options = array_merge([
                'class' => 'form-control' . (!empty($options['form-control-size']) ? " form-control-{$options['form-control-size']}":''),
                'value' => (isset($this->data[$name]) ? $this->data[$name]:null),
                'id' => $form->name . $name,
            ], $options);
        } elseif (strtolower($options['type'])=='select' || strtolower($options['type'])=='radio' || strtolower($options['type'])=='checkbox'){
            if (!isset($options['selected'])) $options['selected'] = false;
            if (!isset($options['checked'])) $options['checked'] = false;
            $this->options = array_merge([
                'class' => 'form-control' . (!empty($options['form-control-size']) ? " form-control-{$options['form-control-size']}":''),
                'selected' => (isset($form->data[$name]) ? $form->data[$name]:null),
                'id' => $form->name . $name,
                'empty' => '',
                'options' => [],
            ], $options);
        }
        
        $this->name = $name;
        $this->label = $options['label'];
        $this->type = $options['type'];
    }
    
    public function getLabel(){
        return "<label for=\"{$this->options['id']}\">{$this->label}</label>";
    }
    
    public function render(){
        $iAttributes = ['label', 'inline', 'col', 'empty', 'options', 'required', 'form-control-size', 'help-text', 'valid-feedback', 'invalid-feedback', 'prepend-text', 'prepend-icon', 'append-text', 'append-icon'];
        switch ($this->options['type']) {
            case 'hidden':
                return "<input type=\"hidden\" name=\"{$this->options['name']}\" value=\"{$this->options['value']}\">";
                break;

            case 'text':
            case 'email':
            case 'password':
            case 'url':
            case 'number':
            case 'file':
                $sAtributes = [];
                foreach ($this->options as $k => $v) {
                    if (in_array($k, $iAttributes)) continue;
                    $sAtributes[] = "{$k}=\"{$v}\"";
                }
                if ($this->options['required']) $sAtributes[] = "required";
                return '<div class="form-group' . 
                        (isset($this->options['col']) ? " col-{$this->options['col']}":'') . '">' . $this->getLabel() . 
                        (!empty($this->options['prepend-text']) ? "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\" id=\"{$this->options['id']}PrependText\">{$this->options['prepend-text']}</span></div>":'') .
                        (!empty($this->options['append-text']) ? "<div class=\"input-group\">":'') .
                        '<input ' . implode(' ', $sAtributes) . '>' . 
                        (!empty($this->options['prepend-text']) ? "</div>":'') .
                        (!empty($this->options['append-text']) ? "<div class=\"input-group-append\"><span class=\"input-group-text\" id=\"{$this->options['id']}AppendText\">{$this->options['append-text']}</span></div></div>":'') .
                        (!empty($this->options['help-text']) ? "<small id=\"{$this->options['id']}HelpText\" class=\"form-text text-muted\">{$this->options['help-text']}</small>":'') .
                        (!empty($this->options['valid-feedback']) ? "<div class=\"valid-feedback\">{$this->options['valid-feedback']}</div>":'') .
                        (!empty($this->options['invalid-feedback']) ? "<div class=\"invalid-feedback\">{$this->options['invalid-feedback']}</div>":'') .
                        "</div>\n";
                break;

            case 'select':
                $sAtributes = [];
                foreach ($this->options as $k => $v) {
                    if (in_array($k, $iAttributes)) continue;
                    $sAtributes[] = "{$k}=\"{$v}\"";
                }
                if ($this->options['required']) $sAtributes[] = "required";
                
                $options = '';
                if (is_array($this->options['options'])){
                    foreach ($this->options['options'] as $k => $v) {
                        $options .= "<option value=\"{$k}\"" . ((@$this->data[$this->name]==$k) ? ' selected':'') . ">{$v}</option>";
                    }
                }
                
                return '<div class="form-group' . 
                        (isset($this->options['col']) ? " col-{$this->options['col']}":'') . '">' . $this->getLabel() . 
                        '<select ' . implode(' ', $sAtributes) . '>' . 
                        ($this->options['empty']===false ? '':'<option value="">' . $this->options['empty'] . '</option>') . 
                        $options . 
                        '</select>' . 
                        (!empty($this->options['help-text']) ? "<small id=\"{$this->options['id']}HelpText\" class=\"form-text text-muted\">{$this->options['help-text']}</small>":'') .
                        (!empty($this->options['valid-feedback']) ? "<div class=\"valid-feedback\">{$this->options['valid-feedback']}</div>":'') .
                        (!empty($this->options['invalid-feedback']) ? "<div class=\"invalid-feedback\">{$this->options['invalid-feedback']}</div>":'') .
                        "</div>\n";
                break;

            case 'radio':
            case 'checkbox':
                $iAttributes[] = 'checked';
                $iAttributes[] = 'selected';
                $iAttributes[] = 'class';
                $iAttributes[] = 'required';
                $options = [];
                if (is_array($this->options['options'])){
                    $i = 0;
                    foreach ($this->options['options'] as $k => $v) {
                        $iop['value'] = $v;
                        if (@$this->data[$this->name]==$k) $iop['checked'] = true;
                        $sAtributes = [];
                        $iop = $this->options;
                        $iop['class'] = 'form-check-input' . (isset($iop['class']) ? " {$iop['class']}":'');
                        $iop['id'] = $iop['id'] . $i;
                        foreach ($iop as $kk => $vv) {
                            if (in_array($kk, $iAttributes)) continue;
                            $sAtributes[] = "{$kk}=\"{$vv}\"";
                        }
                        if ($iop['required']) $sAtributes[] = "required";
                        if ($iop['checked']) $sAtributes[] = "checked";
                        
                        $options[] = "<div class=\"form-check\"><input class=\"form-check-input\" " . implode(' ', $sAtributes) . "> <label class=\"form-check-label\" for=\"{$iop['id']}\">{$v}</label>" . 
                        (!empty($this->options['valid-feedback']) ? "<div class=\"valid-feedback\">{$this->options['valid-feedback']}</div>":'') .
                        (!empty($this->options['invalid-feedback']) ? "<div class=\"invalid-feedback\">{$this->options['invalid-feedback']}</div>":'') . 
                        "</div>";
                        $i++;
                    }
                }
                
                return '<div class="form-group' . 
                        (isset($this->options['col']) ? " col-{$this->options['col']}":'') . '">' . $this->getLabel() . 
                        implode("\n", $options) .
                        (!empty($this->options['help-text']) ? "<small id=\"{$this->options['id']}HelpText\" class=\"form-text text-muted\">{$this->options['help-text']}</small>":'') .
                        "</div>\n";
                break;

            case 'textarea':
                $sAtributes = [];
                foreach ($this->options as $k => $v) {
                    if (in_array($k, $iAttributes)) continue;
                    $sAtributes[] = "{$k}=\"{$v}\"";
                }
                if ($this->options['required']) $sAtributes[] = "required";
                
                return '<div class="form-group' . 
                        (isset($this->options['col']) ? " col-{$this->options['col']}":'') . '">' . $this->getLabel() . 
                        '<textarea ' . implode(' ', $sAtributes) . '>' . 
                        $this->options['value'] . 
                        '</textarea>' . 
                        (!empty($this->options['help-text']) ? "<small id=\"{$this->options['id']}HelpText\" class=\"form-text text-muted\">{$this->options['help-text']}</small>":'') .
                        (!empty($this->options['valid-feedback']) ? "<div class=\"valid-feedback\">{$this->options['valid-feedback']}</div>":'') .
                        (!empty($this->options['invalid-feedback']) ? "<div class=\"invalid-feedback\">{$this->options['invalid-feedback']}</div>":'') .
                        "</div>\n";
                break;

            default:
                break;
        }
    }
    
}