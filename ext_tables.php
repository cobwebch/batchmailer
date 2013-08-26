<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Batch Mailer');

t3lib_extMgm::addLLrefForTCAdescr('tx_batchmailer_domain_model_mail', 'EXT:batchmailer/Resources/Private/Language/locallang_csh_tx_batchmailer_domain_model_mail.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_batchmailer_domain_model_mail');

$extensionRelativePath = t3lib_extMgm::extRelPath($_EXTKEY);
$TCA['tx_batchmailer_domain_model_mail'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail',
		'label' => 'subject',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'default_sortby' => 'ORDER BY crdate',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'searchFields' => 'recipients,copies,blind_copies,sender,subject,body',
		'typeicon_column' => 'sent_status',
		'typeicon_classes' => array(
			'0' => 'extensions-batchmailer-status-not-sent',
			'3' => 'extensions-batchmailer-status-error',
			'4' => 'extensions-batchmailer-status-warning',
			'6' => 'extensions-batchmailer-status-ok'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Mail.php',
		'iconfile' => $extensionRelativePath . 'Resources/Public/Icons/MailDefault.png'
	),
);

$icons = array(
	'status-not-sent' => $extensionRelativePath . 'Resources/Public/Icons/MailNotSent.png',
	'status-error' => $extensionRelativePath . 'Resources/Public/Icons/MailError.png',
	'status-warning' => $extensionRelativePath . 'Resources/Public/Icons/MailWarning.png',
	'status-ok' => $extensionRelativePath . 'Resources/Public/Icons/MailOk.png'
);
t3lib_SpriteManager::addSingleIcons($icons, $_EXTKEY);
?>