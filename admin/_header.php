<?php require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
need_admin();
$cur = basename($_SERVER['PHP_SELF']); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= e($title ?? 'Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <nav class="navbar bg-dark navbar-dark">
        <div class="container"><a class="navbar-brand fw-bold" href="../index.php">🎓 ScholarHub Admin</a><a class="btn btn-outline-light btn-sm" href="../logout.php">Logout</a></div>
    </nav>
    <div class="container py-4">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card p-3 sidebar">
                    <strong>Admin Menu</strong>
                    <a class="<?= $cur === 'index.php' ? 'active' : '' ?>" href="index.php">Dashboard</a>
                    <a class="<?= $cur === 'scholarships.php' ? 'active' : '' ?>" href="scholarships.php">Scholarships</a>
                    <a class="<?= $cur === 'universities.php' ? 'active' : '' ?>" href="universities.php">Universities</a>
                    <a class="<?= $cur === 'countries.php' ? 'active' : '' ?>" href="countries.php">Countries</a>
                    <a class="<?= $cur === 'fields.php' ? 'active' : '' ?>" href="fields.php">Fields</a>
                    <a href="../index.php">View Website</a>
                </div>
            </aside>
            <section class="col-lg-9">