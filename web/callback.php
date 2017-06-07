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


if (isHello($text)) {
    $response = buildPlainTextMessage("こんちは！");
    sendMessage($response);
    exit;
}


//返信データ作成
if ($text == 'はい') {
    $response_format_text = [
        "type" => "template",
        "altText" => "こちらの〇〇はいかがですか？?",
        "template" => [
            "type" => "buttons",
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
            "title" => "○○レストラン",
            "text" => "お探しのレストランはこれですね?",
            "actions" => [
                [
                    "type" => "postback",
                    "label" => "予約する",
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
                    "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
                ],
                [
                    "type" => "message",
                    "label" => "違うやつ",
                    "text" => "違うやつお願い"
                ]
            ]
        ]
    ];
} else if ($text == 'いいえ') {
    exit;
} else if ($text == '違うやつお願い') {
    $response_format_text = [
        "type" => "template",
        "altText" => "候補を３つご案内しています。",
        "template" => [
            "type" => "carousel",
            "columns" => [[
                "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
                "title" => "●●レストラン",
                "text" => "こちらにしますか？",
                "actions" => [
                    [
                        "type" => "postback",
                        "label" => "予約する",
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
                        "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
                    ]
                ]
            ],
                [
                    "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
                    "title" => "▲▲レストラン",
                    "text" => "それともこちら？（２つ目）",
                    "actions" => [
                        [
                            "type" => "postback",
                            "label" => "予約する",
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
                            "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
                        ]
                    ]
                ],
                [
                    "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
                    "title" => "■■レストラン",
                    "text" => "はたまたこちら？（３つ目）",
                    "actions" => [
                        [
                            "type" => "postback",
                            "label" => "予約する",
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
                            "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
                        ]
                    ]
                ]
            ]
        ]
    ];
} else {
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
}

sendMessage($response_format_text);
