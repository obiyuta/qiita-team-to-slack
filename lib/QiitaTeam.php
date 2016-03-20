<?php

class QiitaTeam {

    private $baseUrl;
    private $data;
    private $item;
    private $comment;
    private $project;
    private $branches;
    private $model;
    private $action;

    public function __construct($branches, $baseUrl) {
        if (empty($branches) || empty($baseUrl)) {
            throw new Exception("Failed to initialize class QiitaTeam");
        } else {
            $this->branches = $branches;
            $this->baseUrl = $baseUrl;
        }
        return $this;
    }

    public function set(stdClass $data) {
    	$this->data = $data;
    	$this->model = $data->model;
    	$this->action = $data->action;
        return $this;
    }

    public function getItem() {
        $this->item = new stdClass;
    	$this->item->attachments = $this->getItemAttachments();
    	return $this->item;
    }

    public function getComment() {
        $this->comment = new stdClass;
    	$this->comment->attachments = $this->getCommentAttachments();
    	return $this->comment;
    }

    public function getModel() {
    	return $this->data->model;
    }

    public function getAction() {
    	 return $this->data->action;
    }

    public function getChannelByCreater() {
     	$username = $this->data->item->user->url_name;
        $branches = $this->branches;
        $belongs = array();
        foreach ($branches as $channel => $members) {
            if (in_array($username, $members)) {
                $belongs[] = $channel;
            }
        }
        if (empty($belongs)) {
            $belongs[] = '#general';
        }
        return $belongs;
    }

    private function getItemAttachments() {
    	$attachments = (object)array(
    		'attachments' => array(
    			'color' => '#1887d0',
	    		'pretext' => '<'.$this->baseUrl.$this->data->user->url_name.'|'.$this->data->user->url_name.'> created a new post',
	    		'title' => $this->data->item->title,
	    		'title_link' => $this->data->item->url,
	    		'text' => $this->data->item->raw_body,
	    		"mrkdwn_in"=> array("text", "pretext")
    		)
    	);
    	return $attachments;
    }

    private function getCommentAttachments() {

    	$pretext = 'New comment on <';
    	$pretext.= $this->baseUrl;
    	$pretext.= $this->data->item->user->url_name.'|';
    	$pretext.= $this->data->item->user->url_name.'>\'s <';
    	$pretext.= $this->data->item->url.'|';
    	$pretext.= $this->data->item->title.'>';

		$title = 'Commented by '.$this->data->comment->user->url_name;

    	$attachments = (object)array(
    		'attachments' => array(
    			'color' => '#b1ddfb',
	    		'pretext' => $pretext,
	    		'title' => $title,
	    		'text' => $this->data->comment->raw_body,
	    		"mrkdwn_in"=> array("text", "pretext"),
    		)
    	);
    	return $attachments;
    }


}
