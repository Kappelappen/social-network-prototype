<?php

class SelectMenu
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function makeSelectMenu(
        string $currentValue,array $list,
        string $headline,string $name): void {

        echo '<label for="' . htmlspecialchars($name) . '">';
        echo htmlspecialchars($headline);
        echo '</label>';

        echo '<select name="' . htmlspecialchars($name) . '" ';
        echo 'id="' . htmlspecialchars($name) . '" ';
        echo 'class="combobox">';


        foreach ($list as $key => $text) {

            $value = is_int($key) ? $text : $key;

            $selected = ($value === $currentValue)
                ? ' selected'
                : '';

            echo '<option value="' .
                htmlspecialchars($value) .
                '"' .
                $selected .
                '>';

            echo htmlspecialchars($text);
            echo '</option>';
        }


        echo '</select>';
    }

    public function updateVisibility(): void
    {
        $visibility = $_POST['visibility'] ?? 'private';
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            throw new Exception("Ingen användare inloggad.");
        }

        $sql = "
            UPDATE users
            SET profile_visibility = :visibility
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "visibility" => $visibility,
            "id" => $userId
        ]);
    }

    public function updateCountry(): void
    {
        $country = $_POST['country'] ?? 'Sweden';
        $userId = $_SESSION['user_id'] ?? null;


        if (!$userId) {
            throw new Exception("Ingen användare inloggad.");
        }


        $sql = "
            UPDATE ProfileDetails
            SET country = :country
            WHERE user_id = :user_id
        ";


        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "country" => $country,
            "user_id" => $userId
        ]);
    }

    public function updateGender(): void 
    {

        $visibility = $_POST['gender'] ?? 'Other';
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            throw new Exception("Ingen användare inloggad.");
        }

        $sql = "
            UPDATE ProfileDetails
            SET gender = :gender
            WHERE user_id = :user_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "gender" => $visibility,
            "user_id" => $userId
        ]);
    }

    public function updateRelationShip(): void 
    {

        $visibility = $_POST['relationship'] ?? 'Single';
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            throw new Exception("Ingen användare inloggad.");
        }

        $sql = "
            UPDATE ProfileDetails
            SET relationship = :relationship
            WHERE user_id = :user_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "relationship" => $visibility,
            "user_id" => $userId
        ]);
    }

    public function getCurrentCountry(): string
    {
        $userId = $_SESSION['user_id'] ?? 0;


        $sql = "
            SELECT country
            FROM ProfileDetails
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "user_id" => $userId
        ]);


        $country = $stmt->fetchColumn();


        return $country ?: "Sweden";
    }

    public function getCurrentVisibility(): string
    {
        $userId = $_SESSION['user_id'] ?? 0;


        $sql = "
            SELECT profile_visibility
            FROM users
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "id" => $userId
        ]);


        $visibility = $stmt->fetchColumn();
        return $visibility ?: "public";

    }

    public function getCurrentGender(): string
    {
        $userId = $_SESSION['user_id'] ?? 0;

        $sql = "
            SELECT gender
            FROM ProfileDetails
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "user_id" => $userId
        ]);

        $gender = $stmt->fetchColumn();
        return $gender ?: "Female";

    }

    public function getCurrentRelation(): string
    {
        $userId = $_SESSION['user_id'] ?? 0;

        $sql = "
            SELECT relationship_status
            FROM ProfileDetails
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "user_id" => $userId
        ]);

        $gender = $stmt->fetchColumn();
        return $gender ?: "Single";

    }

    public function getVisibilityOptions(): array
    {
        return [

            "public" => "Public Profile - Everyone can see my profile",
            "friends" => "Friends Only - Only friends can see my profile",
            "private" => "Private Profile - Only me"

        ];
    }



    public function getCountryList(): array
    {
        return [

            "Sweden" => "Sweden",
            "Norway" => "Norway",
            "Denmark" => "Denmark",
            "Finland" => "Finland",
            "Germany" => "Germany"

        ];
    }

    public function getGenderList(): array 
    {

        return [

            "Prefer not to say" => "Prefer not to say",
            "Female" => "Female",
            "Male" => "Male",
            "Non-Binary" => "Non-binnary",
            "Other" => "Other"

        ];
    }

    public function getRelationShips(): array
    {
        return [

            "Single" => "Single",
            "In a relationship" => "In a relationship",
            "Married" => "Married"

        ];
    }
}

?>