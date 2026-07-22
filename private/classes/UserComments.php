<?php

class UserComments
{
    private PDO $pdo;
    private ?int $userId;
    public array $errors = [];


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->userId = isset($_SESSION["user_id"])
            ? (int) $_SESSION["user_id"]
            : null;

        if (isset($_POST["comments"])) {

            $data = stripslashes(strip_tags($_POST["comments"]));
            $pid = isset($_GET["id"]) ? intval($_GET["id"]) : $_SESSION["user_id"];
            $this->saveComment($data,$pid);

            header("Location: ../pages/profile.php?id=" . $this->userId);
            exit;

        }
    }


    public function saveComment(string $comment, int $profileId): bool
    {
        if ($this->userId === null) {

            $this->errors[] = "You must be logged in.";

            return false;
        }

        $comment = trim(strip_tags($comment));

        if ($comment === "") {

            $this->errors[] = "Please write a comment.";

            return false;
        }

        if (mb_strlen($comment) > 250) {

            $this->errors[] = "Comments cannot exceed 250 characters.";

            return false;
        }

        $sql = "
            INSERT INTO UserComments
            (
                user_id,
                profile_id,
                comments
            )
            VALUES
            (
                :user_id,
                :profile_id,
                :comments
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            "user_id"    => $this->userId,
            "profile_id" => $profileId,
            "comments"   => $comment
        ]);

    }

    public function fetchComments(int $profileId): string
    {
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

        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "profile_id" => $profileId
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {

            return "<p>No comments yet.</p>";
        }

        $html = "";

        foreach ($rows as $row) {

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

            $html .= "
                <div class='comments-area'>

                    <div class='user-comment'>
                        {$comment}
                    </div>

                    <div class='username'>
                        Posted by: {$username}
                    </div>

                    <div class='input-date'>
                        {$date}
                    </div>

                </div>

                <div class='spacer'></div>
            ";
        }

        return $html;
    }


    public function getErrors(): string
    {
        if (empty($this->errors)) {

            return "";
        }

        $html = "";

        foreach ($this->errors as $error) {

            $html .= "<div class=\"error-note\">{$error}</div>";
        }

        return $html;
    }
}