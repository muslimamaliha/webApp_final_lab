<?php

$title = 'Universities | ScholarHub';

require 'includes/header.php';
require 'config/db.php';

$q = trim($_GET['q'] ?? '');
$country = trim($_GET['country'] ?? '');


/* =========================
   COUNTRY LIST
   ========================= */

$countries = $pdo->query(
    "SELECT name FROM countries ORDER BY name"
)->fetchAll(PDO::FETCH_COLUMN);


/* =========================
   UNIVERSITY SEARCH
   ========================= */

$sql = "
    SELECT *
    FROM universities
    WHERE 1
";

$params = [];


if ($q !== '') {

    $sql .= "
        AND (
            name LIKE ?
            OR city LIKE ?
            OR description LIKE ?
        )
    ";

    $search = "%{$q}%";

    $params[] = $search;
    $params[] = $search;
    $params[] = $search;
}


if ($country !== '') {

    $sql .= " AND country = ?";

    $params[] = $country;
}


$sql .= " ORDER BY name";


$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$universities = $stmt->fetchAll();

?>

<div class="container py-5">

    <div class="text-center mb-5">

        <h1 class="fw-bold">
            Universities
        </h1>

        <p class="text-secondary">
            Explore universities by country and search for your preferred institution.
        </p>

    </div>


    <!-- =========================
         FILTER
         ========================= -->

    <div class="card shadow-sm border-0 mb-5">

        <div class="card-body">

            <form method="get">

                <div class="row g-3">


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Search University
                        </label>

                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            value="<?= e($q) ?>"
                            placeholder="Search university name...">

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Country
                        </label>

                        <select
                            name="country"
                            class="form-select">

                            <option value="">
                                All Countries
                            </option>


                            <?php foreach ($countries as $c): ?>

                                <option
                                    value="<?= e($c) ?>"
                                    <?= $country === $c
                                        ? 'selected'
                                        : ''
                                    ?>>
                                    <?= e($c) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-dark w-100">
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- =========================
         RESULT COUNT
         ========================= -->

    <div class="d-flex justify-content-between
                align-items-center mb-3">

        <p class="text-secondary mb-0">

            <?= count($universities) ?>

            university/universities found

        </p>


        <?php if ($q !== '' || $country !== ''): ?>

            <a
                href="universities.php"
                class="btn btn-sm btn-outline-secondary">
                Clear Filter
            </a>

        <?php endif; ?>

    </div>


    <!-- =========================
         UNIVERSITY CARDS
         ========================= -->

    <div class="row g-4">


        <?php foreach ($universities as $university): ?>

            <div class="col-md-6 col-lg-4">

                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body d-flex flex-column">

                        <h5 class="fw-bold">

                            <?= e($university['name']) ?>

                        </h5>


                        <p class="text-secondary mb-2">

                            📍

                            <?= e($university['city']) ?>,

                            <?= e($university['country']) ?>

                        </p>


                        <?php if (
                            !empty($university['description'])
                        ): ?>

                            <p class="text-secondary">

                                <?= e(
                                    $university['description']
                                ) ?>

                            </p>

                        <?php endif; ?>


                        <div class="mt-auto">

                            <a
                                href="<?= e(
                                            $university['official_url']
                                        ) ?>"
                                target="_blank"
                                rel="noopener"
                                class="btn btn-outline-dark w-100">
                                Official Website ↗
                            </a>

                        </div>

                    </div>

                </div>

            </div>


        <?php endforeach; ?>


        <?php if (!$universities): ?>

            <div class="col-12">

                <div class="alert alert-light text-center">

                    No universities found for your search.

                </div>

            </div>

        <?php endif; ?>


    </div>

</div>


<?php require 'includes/footer.php'; ?>