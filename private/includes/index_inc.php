<div class="dashboard">

    <section class="hero">

        <h1>
            Connect the Digital World
        </h1>

        <p>
            A simple social networking platform where people can meet,
            share and connect.
        </p>

    </section>


    <section class="dashboard-grid">


        <div class="card about-card">

            <h2>
                About This Project
            </h2>

            <p>
                This is a demonstration social platform built with PHP
                and MySQL. The purpose is to explore user accounts,
                profiles and communication between members.
            </p>

        </div>



        <div class="card statistics-card">

            <h2>
                Platform Statistics
            </h2>


            <div class="stats">

                <div class="stat-box">

                    <span>
                        Members
                    </span>

                    <strong>
                        <?= $dashboard->getMemberCount(); ?>
                    </strong>

                </div>

                <div class="stat-box">

                    <span>
                        Comments
                    </span>

                    <strong>
                       <?= $dashboard->getCommentsCount(); ?>
                    </strong>

                </div>

            </div>

        </div>


    </section>

    <section class="card">

        <h2>
            Latest Members
        </h2>

        <div class="members-preview">
            
            <?php $dashboard->fetchLatestMembers(3); ?>

        </div>

    </section>

    <section class="card">


        <h2>
            Recent Activity
        </h2>


        <div class="activity">


            <p>
                John commented on Anna's profile.
            </p>


            <p>
                Maria joined the community.
            </p>


            <p>
                Peter updated his profile.
            </p>


        </div>


    </section>

    <section class="card vision">


        <h2>
            My Vision
        </h2>


        <p>
            Creating a welcoming digital meeting place where people
            can introduce themselves, discover others and communicate
            in a simple environment.
        </p>


    </section>


</div>