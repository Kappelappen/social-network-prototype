<?php $self = htmlspecialchars($_SERVER["PHP_SELF"]); ?>

<div class="profile-container">


    <div class="profile-layout">

        <aside class="profile-sidebar">

            <div class="profile-card">

                <div class="avatar">

                    <img src="<?= $profile->avatar; ?>" alt="Profile picture">

                </div>

                <h1>
                    <?= $profile->getUsername(); ?>
                </h1>

                <p class="location">
                    <?= $profile->getCity() ?>, <?= $profile->getCountry(); ?>
                </p>

                <p class="status"><?= $profile->getOccupation(); ?> </p>


                <button class="primary-button" onClick="alert('Not yet implemented');">
                    Add Friend
                </button>


                <button class="secondary-button" onClick="alert('Not yet implemented');">
                    Message
                </button>


            </div>

            <div class="card">

                <h2>
                    About
                </h2>

                <div class="info-row">

                    <span>
                        <?= $profile->getCity(); ?>
                    </span>

                    <strong>
                        <?= $profile->getCountry(); ?>
                    </strong>

                </div>

                <div class="info-row">

                    <span>
                        Birthday
                    </span>

                    <strong>
                        <?= $profile->getBirthdate(); ?>
                    </strong>

                </div>

                <div class="info-row">

                    <span>
                        Member since
                    </span>

                    <strong>
                        <?= $profile->getJoinYear(); ?>
                    </strong>

                </div>

                <div class="info-row">

                    <span>
                        Gender
                    </span>

                    <strong>
                        <?= $profile->getGender(); ?>
                    </strong>

                </div>

                <div class="info-row">

                    <span>
                        Relationship
                    </span>

                    <strong>
                        <?= $profile->getRelationshipStatus(); ?>
                    </strong>

                </div>

            </div>
        </aside>

        <main class="profile-content">

            <section class="card">

                <h2>
                    Small Biography
                </h2>

                <p><?= $profile->getBiography(); ?></p>

            </section>

            <section class="card">


                <h2>
                    Interests
                </h2>


                <div class="tags">

                    <?php $profile->createTags(); ?>

                </div>

            </section>

            <section class="card">

                <article class="post">

                    <form name="profile_form" action="<?= htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">   

                        <div class="form-group">
                            
                            <h2>Comments</h2>

                            <textarea rows="6" cols="65" id="comments" name="comments"></textarea>
                        </div>                       

                        <div class="form-group">
                            <input type="submit" name="write" value="Write" class="comments-btn">
                        </div>

                    </form>

                    <div class="comments-area">
                        
                        <?php 

                            if (isset($_GET["id"])) {

                                require_once ("profile_paging_inc.php");

                            } 

                        ?>
                    </div>

                </article>

            </section>
        </main>
    </div>
</div>