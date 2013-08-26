<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_batchmailer_domain_model_mail'] = array(
	'ctrl' => $TCA['tx_batchmailer_domain_model_mail']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, recipients, copies, blind_copies, sender, subject, body',
	),
	'types' => array(
		'1' => array('showitem' => '--div--;LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.tab_mail, crdate, hidden, recipients, copies, blind_copies, sender, subject, body, attachments, --div--;LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.tab_sent, sent, sent_status, sent_error_message, sent_date, sent_tries'),
	),
	'columns' => array(
		'crdate' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.crdate',
			'config' => array(
				'type' => 'input',
				'eval' => 'datetime',
				'readOnly' => TRUE
			),
		),
		'hidden' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'recipients' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.recipients',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => TRUE
			),
		),
		'copies' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.copies',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => TRUE
			),
		),
		'blind_copies' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.blind_copies',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => TRUE
			),
		),
		'sender' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sender',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => TRUE
			),
		),
		'subject' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.subject',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'readOnly' => TRUE
			),
		),
		'body' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.body',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'readOnly' => TRUE
			),
		),
		'attachments' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.attachments',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'readOnly' => TRUE
			),
		),
		'mail' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.mail',
			'config' => array(
				'type' => 'none'
			)
		),
		'sent' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent',
			'config' => array(
				'type' => 'check',
				'readOnly' => TRUE
			),
		),
		'sent_status' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_status',
			'config' => array(
				'type' => 'input',
				'form_type' => 'select',
				'eval' => 'int',
				'items' => array(
					array(
						'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_status.not_sent',
						0
					),
					array(
						'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_status.warning',
						3
					),
					array(
						'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_status.error',
						4
					),
					array(
						'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_status.ok',
						6
					),
				),
				'readOnly' => TRUE
			),
		),
		'sent_error_message' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_error_message',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'readOnly' => TRUE
			),
		),
		'sent_date' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_date',
			'config' => array(
				'type' => 'input',
				'eval' => 'datetime',
				'readOnly' => TRUE
			),
		),
		'sent_tries' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:batchmailer/Resources/Private/Language/locallang_db.xlf:tx_batchmailer_domain_model_mail.sent_tries',
			'config' => array(
				'type' => 'input',
				'eval' => 'int',
				'size' => 5,
				'readOnly' => TRUE
			),
		),
	),
);

?>