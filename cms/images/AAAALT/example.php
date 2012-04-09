<?php
/* include formWizard class */
require_once 'classes/formwizard.class.php'; 

/* include formWizard configuration */
require_once 'classes/formwizard.conf.php';

/* create formWizard object, define headline */
$form = new formWizard();
$form->setHeadline('formWizard Test');

/* add elements */
$checkbox = $form->addElement('checkbox', 'myBox');
$textfield = $form->addElement('text', 'myTextfield');
$email = $form->addElement('text', 'myEmail');
$radioGreat = $form->addElement('radio', 'myRadio');
$radioOk = $form->addElement('radio', 'myRadio');
$radioLousy = $form->addElement('radio', 'myRadio');
$separator = $form->addElement('separator', 'mySeparator');
$password = $form->addElement('password', 'myPassword');
$textarea = $form->addElement('textarea', 'myTextarea');
$dropdown = $form->addElement('dropdown', 'myDropdown');
$file = $form->addElement('file', 'myFilen');
$submit = $form->addElement('submit', 'myFilen');

/* unchecked checkbox, required with own error message, description does not wrap */
$checkbox->setDescription('my checkbox');
$checkbox->doNotWrapDescription(TRUE);
$checkbox->setRequired(TRUE);
$checkbox->setValue(1);
$checkbox->setErrorMessage('turn my on, baby...');
if(isset($_REQUEST['myBox']) && (bool)$_REQUEST['myBox']) $checkbox->setChecked(TRUE);

/* textfield with 30 chars length, max 255 chars, required and has focus */
$textfield->setDescription('my textfield');
$textfield->setRequired(TRUE);
$textfield->setFocus(TRUE);

/* textfield with 30 chars length, max 255 chars, requires valid email address */
$email->setDescription('Email-Address');
$email->setRequired(TRUE);
$email->setCustomValidation('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i');
$email->setErrorMessage('no valid email address');

/* seperator */

/* radio buttons */
$radioGreat->setDescription('How do you like this form?');
$radioGreat->setLabel('great');
$radioGreat->setValue('great');
if(isset($_REQUEST['myRadio']) && $_REQUEST['myRadio'] == 'great') $radioGreat->setChecked(TRUE);

$radioOk->setLabel('ok');
$radioOk->setValue('ok');
if(isset($_REQUEST['myRadio']) && $_REQUEST['myRadio'] == 'ok') $radioOk->setChecked(TRUE);

$radioLousy->setLabel('lousy');
$radioLousy->setValue('lousy');
if(isset($_REQUEST['myRadio']) && $_REQUEST['myRadio'] == 'lousy') $radioLousy->setChecked(TRUE);

/* password field with 10 chars, unlimited length */
$password->setSize(10);
$password->setDescription('my password');

/* textarea, 5 rows with 30 cols each */
$textarea->setCols(30);
$textarea->setRows(5);
$textarea->setDescription('my textarea');

/* dropdown, second entry is preselected */
$dropdown->setDescription('my dropdown');
$dropdown->addOption(1, 'first entry');
$dropdown->addOption(2, 'second entry', TRUE);
$dropdown->addOption(2, 'second entry', TRUE);
$dropdown->addOption(2, 'second entry', TRUE);
/* fileupload */
$file->setDescription('my file');

/* Submit-Button */
$submit->setValue('let\'s go');

/* required fields are not marked */
//$form->markRequiredFields(FALSE);

/* formular is rendered and written into variable */
$renderedForm = $form->fetch();

/* If the form was submitted an no errors occured, the
   environment variables from $_REQUEST are shown */
if((bool)$_GET['show_source']) {
    highlight_file($_SERVER['SCRIPT_FILENAME']);
    echo "<br /><br />";
    $link['target'] = $_SERVER['PHP_SELF'];
    $link['title'] = 'show source';
} elseif($form->isSubmitted() && !$form->errorOccured()) {
    echo '<h1>form data from $_REQUEST</h1><pre>',print_r($_REQUEST),'</pre>';
    $link['target'] = $_SERVER['PHP_SELF'].'?show_source=1';
    $link['title'] = 'show source';
} else {
    echo $renderedForm;
    $link['target'] = $_SERVER['PHP_SELF'].'?show_source=1';
    $link['title'] = 'show source';
}
?>
<div style="text-align: center;">
  <strong>
    <a href="<?=$link['target'] ?>"><?=$link['title'] ?></a>
  </strong>
</div>
