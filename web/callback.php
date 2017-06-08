<?php
require_once "functions.php";

$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
if (empty($accessToken)) {
    exit;
}

//get message from user.
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

// get reply token
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
if (empty($replyToken)) {
    exit;
}

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
if ($type != "text") {
    // if not message nothing to do.
    exit;
}

// get text message.
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};


//返信データ作成
if ($text == 'はい') {
    $response_format_text = buildPartner1();
} else if ($text == 'いいえ') {
    exit;
} else if ($text == '違うやつお願い') {
    $response_format_text = buildPartner234();
} else if ($text == '他の人') {
    $response_format_text = buildPartner1();
} else if ($text == "オープン信者の率先垂範リーダーとチャットする") {
    $response_format_text = taikaiQuestion();
} else if ($text ==  "退会したのに課金される" ){
    $response_format_text = taikaiQuestion2();
} else {
    $response_format_text = buildInitialMessage();
}

sendMessage($response_format_text);
