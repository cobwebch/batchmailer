<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Batch Mailer');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_batchmailer_domain_model_mail', 'EXT:batchmailer/Resources/Private/Language/locallang_csh_tx_batchmailer_domain_model_mail.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_batchmailer_domain_model_mail');

$extensionRelativePath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);

$icons = array(
	'default' => $extensionRelativePath . 'Resources/Public/Icons/MailDefault.png',
	'status-not-sent' => $extensionRelativePath . 'Resources/Public/Icons/MailNotSent.png',
	'status-error' => $extensionRelativePath . 'Resources/Public/Icons/MailError.png',
	'status-warning' => $extensionRelativePath . 'Resources/Public/Icons/MailWarning.png',
	'status-ok' => $extensionRelativePath . 'Resources/Public/Icons/MailOk.png'
);
\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons($icons, $_EXTKEY);
