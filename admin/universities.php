<?php
require '../config/db.php';
require '../includes/functions.php';

need_admin();

$a = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$err = '';

/* =========================
   DELETE UNIVERSITY
========================= */

if ($a === 'delete' && $id) {

    $st = $pdo->prepare(
        'DELETE FROM universities WHERE id=?'
    );

    $st->execute([$id]);

    header('Location: universities.php');
    exit;
}


/* =========================
   GET COUNTRIES
========================= */

$countries = $pdo->query(
    "SELECT name FROM countries ORDER BY name ASC"
)->fetchAll(PDO::FETCH_COLUMN);


/* =========================
   ADD / UPDATE UNIVERSITY
========================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $official_url = trim($_POST['official_url'] ?? '');


    if (
        $name === '' ||
        $country === '' ||
        !filter_var($official_url, FILTER_VALIDATE_URL)
    ) {

        $err = 'University name, country and a valid official URL are required.';
    } else {

        /* UPDATE */

        if ($id) {

            $st = $pdo->prepare(
                'UPDATE universities
                 SET name=?,
                     country=?,
                     city=?,
                     description=?,
                     official_url=?
                 WHERE id=?'
            );

            $st->execute([
                $name,
                $country,
                $city,
                $description,
                $official_url,
                $id
            ]);
        }

        /* INSERT */ else {

            $st = $pdo->prepare(
                'INSERT INTO universities
                (name, country, city, description, official_url)
                VALUES (?, ?, ?, ?, ?)'
            );

            $st->execute([
                $name,
                $country,
                $city,
                $description,
                $official_url
            ]);
        }

        header('Location: universities.php');
        exit;
    }
}


/* =========================
   EDIT UNIVERSITY
========================= */

$item = null;

if ($a === 'edit' && $id) {

    $st = $pdo->prepare(
        'SELECT * FROM universities WHERE id=?'
    );

    $st->execute([$id]);

    $item = $st->fetch();
}


$title = 'Manage Universities';

require '_header.php';
?>


<div class="d-flex justify-content-between align-items-center mb-3">

    <h1>Universities</h1>

    <a
        class="btn btn-primary"
        href="?action=add">
        + Add University
    </a>

</div>


<?php if ($a === 'add' || $a === 'edit'): ?>


    <!-- =========================
     ADD / EDIT FORM
========================= -->

    <div class="card p-4">

        <h4 class="mb-4">

            <?= $a === 'edit' ? 'Edit' : 'Add' ?>
            University

        </h4>


        <?php if ($err): ?>

            <div class="alert alert-danger">
                <?= e($err) ?>
            </div>

        <?php endif; ?>


        <form method="post">

            <div class="row g-3">


                <!-- UNIVERSITY NAME -->

                <div class="col-md-6">

                    <label class="form-label">
                        University Name *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        value="<?= e($item['name'] ?? '') ?>"
                        placeholder="Example: University of Oxford"
                        required>

                </div>


                <!-- COUNTRY -->

                <div class="col-md-6">

                    <label class="form-label">
                        Country *
                    </label>

                    <select
                        class="form-select"
                        name="country"
                        required>

                        <option value="">
                            Select Country
                        </option>


                        <?php foreach ($countries as $countryName): ?>

                            <option
                                value="<?= e($countryName) ?>"
                                <?= (($item['country'] ?? '') === $countryName)
                                    ? 'selected'
                                    : '' ?>>

                                <?= e($countryName) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- CITY -->

                <div class="col-md-6">

                    <label class="form-label">
                        City
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="city"
                        value="<?= e($item['city'] ?? '') ?>"
                        placeholder="Example: London">

                </div>


                <!-- OFFICIAL URL -->

                <div class="col-md-6">

                    <label class="form-label">
                        Official Website *
                    </label>

                    <input
                        type="url"
                        class="form-control"
                        name="official_url"
                        value="<?= e($item['official_url'] ?? '') ?>"
                        placeholder="https://www.example.ac.uk"
                        required>

                </div>


                <!-- DESCRIPTION -->

                <div class="col-12">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        class="form-control"
                        name="description"
                        rows="5"
                        placeholder="Short description about the university"><?= e($item['description'] ?? '') ?></textarea>

                </div>

            </div>


            <button
                type="submit"
                class="btn btn-primary mt-4">
                Save University
            </button>


            <a
                href="universities.php"
                class="btn btn-outline-secondary mt-4">
                Cancel
            </a>

        </form>

    </div>


<?php else: ?>


    <!-- =========================
     UNIVERSITY LIST
========================= -->

    <div class="table-card table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>University</th>

                    <th>Country</th>

                    <th>City</th>

                    <th>Official Website</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                <?php

                $universities = $pdo->query(
                    'SELECT * FROM universities
             ORDER BY id DESC'
                )->fetchAll();

                ?>


                <?php if (!$universities): ?>

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-4">
                            No universities found.

                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach ($universities as $r): ?>

                        <tr>


                            <td>

                                <strong>
                                    <?= e($r['name']) ?>
                                </strong>

                                <?php if (!empty($r['description'])): ?>

                                    <br>

                                    <small class="text-muted">

                                        <?= e(
                                            mb_strimwidth(
                                                $r['description'],
                                                0,
                                                100,
                                                '...'
                                            )
                                        ) ?>

                                    </small>

                                <?php endif; ?>

                            </td>


                            <td>
                                <?= e($r['country']) ?>
                            </td>


                            <td>
                                <?= e($r['city'] ?? 'Not specified') ?>
                            </td>


                            <td>

                                <?php if (!empty($r['official_url'])): ?>

                                    <a
                                        href="<?= e($r['official_url']) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-sm btn-outline-primary">
                                        Visit
                                    </a>

                                <?php endif; ?>

                            </td>


                            <td>

                                <a
                                    href="?action=edit&id=<?= $r['id'] ?>"
                                    class="btn btn-sm btn-outline-dark">
                                    Edit
                                </a>


                                <a
                                    href="?action=delete&id=<?= $r['id'] ?>"
                                    data-confirm="Delete this university?"
                                    class="btn btn-sm btn-outline-danger">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>


                <?php endif; ?>

            </tbody>

        </table>

    </div>


<?php endif; ?>


<?php require '_footer.php'; ?>