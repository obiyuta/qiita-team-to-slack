<?php

require 'config/setting.php';
require 'lib/Slack.php';
require 'lib/QiitaTeam.php';

class QiitaTeamSlack {

    private $payload;
    private $slack;
    private $qiitaTeam;

    public function __construct($payload) {
        if (empty($payload)) {
            throw new Exception("Failed to initialize class QiitaTeamSlack");
        } else {
            $this->payload = $payload;
        }
        $this->setUp();
        return $this;
    }

    public function send() {
        $model = $this->qiitaTeam->getModel();
        $action = $this->qiitaTeam->getAction();

        $this->slack->username('Qiita:team')
            ->iconUrl('http://s18.postimg.org/569m8zoc5/qiita_team.jpg');

        switch ($model) {
            case 'item':
                if ($action == 'created') {
                    $item = $this->qiitaTeam->getItem();
                    $attachments = $item->attachments;
                }
                break;
            case 'comment':
                if ($action == 'created') {
                    $comment = $qiitaTeam->getComment();
                    $attachments = $comment->attachments;
                }
                break;
            default:
                break;
        }
        if (!empty($attachments)) {
            $this->slack->attachments($attachments);
            foreach($this->qiitaTeam->getChannelByCreater() as $channel) {
                $this->slack->channel($channel)
                    ->send();
            }
        }
    }

    private function setUp() {
        try {
            $this->slack = new Slack(SLACK_WEBHOOK_URL);
            $this->qiitaTeam = new QiitaTeam(json_decode(QIITA_MEMBERS, true), QIITA_BASE_URL);
        } catch (Exception $e) {
            throw new Exception($e->getMessage() . " in class QiitaTeamSlack");
        }
        $this->qiitaTeam->set($this->payload);
    }

}