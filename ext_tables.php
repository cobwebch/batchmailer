<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
        'tx_batchmailer_domain_model_mail',
        'EXT:batchmailer/Resources/Private/Language/locallang_csh_tx_batchmailer_domain_model_mail.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_batchmailer_domain_model_mail');

// Register sprite icon for batchmailer table
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
        'tx_batchmailer-default',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
            'source' => 'EXT:batchmailer/Resources/Public/Icons/MailDefault.png'
        ]
);
$iconRegistry->registerIcon(
        'tx_batchmailer-status-not-sent',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
            'source' => 'EXT:batchmailer/Resources/Public/Icons/MailNotSent.png'
        ]
);
$iconRegistry->registerIcon(
        'tx_batchmailer-status-error',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
            'source' => 'EXT:batchmailer/Resources/Public/Icons/MailError.png'
        ]
);
$iconRegistry->registerIcon(
        'tx_batchmailer-status-warning',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
            'source' => 'EXT:batchmailer/Resources/Public/Icons/MailWarning.png'
        ]
);
$iconRegistry->registerIcon(
        'tx_batchmailer-status-ok',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
            'source' => 'EXT:batchmailer/Resources/Public/Icons/MailOk.png'
        ]
);
