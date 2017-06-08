<?php
/**
 * Created by IntelliJ IDEA.
 * User: furuyamah
 * Date: 07/06/17
 * Time: 4:59 PM
 */

/**
 * @param $replyToken
 * @param $response_format_text
 * @param $accessToken
 */
function sendMessage($response_format_text)
{
    global $replyToken;
    global $accessToken;

    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];

    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    curl_exec($ch);
    curl_close($ch);
}


function isHello($message)
{
    switch ($message) {
        case "こんにちは":
        case "こんばんは":
        case "おはよう":
        case "hello":
            return true;
    }

    return false;
}

function buildPlainTextMessage($message)
{
    $response_format_text = [
        "type" => "text",
        "text" => $message,
    ];

    return $response_format_text;
}

function getTaitokuTenki()
{
    $json_data = file_get_contents(' api.openweathermap.org/data/2.5/find?q=London');
    $data = json_decode($json_data);

    // apiの使用法がかわったらしくだめ
    return 'お天気は「' . $data->weather[0]->description . '」らしいです。';

}

function buildInitialMessage()
{
    $response_format_text = [
        "type" => "template",
        "altText" => "こんにちわ 何かご用ですか？（はい／いいえ）",
        "template" => [
            "type" => "confirm",
            "text" => "こんにちわ 何かご用ですか？",
            "actions" => [
                [
                    "type" => "message",
                    "label" => "はい",
                    "text" => "はい"
                ],
                [
                    "type" => "message",
                    "label" => "いいえ",
                    "text" => "いいえ"
                ]
            ]
        ]
    ];

    return $response_format_text;

}
