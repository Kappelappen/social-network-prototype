<?php

class ImageWorker
{
    private PDO $pdo;
    private string $uploadDir;

    public function __construct(PDO $pdo, string $uploadDir)
    {
        $this->pdo = $pdo;
        $this->uploadDir = rtrim($uploadDir, "/") . "/";

        if (!is_dir($this->uploadDir)) {

            mkdir($this->uploadDir, 0755, true);

        }
    }


    public function processImage(
        string $filePath, int $newWidth,
        int $newHeight,int $userId): string {

        if (!file_exists($filePath)) {

            throw new Exception("Could not find the image.");

        }


        // Ta bort tidigare profilbild
        $this->deleteOldImage($userId);

        $imageInfo = getimagesize($filePath);

        if ($imageInfo === false) {

            throw new Exception("The uploaded file is not an image.");

        }


        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo[2];

        switch ($type) {

            case IMAGETYPE_JPEG:

                $srcImg = imagecreatefromjpeg($filePath);
                $ext = ".jpg";

            break;


            case IMAGETYPE_PNG:

                $srcImg = imagecreatefrompng($filePath);
                $ext = ".png";

            break;


            case IMAGETYPE_GIF:

                $srcImg = imagecreatefromgif($filePath);
                $ext = ".gif";

            break;


            case IMAGETYPE_WEBP:

                $srcImg = imagecreatefromwebp($filePath);
                $ext = ".webp";

            break;


            default:

                throw new Exception(
                    "Only JPG, PNG, GIF and WEBP are supported."
                );

        }


        $dstImg = imagecreatetruecolor(
            $newWidth,
            $newHeight
        );


        // Behåll transparens för PNG/WebP
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);


        imagecopyresampled(

            $dstImg,
            $srcImg,

            0,
            0,
            0,
            0,

            $newWidth,
            $newHeight,

            $width,
            $height

        );

        $newFileName =
            "profile_" .
            bin2hex(random_bytes(8)) .
            $ext;

        $savePath =
            $this->uploadDir .
            $newFileName;

        switch ($type) {

            case IMAGETYPE_JPEG:

                imagejpeg(
                    $dstImg,
                    $savePath,
                    90
                );

            break;


            case IMAGETYPE_PNG:

                imagepng(
                    $dstImg,
                    $savePath
                );

            break;


            case IMAGETYPE_GIF:

                imagegif(
                    $dstImg,
                    $savePath
                );

            break;


            case IMAGETYPE_WEBP:

                imagewebp(
                    $dstImg,
                    $savePath,
                    90
                );

            break;

        }

        imagedestroy($srcImg);
        imagedestroy($dstImg);

        $stmt = $this->pdo->prepare(

        "INSERT INTO ProfileImage " . 
        "(user_id, profile_image,created_at) " .
        "VALUES (:user_id,:profile_image,NOW())");

        $stmt->execute([

        "user_id" => $userId,
        "profile_image" => $newFileName

        ]);

        return $newFileName;

    }



    private function deleteOldImage(int $userId): void
    {

        $stmt = $this->pdo->prepare(

            "SELECT profile_image
             FROM ProfileImage
             WHERE user_id = :user_id
             LIMIT 1"

        );


        $stmt->execute([

            "user_id" => $userId

        ]);


        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$row) {

            return;

        }


        $file =
            $this->uploadDir .
            $row["profile_image"];

        if (file_exists($file)) {

            unlink($file);

        }


        $stmt = $this->pdo->prepare(

            "DELETE FROM ProfileImage
             WHERE user_id = :user_id"

        );


        $stmt->execute([

            "user_id" => $userId

        ]);
    }
}