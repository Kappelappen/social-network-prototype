
<?php $self = htmlspecialchars($_SERVER["PHP_SELF"]); ?>

<div class="form-area">

    <?php

        if ($_POST) {

            $details->showDetailsError();

        }

    ?>


    <h1>Profile Details</h1>

    <p class="details-info">Add some optional information to personalize your profile.</p>

    <form method="post" action="<?php echo $self; ?>">

        <div class="form-group">
            
        <?php

                if (isset($_POST["biography"])) {

                    $text->updateBiography();

                }

                $text->makeTextArea("Biography", "biography");

            ?>    
    
        </div>


        <div class="form-group">

            <?php 

                if (isset($_POST["country"])) {
                    
                    $select->updateCountry();
                
                }
            
                $select->makeSelectMenu(
                $select->getCurrentCountry(),
                $select->getCountryList(),
                "Home Country","country");

            ?>

        </div>


        <div class="form-group">

            <?php

                if (isset($_POST["city"])) {

                    $text->updateCity();

                }

                $text->makeTextField("Home City", 
                "city", "Your City");

            ?>

        </div>


        <div class="form-group">

            <?php

                if (isset($_POST["occupation"])) {

                    $text->updateOccupation();

                }

                $text->makeTextField("Occupation", 
                "occupation", "Your Occupation");

            ?>

        </div>


        <div class="form-group">

            <?php

                if (isset($_POST["website"])) {

                    $text->updateWebsite();

                }

                $text->makeTextField("Website (URL-address)", 
                "website", "Website");

            ?>

        </div>


        <div class="form-group">

            <?php

                if (isset($_POST["interests"])) {

                    $text->updateInterests();

                }

                $text->makeTextField("Interests", 
                "interests", "Photography, Music, Coding");

            ?>

        </div>


        <div class="form-group">

            <?php

                if (isset($_POST["birthday"])) {

                    $text->updateBirthdate();

                }

                $text->makeDateField("Birthday", "birthday");

            ?>

        </div>


        <div class="form-group">

            <?php 

                if (isset($_POST["gender"])) {
                    
                    $select->updateGender();
                
                }
            
                $select->makeSelectMenu(
                $select->getCurrentGender(),
                $select->getGenderList(),
                "Gender","gender");

            ?>

        </div>


        <div class="form-group">

            <?php 

                if (isset($_POST["relationship"])) {
                    
                    $select->updateRelationShip();
                
                }
            
                $select->makeSelectMenu(
                $select->getCurrentRelation(),
                $select->getRelationShips(),
                "Relationship status","relationship");

            ?>

        </div>

        <input type="submit" name="details" class="save-btn" value="Save">

    </form>

</div>