<?php

/**
*
*  Slack & Qiita:Team setting
*
**/


define('QIITA_BASE_URL', 'http://YOUR_QIITA_TEAM_URL');
define('SLACK_WEBHOOK_URL', 'http://YOUR_SLACK_WEBHOOK_URL');

$members = array(
	'SLACK_CHANNEL_NAME' => array(
		'QIITA_USERNAME'
	),
);

define('QIITA_MEMBERS', json_encode($members));


/** Sample

define('SLACK_DEV_CHANNEL', '#develop');
define('SLACK_DESIGN_CHANNEL', '#design');

$members = array(
    SLACK_DEV_CHANNEL => array(
        'hogehoge'
    ),
    SLACK_DESIGN_CHANNEL => array(
        'fugafuga'
    ),
);

**/
