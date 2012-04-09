<?php
/**
 * formWizard :: php form generator
 * object-oriented form generation
 *
 * @author Andreas Demmer <mail@andreas-demmer.de>
 * @version 2.2.0
 */

/**
 * interface formElementHandles
 * defines API of formWizard Elements
 */
interface formElementHandles {
    /**
     * defines if description my be wrapped if too long
     *
     * @return void
     * @param bool $wrap
     */
    public function doNotWrapDescription($wrap);
        
    /**
     * indicates if field ist required but filled uncorrectly
     *
     * @return bool
     */
    public function errorOccured();
    
    /**
     * delivers html code of element
     *
     * @return string
     */
    public function fetch();
    
    /**
     * delivers name of element
     *
     * @return string
     */
    public function getName();
        
    /**
     * returns submitted value for this field
     *
     * @return mixed
     */
    public function getSubmittedValue();
    
    /**
     * defines if field is marked if it is required
     *
     * @return void
     * @param bool $mark
     */
    public function markIfRequired($mark);
    
    /**
     * makes field required
     *
     * @return void
     * @param bool $required
     */
    public function setRequired($required);
    
    /**
     * indicates if field is required
     *
     * @return bool
     */
    public function isRequired();
       
    /**
     * indicates if field is to be marked if it is required
     *
     * @return bool
     */
    public function isToBeMarked();
           
    /**
     * delivers javascripts of element
     *
     * @return bool
     */
    public function getJavaScripts();
    
    /**
    * generates html code of element
    *
    * @access public
    * @return void
    */
    public function render();
            
    /**
     * sets regular expression or callback for field validation
     *
     * @return void
     * @param string $validation
     */
    public function setCustomValidation($validation);
        
    /**
     * sets description
     *
     * @return void
     * @param string $text
     */
    public function setDescription($text);
    
    /**
     * sets errormessage
     *
     * @return void
     * @param string $message
     */
    public function setErrorMessage($message);
        
    /**
     * sets javascript focus on element
     *
     * @return void
     * @param bool $focus
     */
    public function setFocus($focus);
    
    /**
     * sets value for this element
     *
     * @return boid
     * @param string $value
     */
    public function setValue($value);
}

/**
 * class formWizard
 * delivers and handles all formElement elements and generates the form
 */
class formWizard {
    /**
     * target URL of form action
     *
     * @var string
     */
    protected $action = '';

    /**
     * form elements
     *
     * @var array
     */
    protected $elements = array();

    /**
     * indicates whether a required field was not filled correctly
     *
     * @var bool
     */
    protected $error = FALSE;

    /**
     * headline of the form
     *
     * @var string
     */
    protected $headline;

    /**
     * HTML code of the form
     *
     * @var string
     */
    protected $html;

    /**
     * indicates whether the form has been rendered
     *
     * @var bool
     */
    protected $isRendered;

    /**
     * JavaScripts of the form
     *
     * @var string
     */
    protected $javascripts;

    /**
     * indicates whether required fields will be marked
     *
     * @var bool
    */
    protected $markRequiredFields;

    /**
     * method for form: post or get
     *
     * @var string
     */
    protected $method;

    /**
     * name of the form
     *
     * @var string
     */
    protected $name;

    /**
    * indicates whether the form has been submitted
    *
     * @var bool
     */
    protected $submitted;

    /**
    * indicates the amount of elements in this form, used for ID generation
    *
     * @var int
     */
    protected $elementCounter;

    /**
     * constructor: generates new form $name with $action
     *
     * @return void
     * @param string $action
     * @param string $name
     * @param string $method
     */
    public function __construct($action = FALSE, $name = 'form', $method = 'post') {
        $this->action = (bool)$action ? $action : $_SERVER['PHP_SELF'];
        $this->name = $name;
        $this->error = FALSE;
        $this->headline = NULL;
        $this->submitted = isset($_REQUEST['__'.$this->name.'_submitted']);
        $this->method = $method;
        $this->markRequiredFields = TRUE;

        if($this->submitted) {
            foreach($_REQUEST as $key => $value) {
                if (!is_array($value)) {
                    $_REQUEST[$key] = stripslashes($value);
                }
            }
        }
    }

    /**
     * delivers element types with translation table (optional)
     *
     * @return array
     * @param bool $translationTable
     */
    public function getElementTypes($translationTable = FALSE) {
        /* Ã¯Â¿Â½Alias => Klasse */
        $elementTypes = array(
            'checkbox' => 'formCheckbox',
            'text' => 'formTextField',
            'password' => 'formPasswordField',
            'hidden' => 'formHiddenField',
            'textarea' => 'formTextarea',
            'dropdown' => 'formDropdown',
            'file' => 'formFileField',
            'radio' => 'formRadioButton',
            'submit' => 'formSubmitButton',
            'image' => 'formImageButton',
            'separator' => 'formSeparator'
        );

        return $translationTable ? $elementTypes : array_keys($elementTypes);
    }

    /**
     * returns submitted fields and their values
     *
     * @return array
     */
    public function getFormdata() {
        $formdata = array();

        foreach($this->elements as $element) {
            $key = $element['object']->getName();
            $value = $element['object']->getSubmittedValue();

            $formdata[$key] = $value;
        }

        return $formdata;
    }

    /**
     * returns submitted fields and their details
     *
     * @return array
     */
    public function getRichFormdata() {
        $formdata = array();

        foreach($this->elements as $element) {
            $key = $element['object']->getName();

            $value = array (
            	'value' => $element['object']->getSubmittedValue(),
            	'description' => $element['object']->getDescription()
            );

            $formdata[$key] = $value;
        }

        return $formdata;
    }

    /**
     * adds element $name to the form
     *
     * @return void
     * @param string $elementType
     * @param string $name
     */
    public function addElement($elementType, $name) {
        $elementTypes = $this->getElementTypes(TRUE);

        if(!array_key_exists($elementType, $elementTypes)) {
            throw new formWizardException(
                'unknown elementtype',
                $this->name,
                $name
            );
        }

        $className = $elementTypes[$elementType];

        $element = array(
            'name' => $name,
            'object' => new $className()
        );

        $interfaceCheck = ($element['object'] instanceof formElementHandles) ? TRUE : FALSE;

        if(!$interfaceCheck) {
            throw new formWizardException('formelement does not implement required interface');
        }

        /* new element was added, count id */
        $this->elementCounter++;

        $element['object']->name = $name;
        $element['object']->form = $this;
        $element['object']->id = $this->name.'_'.$this->elementCounter;

        if($this->isSubmitted() && isset($_REQUEST[$name])) $element['object']->setValue($_REQUEST[$name]);

        $this->elements[] = $element;


        return $element['object'];
    }

    /**
     * indicates whether a required field was not filled correctly
     *
     * @return bool
     */
    public function errorOccured() {
        return $this->error;
    }

    /**
     * delivers HTML code of the form
     *
     * @return string
     */
    public function fetch() {
        if(!$this->isRendered) {
            $this->render();
        }

        return $this->html;
    }

    /**
     * inidcates whether required fields will be marked
     *
     * @return bool
     */
    public function getMarkRequiredFields() {
        return $this->markRequiredFields;
    }

    /**
     * indicates whether the form has been submitted
     *
     * @return bool
     */
    public function isSubmitted() {
        return $this->submitted;
    }

    /**
     * defines if required fields shall be marked
     *
     * @return void
     * @param bool $mark
     */
    public function markRequiredFields($mark) {
        $this->markRequiredFields = $mark;
    }

    /**
    * removes $element from form
    *
    * @return bool
    * @param string $name
    */
    public function removeElement($name) {
        if(array_key_exists($name, $this->elements)) {
            unset($this->elements[$name]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * generates HTML code of form
     *
     * @return void
     */
    public function render() {
        $formContainsRequiredFields = FALSE;
        $htmlElements = array();

        foreach($this->elements as $element) {
            if(!$this->getMarkRequiredFields()) {
                $element['object']->markIfRequired(FALSE);
            }

            if($element['object']->isRequired()) $formContainsRequiredFields = TRUE;
            $element['object']->render();
            if($element['object']->errorOccured()) $this->setError(TRUE);

            $htmlElements[] = $element['object']->fetch();
            $this->javascripts .= $element['object']->getJavaScripts();
        }

        $this->html = implode("\n<span class=\"element_separator\">&nbsp;</span>", $htmlElements);
        $preForm = (bool)$this->headline ? FORMWIZARD_PRE_FORM_HEADLINE : FORMWIZARD_PRE_FORM;

        $html = NULL;

        $html .= '<style type="text/css">@import url('.FORMWIZARD_CSS_URL.");</style>\n";
        $html .= str_replace('{headline}', $this->headline, $preForm);
        $html .= "\n".'<form name="'.$this->name.'" method="'.$this->method.'" action="'.$this->action.'" enctype="multipart/form-data">';
        $html .= "\n".'<input type="hidden" name="__'.$this->name.'_submitted" value="1" />';
        $html .= "\n".$this->html;
        $html .= "\n".'</form>';
        $html .= "\n".'<script type="text/javascript">'.$this->javascripts.'</script>';

        if($formContainsRequiredFields && $this->markRequiredFields) {
            $html .= "\n".FORMWIZARD_LEGEND_REQUIRED_FIELD;
        }

        $this->html = $html."\n".FORMWIZARD_POST_FORM;

        $this->isRendered = TRUE;
    }

    /**
     * sets headline of form
     *
     * @return void
     * @param string $headline
     */
    public function setHeadline($headline) {
        $this->headline = $headline;
    }

    /**
     * tell form that an error occured
     *
     * @return void
     * @param bool error
     */
    protected function setError($error) {
        $this->error = $error;
    }

    /**
     * defines method: post or get
     *
     * @return bool
     * @param method string
     */
    public function setMethod($method) {
        if(preg_match('|(post|get)|i', $method)) {
            $this->method = $method;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * delivers name of form
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}

/**
 * class formElement
 * conains common methods for form elements
 */
abstract class formElement {
    /**
     * formWizard object
     *
     * @var mixed
     */
    public $form = FALSE;

    /**
     * callback
     *
     * @var mixed
     */
    protected $callBack = NULL;

    /**
     * indicates whether description my be wrapped if too long
     *
     * @var bool
     */
    protected $doNotWrapDescription = FALSE;

    /**
     * field is required but filled uncorrectly
     *
     * @var bool
     */
    protected $error = FALSE;

    /**
     * custom errormessage
     *
     * @var string
     */
    protected $errorMessage = FALSE;

    /**
     * indicates whether element has javascript focus
     *
     * @var bool
     */
    protected $focus = FALSE;

    /**
     * HTML code of element
     *
     * @var string
     */
    protected $html = NULL;

    /**
     * Jjvascripts of element
     *
     * @var string
     */
    protected $javascripts = NULL;

    /**
     * indicates whether element will be marked if required
     *
     * @var bool
     */
    protected $markIfRequired = TRUE;

    /**
     * name of element
     *
     * @var string
     */
    public $name = NULL;

    /**
     * regular expression for validation input
     *
     * @var string
     */
    protected $regularExpression = FALSE;

    /**
     * indicates whether element is required
     *
     * @var string
     */
    protected $required = FALSE;

    /**
     * description of element
     *
     * @var string
     */
    protected $text = NULL;

    /**
     * value of element
     *
     * @var string
     */
    protected $value = NULL;

    /**
     * ID of this element
     *
     * @var int
     */
    public $id = 0;

    /**
     * validates field if filled or by regex or with callback
     *
     * @return bool
     */
    protected function checkValue() {
        if($this->required) {
            if($this->regularExpression) {
                if(preg_match($this->regularExpression, $this->value)) {
                    $returnValue = TRUE;
                } else {
                    $returnValue = FALSE;
                    $this->error = TRUE;
                }
            } elseif($this->callBack) {
                if(call_user_func($this->callBack, $this->value)) {
                    $returnValue = TRUE;
                } else {
                    $returnValue = FALSE;
                    $this->error = TRUE;
                }
            } elseif(!(bool)$this->value) {
                $returnValue = FALSE;
            } else {
                $returnValue = TRUE;
            }
        } else {
            $returnValue = TRUE;
        }

        return $returnValue;
    }

    /**
     * defines if description my be wrapped if too long
     *
     * @return void
     * @param bool $wrap
     */
    public function doNotWrapDescription($wrap) {
        $this->doNotWrapDescription = $wrap;
    }

    /**
     * delivers javascripts of element
     *
     * @return bool
     */
    public function getJavaScripts() {
        return $this->javascripts;
    }

    /**
     * indicates if field ist required but filled uncorrectly
     *
     * @return bool
     */
    public function errorOccured() {
        return $this->error;
    }

    /**
     * delivers html code of element
     *
     * @return string
     */
    public function fetch() {
        return $this->html;
    }

    /**
     * delivers name of element
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * delivers description of element
     *
     * @return string
     */
    public function getDescription() {
        return $this->text;
    }

    /**
     * returns submitted value for this field
     *
     * @return mixed
     */
    public function getSubmittedValue() {
        return isset($_REQUEST[$this->name]) ? $_REQUEST[$this->name] : FALSE;
    }

    /**
     * defines if field is marked if it is required
     *
     * @return void
     * @param bool $mark
     */
    public function markIfRequired($mark) {
        $this->markIfRequired = $mark;
    }

    /**
     * makes field required
     *
     * @return void
     * @param bool $required
     */
    public function setRequired($required) {
        $this->required = $required;
    }

    /**
     * indicates if field is required
     *
     * @return bool
     */
    public function isRequired() {
        return $this->required;
    }

    /**
     * indicates if field is to be marked if it is required
     *
     * @return bool
     */
    public function isToBeMarked() {
        return $this->markIfRequired;
    }

    /**
     * sets regular expression or callback for field validation
     *
     * @return void
     * @param string $validation
     */
    public function setCustomValidation($validation) {
        if (is_array($validation) || function_exists($validation)) {
            $this->regularExpression = false;
            $this->callBack = $validation;
        } else {
            $this->regularExpression = $validation;
            $this->callBack = NULL;
        }
    }

    /**
     * sets description
     *
     * @return void
     * @param string $text
     */
    public function setDescription($text) {
        $this->text = $text;
    }

    /**
     * sets errormessage
     *
     * @return void
     * @param string $message
     */
    public function setErrorMessage($message) {
        $this->errorMessage = $message;
    }

    /**
     * sets javascript focus on element
     *
     * @return void
     * @param bool $focus
     */
    public function setFocus($focus) {
        $this->focus = $focus;
    }

    /**
     * sets value for this element
     *
     * @return boid
     * @param string $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * wrap field code with element code
     *
     * @return string
     * @param string $html
     */
    protected function wrap($innerHtml) {
        $errorMessage = NULL;
        $requiredField = NULL;

        if($this->required && $this->errorOccured() && $this->form->isSubmitted()) {
            $errorMessage = (bool)$this->errorMessage? $this->errorMessage : FORMWIZARD_ERROR_MESSAGE;
            $errorMessage = str_replace('{errorMessage}', $errorMessage, FORMWIZARD_UNFILLED_REQUIRED_FIELD);
        }

        if($this->required && $this->markIfRequired) {
            $requiredField = FORMWIZARD_REQUIRED_FIELD;
        }

        $this->text = (bool)$this->text ? $this->text : '&nbsp;';
        $text = $this->doNotWrapDescription ? '<nobr>'.$this->text.'</nobr>' : $this->text;

        if($this->focus) {
            $this->javascripts = 'document.forms[\''.$this->form->getName().'\'].'.$this->name.'.focus();';
        }

        $html = FORMWIZARD_PRE_ELEMENT."\n".$text.$requiredField."\n".FORMWIZARD_SEPARATE_ELEMENT;
        $html .= "\n".$innerHtml.$errorMessage."\n".FORMWIZARD_POST_ELEMENT;

        return $html;
    }
}

/**
 * class formInputElement
 * Input form element for formWizard objekt
 */
abstract class formInputElement extends formElement implements formElementHandles {
    /**
     * input type
     *
     * @var int
     */
    protected $type;

    /**
     * custom css class
     *
     * @var string
     */
    protected $cssClass;

    /**
     * indicates whether checkbox is checked
     *
     * @var int
     */
    protected $checked;

    /**
     * indicates whether radio button is selected
     *
     * @var int
     */
    protected $selected;

    /**
     * length of field in letters
     *
     * @var int
     */
    protected $size;

    /**
     * allowed length of input in letters
     *
     * @var int
     */
    protected $maxlength;

    /**
     * URL of image
     *
     * @var string
     */
    protected $source;

    /**
     * width of image (px)
     *
     * @var int
     */
    protected $width;

    /**
     * height of image (px)
     *
     * @var int
     */
    protected $height;

    /**
     * generates html code of element
     *
     * @return void
     */
    public function render() {
        /* verify all fields except checkbox */
        if($this->required
           && $this->form->isSubmitted()
           && !$this->checkValue()) {
            $this->error = TRUE;
            $this->cssClass = 'error';
        }

        /* verify checkbox */
        $tempName = str_replace('[]', NULL, $this->name);

        if($this->required
           && $this->form->isSubmitted()
           && $this->type == 'checkbox'
           && !isset($_REQUEST[$tempName])) {
            $this->error = TRUE;
            $this->cssClass = 'error';
        }

        $html = NULL;
        $this->value = htmlspecialchars($this->value);

        $html .= '<input type="'.$this->type.'" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'"';
        $html .= (bool)$this->size ? ' size= "'.$this->size.'"' : NULL;
        $html .= (bool)$this->maxlength ? ' maxlength= "'.$this->maxlength.'"' : NULL;
        $html .= (bool)$this->size ? ' size="'.$this->size.'"' : NULL;
        $html .= ($this->type == 'text' || $this->type == 'password') ? ' class="' . $this->cssClass .'"' : NULL;
        $html .= ($this->type == 'submit') ? ' class="submit ' . $this->cssClass .'"' : NULL;
        $html .= ($this->type == 'checkbox') ? ' class="checkbox ' . $this->cssClass .'"' : NULL;
        $html .= ($this->type == 'radio') ? ' class="radio ' . $this->cssClass .'"' : NULL;
        $html .= ($this->type == 'image') ? ' source="'.$this->source.'"' : NULL;
        $html .= ($this->type == 'image' && (bool)$this->width && (bool)$this->height) ? '  style="width:'.$this->width.'px; height:'.$this->height.'px;"' : NULL;
        $html .= (bool)$this->checked ? ' checked' : NULL;
        $html .= ' />';

        if (isset($this->label)) {
            $html .= '<span class="label">' . $this->label . '</span>';
        }

        $this->html = ($this->type == 'hidden') ? $html : $this->wrap($html);
    }
}

/**
 * class formCheckbox
 * checkbox element for formWizard object
 */
class formCheckbox extends formInputElement implements formElementHandles {
    /**
     * label next to element
     *
     * @var string
     */
    protected $label;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'checkbox';
        $this->label = NULL;
    }

    /**
     * check or unchecks the checkbox
     *
     * @return void
     * @param bool checked
     */
    public function setChecked($checked) {
        $this->checked = $checked;
    }

    /**
     * sets clickable label next to element
     *
     * @return void
     * @param string $text
     */
    public function setLabel($text) {
        $this->label = '<label for="'.$this->id.'">'.$text.'</label>';
    }

    /**
     * sets description
     *
     * @return void
     * @param string $text
     */
    public function setDescription($text) {
        $this->text = $text;
    }
}

/**
 * class formRadioButton
 * input type radio element for formWizard object
 */
class formRadioButton extends formInputElement implements formElementHandles {
    /**
     * label next to element
     *
     * @var string
     */
    protected $label;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'radio';
    }

    /**
     * checks or unchecks radio button
     *
     * @return void
     * @param bool checked
     */
    public function setChecked($checked) {
        $this->checked = $checked;
    }

    /**
     * sets clickable label next to element
     *
     * @return void
     * @param string $text
     */
    public function setLabel($text) {
        $this->label = '<label for="'.$this->id.'">'.$text.'</label>';
    }

    /**
     * sets description
     *
     * @return void
     * @param string $text
     */
    public function setDescription($text) {
        $this->text = $text;
    }
}

/**
 * class formHiddenField
 * input type hidden element for formWizard object
 */
class formHiddenField extends formInputElement implements formElementHandles {
    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'hidden';
    }
}

/**
 * class formFileField
 * input type file element for formWizard object
 */
class formFileField extends formInputElement implements formElementHandles  {
    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'file';
    }
}

/**
 * class formTextField
 * input type text element for formWizard object
 */
class formTextField extends formInputElement implements formElementHandles {
    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'text';
    }

    /**
     * defines length of field in letters
     *
     * @return void
     * @param int $size
     */
    public function setSize($size) {
        $this->size = $size;
    }

    /**
     * defines allowed length of input in letters
     *
     * @return void
     * @param int $length
     */
    public function setMaxLength($length) {
        $this->maxlength = $length;
    }
}

/**
 * class formPasswordField
 * input type password element for formWizard object
 */
class formPasswordField extends formTextField  implements formElementHandles {
    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'password';
    }
}

/**
 * class formSubmitButton
 * input type submit element for formWizard object
 */
class formSubmitButton extends formInputElement implements formElementHandles {
    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'submit';
    }
}

/**
 * class formImageButton
 * input type image element for formWizard object
 */
class formImageButton extends formInputElement implements formElementHandles {
    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->type = 'image';
    }

    /**
     * sets URL of image
     *
     * @return void
     * @param string $source
     */
    public function setSource($source) {
        $this->source = $source;
    }

    /**
     * sets width and height of image (px)
     *
     * @return void
     * @param int $width
     * @param int $height
     */
    public function setDimensions($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }
}

/**
 * class formSeparator
 * separator element for formWizard object
 */
class formSeparator extends formElement implements formElementHandles {
    /**
     * generates html code of element
     *
     * @access public
     * @return void
    */
    public function render() {
        $html = str_replace('{text}', $this->text, FORMWIZARD_SEPARATOR);
        $this->html = $html;
    }
}

/**
 * class formTextArea
 * textarea element for formWizard object
 */
class formTextArea extends formElement implements formElementHandles {
    /**
     * width of textarea in letters
     *
     * @var int
     */
    protected $cols = 0;

    /**
     * height of textarea in rows
     *
     * @var bool
     */
    protected $rows = 0;

    /**
     * custom css class
     *
     * @var string
     */
    protected $cssClass;

    /**
     * defines width of textarea in letters
     *
     * @return void
     * @param int $cols
     */
    public function setCols($cols) {
        $this->cols = $cols;
    }

    /**
     * defines height of textarea in rows
     *
     * @return void
     * @param int $rows
     */
    public function setRows($rows) {
        $this->rows = $rows;
    }

    /**
     * generates html code of element
     *
     * @access public
     * @return void
     */
    public function render() {
        if($this->required
           && $this->form->isSubmitted()
           && !$this->checkValue()) {
            $this->error = TRUE;
            $this->cssClass = 'error';
        }

        $this->value = htmlspecialchars($this->value);

        $html = '<textarea id="'.$this->id.'" name="'.$this->name.'"';
        $html .= (bool)$this->cols ? ' cols="'.$this->cols.'"' : NULL;
        $html .= (bool)$this->rows ? ' rows="'.$this->rows.'"' : NULL;
        $html .= (bool)$this->cssClass ? ' class="'.$this->cssClass.'"' : NULL;
        $html .= '>'.$this->value.'</textarea>';

        $this->html = $this->wrap($html);
    }
}

/**
 * class formDropdown
 * select element for formWizard object
 */
class formDropdown extends formElement implements formElementHandles {
    /**
     * options
     *
     * @var array
     */
    protected $options;

    /**
     * indicates whether dropdown has preselected value
     *
     * @var bool
     */
    protected $valuePreselected;

    /**
     * indicates whether selecting multiple options is allowed
     *
     * @var bool
     */
    protected $multiple;

    /**
     * number of simultaniously visible options
     *
     * @var mixed
     */
    protected $size;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        $this->options = array();
        $this->valuePreselected = FALSE;
        $this->size = FALSE;
    }

    /**
     * defines number of simultaniously visible options
     *
     * @return void
     * @param int $size
     */
    public function setSize($size) {
        $this->size = $size;
    }

    /**
     * allows selection of multiple options
     *
     * @return void
     * @param bool $multiple
     */
    public function setMultiple($multiple) {
        $this->multiple = $multiple;
    }

    /**
     * @return void
     * @param string $optionTitle
     * @param string $optionValue
     * @param bool $preselected
     * @desc adds option $optionTitle with value $optionValue,
     *       $preselected makes it preselected
     */
    public function addOption($optionTitle, $optionValue = FALSE, $preselected = FALSE) {
        if($optionValue === FALSE) $optionValue = $optionTitle;

        $option = array(
            'optionTitle' => $optionTitle,
            'optionValue' => $optionValue
        );

        if($preselected) $option['selected'] = TRUE;

        $this->options[] = $option;
    }

    /**
     * @return void
     * @param array options
     * @desc adds multiple options at once
             array: optionValue => optionTitle
     */
    public function addOptions($options) {
        $errorsOccured = FALSE;

        foreach($options as $optionValue => $optionTitle) {
            $preselected = ($this->form->isSubmitted() && $_REQUEST[$this->name] == $value) ? TRUE : FALSE;
            $this->addOption($option, $value, $preselected);
        }
    }

    /**
     * removes option with value $optionValue from dropdown
     *
     * @return void
     * @param string $optionValue
     */
    public function removeOption($optionValue) {
        if(is_array($this->options)) {
            foreach ($this->options as $key => $option) {
                if($option['optionValue'] == $optionValue) {
                    unset($this->options[$key]);
                    break;
                }
            }
        }
    }

    /**
     * select option with value $optionValue in dropdown
     *
     * @return void
     * @param string $optionValue
     */
    public function selectOption($optionValue) {
        if(is_array($this->options)) {
            foreach ($this->options as $key => $option) {
                if($option['optionValue'] == $optionValue) {
                    $this->options[$key]['selected'] = TRUE;
                    break;
                }
            }
        }
    }


    /**
     * sorts options alphabetically using optionTitle
     *
     * @return void
     */
    public function sortOptions() {
        $options = array();

        foreach($this->options as $key => $option) {
            $optionTitle = $option['optionTitle'];
            $options[$optionTitle] = $option;
        }

        ksort($options);
        reset($options);

        $this->options = $options;
    }

    /**
     * generates HTML code of element
     *
     * @return void
     */
    public function render() {
        $this->checkValue();
        $html = NULL;

        $html .= '<select id="'.$this->id.'" name="'.$this->name.'"';
        $html .= (bool)$this->multiple ? ' multiple' : NULL;
        $html .= (bool)$this->size ? ' size="'.$this->size.'"' : NULL;
        $html .= ">\n";

        foreach($this->options as $option) {
            $html .= '<option value="'.$option['optionValue'].'"';

            if($this->form->isSubmitted()) {
                $html .= ($_REQUEST[$this->name] == $option['optionValue']) ? ' selected' : NULL;
            } else {
                $html .= (isset($option['selected']) && (bool)$option['selected']) ? ' selected' : NULL;
            }

            $html .= '>'.$option['optionTitle']."</option>\n";
        }

        if($this->required
           && $this->form->isSubmitted()
           && !$this->checkValue()) {
            $this->error = TRUE;
        }

        $html .= '</select>';
        $this->html = $this->wrap($html);
    }
}

/**
 * class formWizardException
 * extends generic Exception class
 */

class formWizardException extends exception {
    /**
     * extended information
     *
     * @var array
     */
    protected $details;

    /**
     * constructor
     *
     * @return void
     * @param string $errorMessage
     * @param string $formName
     * @param string $elementName
     */
    public function __construct($detail = NULL, $formName = FALSE, $elementName = FALSE) {
        if((bool)$detail) $details[] = $detail;
        if((bool)$formName) $details[] = 'failed to generate form '."\"$formName\"";
        if((bool)$elementName) $details[] = 'failed to generate form '."\"$elementName\"";

        $this->details = $details;
        parent::__construct($errorMessage);
    }

    /**
     * delivers details
     *
     * @return array
     */
    public function getDetails() {
        return $this->details;
    }
}
?>