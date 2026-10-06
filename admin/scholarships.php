<?php
require '../config/db.php';
require '../includes/functions.php';

need_admin();

$a = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$err = '';

/* =========================
   DELETE
========================= */
if ($a === 'delete' && $id) {
    $st = $pdo->prepare('DELETE FROM scholarships WHERE id=?');
    $st->execute([$id]);

    header('Location: scholarships.php');
    exit;
}

/* =========================
   GET COUNTRIES
========================= */
$countries = $pdo->query(
    "SELECT name FROM countries ORDER BY name ASC"
)->fetchAll(PDO::FETCH_COLUMN);

/* =========================
   ADD / UPDATE
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $provider = trim($_POST['provider'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $study_level = trim($_POST['study_level'] ?? '');
    $fields = trim($_POST['fields'] ?? '');
    $funding_type = trim($_POST['funding_type'] ?? '');
    $official_url = trim($_POST['official_url'] ?? '');

    if (
        $title === '' ||
        $provider === '' ||
        $country === '' ||
        !filter_var($official_url, FILTER_VALIDATE_URL)
    ) {
        $err = 'Title, provider, country and a valid URL are required.';
    } else {

        if ($id) {

            $st = $pdo->prepare(
                'UPDATE scholarships
                 SET title=?,
                     provider=?,
                     country=?,
                     study_level=?,
                     fields=?,
                     funding_type=?,
                     official_url=?
                 WHERE id=?'
            );

            $st->execute([
                $title,
                $provider,
                $country,
                $study_level,
                $fields,
                $funding_type,
                $official_url,
                $id
            ]);
        } else {

            $st = $pdo->prepare(
                'INSERT INTO scholarships
                (title, provider, country, study_level, fields, funding_type, official_url)
                VALUES (?, ?, ?, ?, ?, ?, ?)'
            );

            $st->execute([
                $title,
                $provider,
                $country,
                $study_level,
                $fields,
                $funding_type,
                $official_url
            ]);
        }

        header('Location: scholarships.php');
        exit;
    }
}

/* =========================
   EDIT
========================= */
$item = null;

if ($a === 'edit' && $id) {

    $st = $pdo->prepare(
        'SELECT * FROM scholarships WHERE id=?'
    );

    $st->execute([$id]);
    $item = $st->fetch();
}

$title = 'Manage Scholarships';

require '_header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Scholarships</h1>

    <a class="btn btn-primary" href="?action=add">
        + Add Scholarship
    </a>
</div>


<?php if ($a === 'add' || $a === 'edit'): ?>

    <div class="card p-4">

        <h4>
            <?= $a === 'edit' ? 'Edit' : 'Add' ?> Scholarship
        </h4>

        <?php if ($err): ?>

            <div class="alert alert-danger">
                <?= e($err) ?>
            </div>

        <?php endif; ?>


        <form method="post">

            <div class="row g-3">

                <!-- TITLE -->
                <div class="col-md-6">

                    <label class="form-label">
                        Title *
                    </label>

                    <input
                        class="form-control"
                        name="title"
                        value="<?= e($item['title'] ?? '') ?>"
                        required>

                </div>


                <!-- PROVIDER -->
                <div class="col-md-6">

                    <label class="form-label">
                        Provider *
                    </label>

                    <input
                        class="form-control"
                        name="provider"
                        value="<?= e($item['provider'] ?? '') ?>"
                        required>

                </div>


                <!-- COUNTRY DROPDOWN -->
                <div class="col-md-4">

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
                                <?= (($item['country'] ?? '') === $countryName) ? 'selected' : '' ?>>
                                <?= e($countryName) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- STUDY LEVEL -->
                <div class="col-md-4">

                    <label class="form-label">
                        Study Level
                    </label>

                    <input
                        class="form-control"
                        name="study_level"
                        value="<?= e($item['study_level'] ?? '') ?>"
                        placeholder="Bachelor, Master, PhD">

                </div>


                <!-- FUNDING -->
                <div class="col-md-4">

                    <label class="form-label">
                        Funding
                    </label>

                    <input
                        class="form-control"
                        name="funding_type"
                        value="<?= e($item['funding_type'] ?? '') ?>"
                        placeholder="Full, Partial">

                </div>


                <!-- FIELDS -->
                <div class="col-12">

                    <label class="form-label">
                        Fields
                    </label>

                    <input
                        class="form-control"
                        name="fields"
                        value="<?= e($item['fields'] ?? '') ?>"
                        placeholder="Engineering, Business, Science...">

                </div>


                <!-- OFFICIAL URL -->
                <div class="col-12">

                    <label class="form-label">
                        Official URL *
                    </label>

                    <input
                        type="url"
                        class="form-control"
                        name="official_url"
                        value="<?= e($item['official_url'] ?? '') ?>"
                        placeholder="https://example.com"
                        required>

                </div>

            </div>


            <button class="btn btn-primary mt-4">
                Save
            </button>

            <a
                class="btn btn-outline-secondary mt-4"
                href="scholarships.php">
                Cancel
            </a>

        </form>

    </div>


<?php else: ?>


    <div class="table-card table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>Scholarship</th>
                    <th>Country</th>
                    <th>Level</th>
                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                <?php
                $scholarships = $pdo->query(
                    'SELECT * FROM scholarships ORDER BY id DESC'
                )->fetchAll();
                ?>

                <?php foreach ($scholarships as $r): ?>

                    <tr>

                        <td>

                            <strong>
                                <?= e($r['title']) ?>
                            </strong>

                            <br>

                            <small>
                                <?= e($r['provider']) ?>
                            </small>

                        </td>


                        <td>
                            <?= e($r['country']) ?>
                        </td>


                        <td>
                            <?= e($r['study_level'] ?? 'Not specified') ?>
                        </td>


                        <td>

                            <a
                                class="btn btn-sm btn-outline-dark"
                                href="?action=edit&id=<?= $r['id'] ?>">
                                Edit
                            </a>


                            <a
                                data-confirm="Delete this scholarship?"
                                class="btn btn-sm btn-outline-danger"
                                href="?action=delete&id=<?= $r['id'] ?>">
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>


<?php endif; ?>


<?php require '_footer.php'; ?>