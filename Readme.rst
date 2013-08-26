Batch Mailer
============

This extension provides an alternative mail transport for TYPO3. This transport catches all outgoing mails
and stores them in a database tables. The mail are sent later via a cron job or a Scheduler task.


Compatibility
^^^^^^^^^^^^^

This extension requires TYPO3 4.7 or more to function properly.


Activation
^^^^^^^^^^

To activate this transport simply set the following configuration::

	$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'Tx_Batchmailer_Service_Transport';


Configuration
^^^^^^^^^^^^^

This extension comes with the following options (to configure in the Extension Manager):

- **originalTransport**: since activating this extension implies changing :code:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']`
  whatever original transport might have been there ("smtp", etc.) is lost. However this information is needed for when the mails
  are actually sent. This is the place to set it. The value here should be what you would have put in
  :code:`$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']` if you weren't using this extension.

- **storagePid**: id of the page where the mails should be stored, when sent from another context than FE (e.g. BE, a Scheduler task, etc.).
  For the FE context, mails are stored by default in the page where they were sent from.

- **storagePidOverride**: force the storage pid to be used even in the FE context.


Sending the mails
^^^^^^^^^^^^^^^^^

The mails are actually sent by a Extbase command controller. It is thus possible to either define a cron job
with a command like::

	/path/to/php /path/to/typo3/cli_dispatch.phpsh extbase mailer:send


or use it as in the Scheduler using the Extbase Extbase CommandController Task Scheduler task available
since TYPO3 4.7.

The command controller uses the transport defined in the "originalTransport" configuration discussed
above to send the mails.

You will probably want to run this job at a high frequency in order not to delay the files too much.


More stuff to know
^^^^^^^^^^^^^^^^^^

In order to be able to send mails in a delayed fashion, the mail objects are stored in database table
"tx_batchmailer_domain_model_mail", along with some information for display in the BE. The attachments
are removed from the object and stored in folder :file:`uploads/tx_batchmailer/`. Mind that this folder could
grow quite a bit over time. There's currently no cleanup task, but it's planned to add one in the future, as needed.
