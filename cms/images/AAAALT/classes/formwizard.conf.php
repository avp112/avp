<?php
/**
 * formWizard :: php form generator
 * configurates formWizard forms and formWizard class
 *
 * @author Andreas Demmer <mail@andreas-demmer.de>
 * @version 2.2.0
 */

/**
* url to stylesheet
*
* @var const
*/
define('FORMWIZARD_CSS_URL', 'formwizard.css');

/**
* HTML code default errormessage for required fields
*
* @var const
*/
define('FORMWIZARD_ERROR_MESSAGE', 'Das Feld muss beschrieben sein!');

/**
* HTML code manditory indicator explaination
*
* @var const
*/
define('FORMWIZARD_LEGEND_REQUIRED_FIELD', '(*) notwendiges Feld');

/**
* HTML code for manditory indicator
*
* @var const
*/
define('FORMWIZARD_REQUIRED_FIELD', '*');

/**
* HTML code wrapping error messages
*
* @var const
*/
define('FORMWIZARD_UNFILLED_REQUIRED_FIELD', '<br /><div class="error">{errorMessage}</div>');

/**
* HTML code before form
*
* @var const
*/
define('FORMWIZARD_PRE_FORM', '<div class="form">');

/**
* HTML code before form with headline
*
* @var const
*/
define('FORMWIZARD_PRE_FORM_HEADLINE', '<div class="form"><h1>{headline}</h1>');

/**
* HTML code after form
*
* @var const
*/
define('FORMWIZARD_POST_FORM', '</div>');

/**
* HTML code before elements
*
* @var const
*/
define('FORMWIZARD_PRE_ELEMENT', "<div class=\"element\">\n<div class=\"description\">");

/**
* HTML code between description and field in elements
*
* @var const
*/
define('FORMWIZARD_SEPARATE_ELEMENT', "</div>\n<div class=\"field\">");

/**
* HTML code after elements
*
* @var const
*/
define('FORMWIZARD_POST_ELEMENT', "</div>\n</div>");


/**
* HTML code for separating element
*
* @var const
*/
define('FORMWIZARD_SEPARATOR', '<div class="separator">{text}&nbsp;</div>');
?>