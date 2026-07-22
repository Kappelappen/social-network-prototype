<h1 class="members-headline">Meet Members</h1>

<?php

$page = new PageHandler($pdo, 12);
$currentPage = $page->getCurrentPage();

$sql = "

    SELECT 
    t1.id,
    t1.username,
    t2.profile_image

    FROM Users t1
    LEFT JOIN ProfileImage t2
    ON t1.id = t2.user_id

    ORDER BY t1.id ASC
    LIMIT :offset, :limit

";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":offset",$page->getOffset(),PDO::PARAM_INT);
$stmt->bindValue(":limit",$page->getLimit(), PDO::PARAM_INT);
$stmt->execute();

$html = '<div class="members-grid">' . "\n";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $username = htmlspecialchars(
        $row["username"],
        ENT_QUOTES,
        "UTF-8"
    );

    $image = htmlspecialchars(
        $row["profile_image"] ?? "",
        ENT_QUOTES,
        "UTF-8"
    );

    $avatar = empty($image)
        ? "../uploads/profile/default.png"
        : "../uploads/profile/" . $image;

    $pid = (int)$row["id"];

    $html .= '

    <div class="member-card">
        <a href="../pages/profile.php?id='.$pid.'">
            <img src="'.$avatar.'" 
                 alt="Member">
        </a>

        <a href="../pages/profile.php?id='.$pid.'">
            '.$username.'
        </a>

    </div>

    ';
}

$html .= '</div>' . "\n";

$html .= '<div class="page-box">' . "\n";

$totalPages = $page->getTotalPages(
    "Users",
    "id",
    0
);

$html .= $page->render(
    0,$totalPages
);

$html .= '</div>' . "\n";
echo $html;

?>