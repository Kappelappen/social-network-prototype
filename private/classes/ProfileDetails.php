<?php

class ProfileDetails
{
    private PDO $pdo;

    private array $formError = [];

    private string $biography = "";
    private string $country = "";
    private string $city = "";
    private string $occupation = "";
    private string $website = "";
    private string $interests = "";
    private ?string $birthdate = null;
    private string $gender = "";
    private string $relationship = "";


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;


        if (
            $_SERVER["REQUEST_METHOD"] === "POST" &&
            isset($_POST["details"])
        ) {

            $this->readForm();

            $this->validate();


            if (empty($this->formError)) {

                $this->save();

            }
        }
    }



    private function readForm(): void
    {
        $this->biography = trim(
            strip_tags($_POST["biography"] ?? "")
        );

        $this->country = trim(
            strip_tags($_POST["country"] ?? "")
        );

        $this->city = trim(
            strip_tags($_POST["city"] ?? "")
        );

        $this->occupation = trim(
            strip_tags($_POST["occupation"] ?? "")
        );

        $this->website = trim(
            strip_tags($_POST["website"] ?? "")
        );

        $this->interests = trim(
            strip_tags($_POST["interests"] ?? "")
        );


        $birthday = trim(
            strip_tags($_POST["birthday"] ?? "")
        );


        $this->birthdate = 
            $birthday !== "" 
            ? $birthday 
            : null;


        $this->gender = trim(
            strip_tags($_POST["gender"] ?? "")
        );


        $this->relationship = trim(
            strip_tags($_POST["relationship"] ?? "")
        );
    }





    public function getDetail(string $name): string
    {

        $userId = isset($_SESSION["user_id"])
            ? (int)$_SESSION["user_id"]
            : 1;


        $sql = "
            SELECT *
            FROM ProfileDetails
            WHERE user_id = :id
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([
            "id" => $userId
        ]);


        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        return $row[$name] ?? "";

    }





    private function validate(): void
    {

        if (strlen($this->biography) > 500) {

            $this->formError[] =
                "Biography may not contain more than 500 characters.";

        }

        if (
            $this->website !== "" &&
            !filter_var(
                $this->website,
                FILTER_VALIDATE_URL
            )
        ) {

            $this->formError[] =
                "Website must be a valid URL.";

        }

        if ($this->birthdate !== null) {

            $date = DateTime::createFromFormat(
                "Y-m-d",
                $this->birthdate
            );


            if (
                !$date ||
                $date->format("Y-m-d") !== $this->birthdate
            ) {

                $this->formError[] =
                    "Invalid birth date.";

            }
        }
    }

    private function save(): void
    {

        if ($this->detailsExist()) {

            $this->updateDetails();

        } else {

            $this->insertDetails();

        }


        header("Location: ../pages/details.php");
        exit;

    }

    private function detailsExist(): bool
    {

        $sql = "
            SELECT COUNT(*)
            FROM ProfileDetails
            WHERE user_id = :user_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "user_id" => $_SESSION["user_id"]
        ]);


        return (bool)$stmt->fetchColumn();

    }

    private function insertDetails(): void
    {

        $sql = "
            INSERT INTO ProfileDetails
            (
                user_id,
                biography,
                country,
                city,
                occupation,
                website,
                interests,
                birthday,
                gender,
                relationship_status
            )

            VALUES
            (
                :user_id,
                :biography,
                :country,
                :city,
                :occupation,
                :website,
                :interests,
                :birthday,
                :gender,
                :relationship_status
            )
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([

            "user_id" => $_SESSION["user_id"],
            "biography" => $this->biography,
            "country" => $this->country,
            "city" => $this->city,
            "occupation" => $this->occupation,
            "website" => $this->website,
            "interests" => $this->interests,
            "birthday" => $this->birthdate,
            "gender" => $this->gender,
            "relationship_status" => $this->relationship

        ]);

    }

    private function updateDetails(): void
    {

        $sql = "
            UPDATE ProfileDetails

            SET

                biography = :biography,
                country = :country,
                city = :city,
                occupation = :occupation,
                website = :website,
                interests = :interests,
                birthday = :birthday,
                gender = :gender,
                relationship_status = :relationship_status

            WHERE user_id = :user_id
        ";


        $stmt = $this->pdo->prepare($sql);


        $stmt->execute([

            "biography" => $this->biography,
            "country" => $this->country,
            "city" => $this->city,
            "occupation" => $this->occupation,
            "website" => $this->website,
            "interests" => $this->interests,
            "birthday" => $this->birthdate,
            "gender" => $this->gender,
            "relationship_status" => $this->relationship,
            "user_id" => $_SESSION["user_id"]

        ]);

    }

    public function showDetailsError(): void
    {

        if (empty($this->formError)) {

            return;

        }


        echo '<div class="form-message">';
        echo '<ul>';


        foreach ($this->formError as $error) {

            echo '<li>' .
            htmlspecialchars($error) .
            '</li>';

        }


        echo '</ul>';
        echo '</div>';

    }

    public function getBiography(): string
    {
        return htmlspecialchars($this->biography);
    }


    public function getCountry(): string
    {
        return htmlspecialchars($this->country);
    }


    public function getCity(): string
    {
        return htmlspecialchars($this->city);
    }


    public function getOccupation(): string
    {
        return htmlspecialchars($this->occupation);
    }


    public function getWebsite(): string
    {
        return htmlspecialchars($this->website);
    }


    public function getInterests(): string
    {
        return htmlspecialchars($this->interests);
    }


    public function getBirthdate(): string
    {
        return htmlspecialchars(
            $this->birthdate ?? ""
        );
    }


    public function getGender(): string
    {
        return htmlspecialchars($this->gender);
    }


    public function getRelationship(): string
    {
        return htmlspecialchars($this->relationship);
    }
}

?>