<?php

    class ProfileManager 
    {

        private $pdo;
        private $userId;
        public $content;
        public $avatar;
        public $profileImage;

        public function __construct($pdo) 
        {

            $this->pdo = $pdo;
  
            $this->userId = isset($_SESSION["user_id"]) ? 
            intval($_SESSION["user_id"]) : NULL;          
            
            $this->content = $this->getProfileInfo();

            $this->avatar = !empty($this->content['avatar']) ? 
            '../uploads/profile/' . $this->content['avatar']
            : '../uploads/profile/default.png';
                       
        
        }

        private function getProfileInfo(): array
        {
        
            $sql = "
                SELECT
                    t1.*,
                    t2.*,
                    t3.profile_image AS avatar
                FROM Users t1
                LEFT JOIN ProfileDetails t2
                    ON t1.id = t2.user_id
                LEFT JOIN ProfileImage t3
                    ON t3.user_id = t1.id
                WHERE t1.id = :id
                LIMIT 1
            ";

            $uid = isset($_GET['id'])
                ? (int) $_GET['id']
                : (int) $this->userId;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $uid
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: [];
        
        }  

        private function getProfileImage(): ? string
        {

            $result = NULL;
            $data = $this->getProfileInfo();

            if (!$data) {

                $result = "../uploads/profile/default.png";

            }

            $result = "../uploads/profile/" . $data["profile_image"];
            return $result;

        }

        private function getEmailAddress() 
        {

            $result = NULL;

            $result = $this->content["email"]; 

            if (empty($result)) {

                $result = "Your e-mail-address";

            }

            return $result;

        }

        public function getUsername() 
        {
            
            $result = $this->content["username"];
            return $result;

        }

        public function getJoinYear(): string
        {
    
            if (empty($this->content["created_at"]) ||
            $this->content["created_at"] === "0000-00-00 00:00:00" ||
            $this->content["created_at"] === "0000-00-00") {

                return "";

            }

            $timestamp = strtotime(
                $this->content["created_at"]
            );

            if ($timestamp === false) {

                return "";

            }

            return date(
                "Y",
                $timestamp
            );
        }

        public function getOccupation() 
        {

            $result = $this->content["occupation"];

            if (empty($result)) {

                $result = "Your Occupation";

            }

            return $result;


        }
        
        public function getBirthdate(): string
        {
    
            if (empty($this->content["birthday"])) {

                return "";

            }

            $timestamp = strtotime(
                $this->content["birthday"]
            );


            if ($timestamp === false) {

                return "";

            }


            return date(
                "Y-m-d",
                $timestamp
            );
        }

        public function getCity() {

            $result = $this->content["city"];

            if (empty($result)) {

                $result = "City";

            }            

            return $result;

        }

        public function getCountry() 
        {

            $result = $this->content["country"];
            
            if (empty($result)) {

                $result = "Country";

            }

            return $result;

        }

        public function getRelationshipStatus() 
        {

            $result = $this->content["relationship_status"];
            
            if (empty($result)) {

                $result = "Unknown";

            }

            return $result;

        }

        public function getGender() 
        {

            $result = $this->content["gender"];
            
            if (empty($result)) {

                $result = "Unknown";

            }

            return $result;

        }

        public function getBiography() 
        {

            $result = NULL;
            $biography = $this->content["biography"];

            if (isset($biography)) {

                $result = wordwrap($biography,500,'<br />');

            }

            if (empty($biography)) {

                $result = "Your biography goes here";

            }

            return $result;

        }

        public function createTags() 
        {
            
            $result = $this->content["interests"];

            if (isset($result)) {

                if ($result == NULL) return;
                $array = $this->stringToArray($result);

                foreach ($array as $item) {

                    $line = '<span>' . $item . '</span>' . "\n";
                    echo $line;

                }
            }

            if (empty($result)) {

                $msg = 'Commma-separated values goes here' . "\n";
                echo $msg;

            }
        }

        private function stringToArray(string $text): array
        {
        
            $array = explode(',', $text);
            $array = array_map('trim', $array);
            $array = array_filter($array);

            return array_values($array);
        
        }
    }

?>