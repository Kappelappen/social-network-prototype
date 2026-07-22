<?php

$page = new PageHandler($pdo, 5);

$profileId = isset($_GET["id"])
    ? (int) $_GET["id"]
    : (int) $_SESSION["user_id"];



$sql = "
    SELECT
        c.comments,
        c.created_at,
        u.username

    FROM UserComments c

    INNER JOIN Users u
        ON u.id = c.user_id

    WHERE c.profile_id = :profile_id

    ORDER BY c.created_at DESC

    LIMIT :offset, :limit
";



$stmt = $pdo->prepare($sql);



$stmt->bindValue(
    ":profile_id",
    $profileId,
    PDO::PARAM_INT
);


$stmt->bindValue(
    ":offset",
    $page->getOffset(),
    PDO::PARAM_INT
);


$stmt->bindValue(
    ":limit",
    $page->getLimit(),
    PDO::PARAM_INT
);



$stmt->execute();



$html = "";



while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


    $username = htmlspecialchars(
        $row["username"],
        ENT_QUOTES,
        "UTF-8"
    );


    $comment = nl2br(
        htmlspecialchars(
            $row["comments"],
            ENT_QUOTES,
            "UTF-8"
        )
    );


    $date = htmlspecialchars(
        $row["created_at"],
        ENT_QUOTES,
        "UTF-8"
    );



    $html .= '

        <div class="comments-area">

            <div class="user-comment">
                '.$comment.'
            </div>


            <div class="username">
                Posted by: '.$username.'
            </div>


            <div class="input-date">
                '.$date.'
            </div>

        </div>

        <div class="spacer"></div>

    ';

}

$totalPages = $page->getTotalPages(
    "UserComments",
    "profile_id",
    $profileId
);

$html .= $page->render(
    $profileId,
    $totalPages
);

echo $html;

?>