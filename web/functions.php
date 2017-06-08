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

function buildPartner1()
{
    $response_format_text = [
        "type" => "template",
        "altText" => "反権威主義",
        "template" => [
            "type" => "buttons",
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/keiji.png",
            "title" => "反権威主義！オープン信者の率先垂範リーダー",
            "text" => "私にご相談ください",
            "actions" => [
                [
                    "type" => "postback",
                    "label" => "チャットする",
                    "data" => "action=buy&itemid=123"
                ],
                [
                    "type" => "postback",
                    "label" => "電話する",
                    "data" => "action=pcall&itemid=123"
                ],
                [
                    "type" => "uri",
                    "label" => "詳しく見る",
                    "uri" => "https://blog.isao.co.jp/author/nakamurak/"
                ],
                [
                    "type" => "message",
                    "label" => "違うやつ",
                    "text" => "違うやつお願い"
                ]
            ]
        ]
    ];

    return $response_format_text;

}

function buildPartner234()
{
    $response_format_text = [
        "type" => "template",
        "altText" => "候補を３人ご案内しています。",
        "template" => [
            "type" => "carousel",
            "columns" => [
                [
                    "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/aimi.png",
                    "title" => "時代をエグる元赤文字系読モディレクター",
                    "text" => "こちらにしますか？",
                    "actions" => [
                        [
                            "type" => "postback",
                            "label" => "チャットする",
                            "data" => "action=rsv&itemid=111"
                        ],
                        [
                            "type" => "postback",
                            "label" => "電話する",
                            "data" => "action=pcall&itemid=111"
                        ],
                        [
                            "type" => "uri",
                            "label" => "詳しく見る（ブラウザ起動）",
                            "uri" => "https://blog.isao.co.jp/author/nakajimaa/"
                        ]
                    ]
                ],
                [
                    "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/toshiki.png",
                    "title" => "小難しく語らない熱狂的グロースハッカー",
                    "text" => "それともこちら？（２人目）",
                    "actions" => [
                        [
                            "type" => "postback",
                            "label" => "チャットする",
                            "data" => "action=rsv&itemid=222"
                        ],
                        [
                            "type" => "postback",
                            "label" => "電話する",
                            "data" => "action=pcall&itemid=222"
                        ],
                        [
                            "type" => "uri",
                            "label" => "詳しく見る（ブラウザ起動）",
                            "uri" => "https://www.wantedly.com/projects/10137/staffings/34172#/_=_"
                        ]
                    ]
                ],
                [
                    "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/hiroshi.png",
                    "title" => "自転車は恋人妻は妻育児系プログラマー",
                    "text" => "はたまたこちら？（３人目）",
                    "actions" => [
                        [
                            "type" => "postback",
                            "label" => "チャットする",
                            "data" => "action=rsv&itemid=333"
                        ],
                        [
                            "type" => "postback",
                            "label" => "電話する",
                            "data" => "action=pcall&itemid=333"
                        ],
                        [
                            "type" => "uri",
                            "label" => "詳しく見る（ブラウザ起動）",
                            "uri" => "https://blog.isao.co.jp/author/furuyamah/"
                        ],
                        [
                            "type" => "message",
                            "label" => "最初のひと",
                            "text" => "やっぱり最初の人お願い"
                        ]
                    ]
                ]
            ]
        ]
    ];

    return $response_format_text;
}
