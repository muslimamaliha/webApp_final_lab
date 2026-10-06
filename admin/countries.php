<?php
require '../config/db.php';
require '../includes/functions.php';

need_admin();

$a = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$err = '';

/* =========================
   DELETE COUNTRY
========================= */

if ($a === 'delete' && $id) {

    $st = $pdo->prepare(
        'SELECT name FROM countries WHERE id=?'
    );

    $st->execute([$id]);

    $country = $st->fetch();

    if ($country) {

        /*
         * Check whether universities
         * are using this country.
         */

        $st = $pdo->prepare(
            'SELECT COUNT(*) FROM universities WHERE country=?'
        );

        $st->execute([$country['name']]);

        $universityCount = (int)$st->fetchColumn();


        /*
         * Check whether scholarships
         * are using this country.
         */

        $st = $pdo->prepare(
            'SELECT COUNT(*) FROM scholarships WHERE country=?'
        );

        $st->execute([$country['name']]);

        $scholarshipCount = (int)$st->fetchColumn();


        if ($universityCount > 0 || $scholarshipCount > 0) {

            $err =
                'This country cannot be deleted because it is being used by '
                . $universityCount
                . ' university record(s) and '
                . $scholarshipCount
                . ' scholarship record(s).';
        } else {

            $st = $pdo->prepare(
                'DELETE FROM countries WHERE id=?'
            );

            $st->execute([$id]);

            header('Location: countries.php');
            exit;
        }
    }
}


/* =========================
   ADD / UPDATE
========================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $official_study_url = trim($_POST['official_study_url'] ?? '');


    if ($name === '') {

        $err = 'Country name is required.';
    } elseif (
        $official_study_url !== '' &&
        !filter_var($official_study_url, FILTER_VALIDATE_URL)
    ) {

        $err = 'Please enter a valid URL.';
    } else {

        try {

            if ($id) {

                $st = $pdo->prepare(
                    'UPDATE countries
                     SET name=?,
                         description=?,
                         official_study_url=?
                     WHERE id=?'
                );

                $st->execute([
                    $name,
                    $description,
                    $official_study_url,
                    $id
                ]);
            } else {

                $st = $pdo->prepare(
                    'INSERT INTO countries
                    (name, description, official_study_url)
                    VALUES (?, ?, ?)'
                );

                $st->execute([
                    $name,
                    $description,
                    $official_study_url
                ]);
            }

            header('Location: countries.php');
            exit;
        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {

                $err = 'This country already exists.';
            } else {

                $err = 'Something went wrong. Please try again.';
            }
        }
    }
}


/* =========================
   EDIT
========================= */

$item = null;

if ($a === 'edit' && $id) {

    $st = $pdo->prepare(
        'SELECT * FROM countries WHERE id=?'
    );

    $st->execute([$id]);

    $item = $st->fetch();
}


$title = 'Manage Countries';

require '_header.php';
?>


<div class="d-flex justify-content-between align-items-center mb-3">

    <h1>Countries</h1>

    <a
        class="btn btn-primary"
        href="?action=add">
        + Add Country
    </a>

</div>


<?php if ($err): ?>

    <div class="alert alert-danger">
        <?= e($err) ?>
    </div>

<?php endif; ?>


<?php if ($a === 'add' || $a === 'edit'): ?>


    <!-- =========================
     ADD / EDIT FORM
========================= -->

    <div class="card p-4">

        <h4 class="mb-4">

            <?= $a === 'edit' ? 'Edit' : 'Add' ?>
            Country

        </h4>


        <form method="post">

            <div class="row g-3">


                <!-- COUNTRY NAME -->

                <div class="col-md-6">

                    <label class="form-label">
                        Country Name *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        value="<?= e($item['name'] ?? '') ?>"
                        placeholder="Example: United Kingdom"
                        required>

                </div>


                <!-- OFFICIAL STUDY URL -->

                <div class="col-md-6">

                    <label class="form-label">
                        Official Study Website
                    </label>

                    <input
                        type="url"
                        class="form-control"
                        name="official_study_url"
                        value="<?= e($item['official_study_url'] ?? '') ?>"
                        placeholder="https://example.com">

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
                        placeholder="Short information about studying in this country"><?= e($item['description'] ?? '') ?></textarea>

                </div>

            </div>


            <button
                type="submit"
                class="btn btn-primary mt-4">
                Save Country
            </button>


            <a
                href="countries.php"
                class="btn btn-outline-secondary mt-4">
                Cancel
            </a>

        </form>

    </div>


<?php else: ?>


    <!-- =========================
     COUNTRY LIST
========================= -->

    <div class="table-card table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Country</th>
                    <th>Universities</th>
                    <th>Scholarships</th>
                    <th>Official Study Website</th>
                    <th>Action</th>

                </tr>

            </thead>


            <tbody>


                <?php

                $countries = $pdo->query(
                    "SELECT
                c.id,
                c.name,
                c.description,
                c.official_study_url,

                (
                    SELECT COUNT(*)
                    FROM universities u
                    WHERE u.country = c.name
                ) AS university_count,

                (
                    SELECT COUNT(*)
                    FROM scholarships s
                    WHERE s.country = c.name
                ) AS scholarship_count

             FROM countries c

             ORDER BY c.name ASC"
                )->fetchAll();

                ?>


                <?php if (!$countries): ?>

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-4">
                            No countries found.

                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach ($countries as $r): ?>

                        <tr>


                            <td>
                                <?= (int)$r['id'] ?>
                            </td>


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
                                                80,
                                                '...'
                                            )
                                        ) ?>

                                    </small>

                                <?php endif; ?>

                            </td>


                            <td>

                                <span class="badge bg-primary">

                                    <?= (int)$r['university_count'] ?>

                                </span>

                            </td>


                            <td>

                                <span class="badge bg-success">

                                    <?= (int)$r['scholarship_count'] ?>

                                </span>

                            </td>


                            <td>

                                <?php if (!empty($r['official_study_url'])): ?>

                                    <a
                                        href="<?= e($r['official_study_url']) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-sm btn-outline-primary">
                                        Visit
                                    </a>

                                <?php else: ?>

                                    <span class="text-muted">
                                        Not added
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <a
                                    href="?action=edit&id=<?= (int)$r['id'] ?>"
                                    class="btn btn-sm btn-outline-dark">
                                    Edit
                                </a>


                                <?php if (
                                    (int)$r['university_count'] === 0 &&
                                    (int)$r['scholarship_count'] === 0
                                ): ?>

                                    <a
                                        href="?action=delete&id=<?= (int)$r['id'] ?>"
                                        data-confirm="Delete this country?"
                                        class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </a>

                                <?php else: ?>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        disabled
                                        title="This country is being used">
                                        Delete
                                    </button>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>


                <?php endif; ?>

            </tbody>

        </table>

    </div>


<?php endif; ?>


<?php require '_footer.php'; ?>