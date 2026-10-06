<?php $title = 'Home | ScholarHub';
require 'includes/header.php';
require 'config/db.php';
$s = $pdo->query('SELECT COUNT(*) FROM scholarships')->fetchColumn();
$u = $pdo->query('SELECT COUNT(*) FROM universities')->fetchColumn(); ?>

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <span class="badge text-bg-dark mb-3">
                    Study Abroad • Scholarships • Preparation
                </span>

                <h1>
                    Discover opportunities. Prepare smarter. Apply with confidence.
                </h1>

                <p class="lead text-secondary mt-3">
                    ScholarHub helps students find scholarships, universities
                    and preparation resources in one place.
                </p>

                <div class="d-flex gap-2 flex-wrap mt-4">
                    <a class="btn btn-primary btn-lg" href="scholarships.php">
                        Explore Scholarships
                    </a>

                    <a class="btn btn-outline-dark btn-lg" href="universities.php">
                        Browse Universities
                    </a>
                </div>
            </div>


            <div class="col-lg-5">

                <!-- Home Page Photo -->
                <img src="assets/images/home.jpeg"
                    alt="Study Abroad"
                    class="img-fluid rounded-4 shadow mb-4"
                    style="width:100%; height:280px; object-fit:cover;">

                <!-- Statistics -->
                <div class="card p-4">
                    <h4>ScholarHub at a glance</h4>

                    <div class="row text-center mt-3">

                        <div class="col-6">
                            <div class="stat"><?= $s ?></div>
                            <small>Scholarships</small>
                        </div>

                        <div class="col-6">
                            <div class="stat"><?= $u ?></div>
                            <small>Universities</small>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature">
                <h4>🎓 Scholarships</h4>
                <p class="text-secondary">Search funding opportunities and verify current details at the official source.</p><a href="scholarships.php">Explore →</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature">
                <h4>🏫 Universities</h4>
                <p class="text-secondary">Browse universities by country and visit official websites.</p><a href="universities.php">Browse →</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature">
                <h4>📝 Preparation</h4>
                <p class="text-secondary">Use document, application, visa and interview guides.</p><a href="prepare.php">Prepare →</a>
            </div>
        </div>
    </div>
</section>
<?php require 'includes/footer.php'; ?>