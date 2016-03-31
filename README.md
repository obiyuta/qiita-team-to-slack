# qiita-team-to-slack

Qiita:TeamからSlackへの通知をメンバーに応じてチャンネルを指定して行うことができます。

## 対応している通知イベント

現在はQiita:Teamからの以下の通知イベントに対応しています

- 投稿の新規作成通知
- コメントの新規作成通知

コメントについてはコメントを作成したユーザーではなく、元々の投稿者の指定されているチャンネルに通知されます。（#devのAの投稿に#salesのBがコメントした場合は#devに投稿される）


## 設定

※URLの設定や取得の詳しい方法は[こちら](http://qiita.com/obi_yuta/items/5976f345fa7918c8d59d)をご参照ください

1. Qiita:TeamのWebhookの設定に通知先のURLを設定

2. SlackのIncoming Webhooksから通知用のURLを取得

3. config/setting.phpを編集して必要な設定を記述

```
# Qiita:TeamのURLを指定
define('QIITA_BASE_URL', 'https://xxxx.qiita.com');

# SlackのIncoming Webhooksで取得したwebhook URLを指定
define('SLACK_WEBHOOK_URL', 'https://hooks.slack.com/services/xxx');

# Slackのチャンネルとそのチャンネルに通知するQiitaのユーザー名を指定
$members = array(
    'SLACK_CHANNEL_NAME' => array(
        'QIITA_USERNAME'
    ),
);
```

最後のチャネル指定については、指定がないユーザーは一律#generalに通知されます。



## 使い方

QiitaTeamSlackを読み込んで、Qiita:Teamからの通知内容を使って初期化した後、通知処理を行うだけです。

```
require 'QiitaTeamSlack.php';

$payload = json_decode(file_get_contents('php://input'));

try {
    $qiitaTeamSlack = new QiitaTeamSlack($payload);
} catch (Exception $e) {
    echo $e->getMessage();
}

$qiitaTeamSlack->send();
```
