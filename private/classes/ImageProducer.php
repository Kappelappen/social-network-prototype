<?php

class ImageProducer
{

    private string $folder = "../uploads/profile/";


    public function uploadProfileImage(array $file, ?string $oldImage): string
    {


        /*
            Kontrollera fil
        */

        if ($file["error"] !== UPLOAD_ERR_OK) {

            throw new Exception(
                "Upload failed"
            );

        }



        /*
            Kontrollera bildtyp
        */

        $allowed = [

            "image/jpeg",
            "image/png",
            "image/webp"

        ];


        if (!in_array($file["type"], $allowed)) {

            throw new Exception(
                "Only images are allowed"
            );

        }



        /*
            Ta bort gammal bild
        */

        if (
            $oldImage !== null &&
            file_exists($this->folder . $oldImage)
        ) {

            unlink(
                $this->folder . $oldImage
            );

        }



        /*
            Skapa nytt filnamn
        */

        $extension = pathinfo(
            $file["name"],
            PATHINFO_EXTENSION
        );


        $filename = uniqid(
            "profile_"
        ) . "." . $extension;

        $destination = $this->folder . $filename;

        if (!move_uploaded_file(

            $file["tmp_name"],
            $destination

        )) {

            throw new Exception(
                "Could not move uploaded file"
            );
        }

        return $filename;

    }

}

?>