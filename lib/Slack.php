<?php

class Slack {

	private $webhookUrl;
	private $text;
	private $channel;
	private $username;
	private $iconEmoji;
	private $iconUrl;
	private $mrkdwn;
	private $attachments;

	public function __construct($webhookUrl) {
		if (empty($webhookUrl)) {
			throw new Exception('Failed to initialize class Slack');
		} else {
			$this->webhookUrl = $webhookUrl;
		}
		return $this;
	}

	public function text($text) {
		$this->text = $text;
		return $this;
	}

	public function channel($channel) {
		$this->channel = $channel;
		return $this;
	}

	public function username($username) {
		$this->username = $username;
		return $this;
	}

	public function iconEmoji($iconEmoji) {
		$this->iconEmoji = $iconEmoji;
		return $this;
	}

	public function iconUrl($iconUrl) {
		$this->iconUrl = $iconUrl;
		return $this;
	}

	public function mrkdwn($mrkdwn = false) {
		if (!is_bool($mrkdwn)) {
			throw new Exception();
		}
		$this->mrkdwn = $mrkdwn;
		return $this;
	}

	public function attachments($attachments) {
		$this->attachments = $attachments;
		return $this;
	}

	public function send() {
		$params = array();
 		if (!$this->validate()) {
 			return false;
 		} else {
 			$params = $this->makeParams();
			$params = json_encode($params);
			if (!$this->postRequest($this->webhookUrl, $params)) {
				return false;
			}
		}
		return true;

	}

	private function validate() {
		if (empty($this->webhookUrl)) {
			return false;
		}
		return true;
	}

	private function makeParams() {
		$params = array();
		if (!empty($this->text)) {
			$params['text'] = $this->text;
		}
		if (!empty($this->channel)) {
			$params['channel'] = $this->channel;
		}
		if (!empty($this->username)) {
			$params['username'] = $this->username;
		}
		if (!empty($this->iconEmoji)) {
			$params['icon_emoji'] = $this->iconEmoji;
		}
		if (!empty($this->iconUrl)) {
			$params['icon_url'] = $this->iconUrl;
		}
		if (!empty($this->mrkdwn)) {
			$params['mrkdwn'] = $this->mrkdwn;
		}
		if (!empty($this->attachments)) {
			$params['attachments'] = $this->attachments;
		}
		return $params;
	}

	private function postRequest($url, $params, $headers = array()) {

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$result = curl_exec($ch);
		$error = curl_error($ch);

		curl_close($ch);

		if ($error) {
		    throw new Exception($error);
		}
		return true;

	}

}