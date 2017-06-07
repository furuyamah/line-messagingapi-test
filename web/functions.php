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
function sendMessage($replyToken, $response_format_text, $accessToken)
{
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
    $result = curl_exec($ch);
    curl_close($ch);
}
