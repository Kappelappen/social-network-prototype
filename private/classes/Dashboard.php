<?php

    class Dashboard 
    {

        private $pdo;

        public function __construct($pdo) {
            
            $this->pdo = $pdo;

        }

        public function getMemberCount(): int 
        {

            $sql = "
                
                SELECT COUNT(*) AS members
                FROM Users
            
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $count["members"];
            
        }

        public function getCommentsCount(): int 
        {

            $sql = "

                SELECT COUNT(*) AS comments
                FROM UserComments            
            
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $count["comments"];
            
        }

        public function fetchLatestMembers($total): void 
        {

            $sql = "

            SELECT 
            t1.id,
            t1.username,
            t2.profile_image

            FROM Users t1
            LEFT JOIN ProfileImage t2
            ON t1.id = t2.user_id

            ORDER BY t1.id ASC
            LIMIT $total

            ";

            $html = NULL;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $image = $row["profile_image"];
                $username = $row["username"];

                $avatar = empty($image)
                ? "uploads/profile/default.png"
                : "uploads/profile/" . $image;

                $html .= '<div class="member-card">' . "\n";
                $html .= '<img src="' . $avatar . '">' . "\n";
                $html .= '<p>' . $username . '</p>' . "\n";
                $html .= '</div>' . "\n";

            }

            echo $html;

        }
    }
?>