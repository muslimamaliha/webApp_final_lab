<?php
$title = 'Test Preparation | ScholarHub';
require 'includes/header.php';

$tests = [

    'IELTS' => [
        'description' => 'International English language test commonly used for study, work and migration.',
        'purpose' => 'English language proficiency',
        'official' => 'https://ielts.org/',
        'note' => 'Requirements vary by university and program.'
    ],

    'TOEFL' => [
        'description' => 'English proficiency test widely used by universities around the world.',
        'purpose' => 'Academic English proficiency',
        'official' => 'https://www.ets.org/toefl.html',
        'note' => 'Check the university website for accepted tests and minimum scores.'
    ],

    'GRE' => [
        'description' => 'Graduate-level standardized test used by some universities and programs.',
        'purpose' => 'Graduate admission',
        'official' => 'https://www.ets.org/gre.html',
        'note' => 'Not required for every graduate program.'
    ],

    'GMAT' => [
        'description' => 'Standardized test commonly associated with business and management programs.',
        'purpose' => 'Business school admission',
        'official' => 'https://www.mba.com/exams/gmat-exam',
        'note' => 'Requirements depend on the business school and program.'
    ],

    'SAT' => [
        'description' => 'College admission test used by many undergraduate institutions.',
        'purpose' => 'Undergraduate admission',
        'official' => 'https://satsuite.collegeboard.org/sat',
        'note' => 'Check whether your selected university requires or accepts SAT.'
    ],

    'PTE' => [
        'description' => 'Computer-based English language proficiency test.',
        'purpose' => 'English language proficiency',
        'official' => 'https://www.pearsonpte.com/',
        'note' => 'Acceptance depends on the university and country.'
    ]

];

?>

<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">Test Preparation</h1>

        <p class="text-secondary">
            Learn about common tests used for international study.
        </p>

    </div>


    <div class="row g-4">

        <?php foreach ($tests as $name => $test): ?>

            <div class="col-md-6 col-lg-4">

                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body">

                        <h4 class="fw-bold">
                            <?= e($name) ?>
                        </h4>

                        <p class="text-secondary">
                            <?= e($test['description']) ?>
                        </p>

                        <p>
                            <strong>Purpose:</strong>
                            <?= e($test['purpose']) ?>
                        </p>

                        <div class="alert alert-light small">
                            <?= e($test['note']) ?>
                        </div>

                        <a
                            href="<?= e($test['official']) ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-dark btn-sm"
                        >
                            Official Website ↗
                        </a>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>


    <div class="alert alert-warning mt-5">

        <strong>Important:</strong>

        Test requirements are different for different universities,
        programs and countries. Always verify the current requirement
        from the official university or program website before applying.

    </div>

</div>

<?php require 'includes/footer.php'; ?>