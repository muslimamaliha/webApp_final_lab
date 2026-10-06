<?php require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';
$current = basename($_SERVER['PHP_SELF']); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= e($title ?? 'ScholarHub') ?></title>
    <meta name="description" content="ScholarHub study abroad and scholarship discovery platform">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container"><a class="navbar-brand fw-bold" href="index.php">🎓 ScholarHub</a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link <?= $current === 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current === 'scholarships.php' ? 'active' : '' ?>" href="scholarships.php">Scholarships</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current === 'universities.php' ? 'active' : '' ?>" href="universities.php">Universities</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle 
       <?= in_array($current, ['prepare.php', 'tests.php', 'visa-guide.php']) ? 'active' : '' ?>"
                            href="#"
                            id="preparationDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Preparation Guide
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="preparationDropdown">

                            <li>
                                <a class="dropdown-item" href="prepare.php">
                                    Required Documents
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="prepare.php#application">
                                    Application Guide
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="prepare.php#checklist">
                                    Study Abroad Checklist
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="visa-guide.php">
                                    Student Visa Guide
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="prepare.php#interview">
                                    Interview Preparation
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item" href="tests.php">
                                    Test Preparation
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link <?= $current === 'about.php' ? 'active' : '' ?>" href="about.php">About</a></li>
                    <?php if (admin()): ?><li class="nav-item"><a class="nav-link fw-bold" href="admin/index.php">Admin</a></li><?php elseif (logged_in()): ?><li class="nav-item"><a class="nav-link <?= $current === 'profile.php' ? 'active' : '' ?>" href="profile.php">Profile</a></li><?php endif; ?>
                    <?php if (logged_in()): ?><li class="nav-item ms-lg-2"><a class="btn btn-outline-dark btn-sm" href="logout.php">Logout</a></li><?php else: ?><li class="nav-item ms-lg-2"><a class="btn btn-primary btn-sm" href="login.php">Login</a></li><?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main>