<?php
define('_MI_XHTTPERR_NAME', 'xHttpError');
define('_MI_XHTTPERR_DESC', 'A XOOPS module to manage http errors.');

// config options
define('_MI_XHTTPERR_FORM_EDITOR', '[Editor] Choose an editor for categories description');
define('_MI_XHTTPERR_FORM_EDITOR_DESC', '<ul><li><b>dhtmltextarea:</b> default Xoops editor</li><li><b>textarea:</b> standard html textarea</li><li><b>tinymce:</b> enhanced WYSIWYG editor</li><li>...</li></ul>');
define('_MI_XHTTPERR_IGNOREADMIN', 'Ignore admins');
define('_MI_XHTTPERR_IGNOREADMIN_DESC', 'Do not add error reports into the database for admins.');
define('_MI_XHTTPERR_REPORTING', 'Turn off error reports');
define('_MI_XHTTPERR_REPORTING_DESC', 'Busy sites may want to turn off error reporting if the report page gets too large.');
define('_MI_XHTTPERR_PAGETTL', 'Page title');
define('_MI_XHTTPERR_PAGETTLDSC', "Put the error title in the page's title");
define('_MI_XHTTPERR_PAGETTL1', 'None');
define('_MI_XHTTPERR_PAGETTL2', 'Yes: &lt;module name> - &lt;error>');
define('_MI_XHTTPERR_PAGETTL3', 'Yes: &lt;error> - &lt;module name>');
define('_MI_XHTTPERR_NUMREPS', 'Number of reports');
define('_MI_XHTTPERR_NUMREPS_DESC', 'The numbers of reports to show.');

// Admin menu
// admin/menu.php
define('_MI_XHTTPERR_ADMENU_INDEX', 'Index');
define('_MI_XHTTPERR_ADMENU_INDEX_DESC', '');
define('_MI_XHTTPERR_ADMENU_ERRORS', 'Error codes');
define('_MI_XHTTPERR_ADMENU_ERRORS_DESC', '');
define('_MI_XHTTPERR_ADMENU_REPORTS', 'Reports');
define('_MI_XHTTPERR_ADMENU_REPORTS_DESC', '');
define('_MI_XHTTPERR_ADMENU_ABOUT', 'About');
define('_MI_XHTTPERR_ADMENU_ABOUT_DESC', '');

//1.11
//Help
define('_MI_XHTTPERR_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_XHTTPERR_HELP_HEADER', __DIR__.'/help/helpheader.tpl');
define('_MI_XHTTPERR_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_XHTTPERR_OVERVIEW', 'Overview');

//define('_MI_XHTTPERR_HELP_DIR', __DIR__);

//help multi-page
define('_MI_XHTTPERR_DISCLAIMER', 'Disclaimer');
define('_MI_XHTTPERR_LICENSE', 'License');
define('_MI_XHTTPERR_SUPPORT', 'Support');
