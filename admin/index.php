<?php $title = 'Admin Dashboard';
require '../config/db.php';
require '_header.php';
$s = $pdo->query('SELECT COUNT(*) FROM scholarships')->fetchColumn();
$u = $pdo->query('SELECT COUNT(*) FROM universities')->fetchColumn();
$f = $pdo->query('SELECT COUNT(*) FROM fields')->fetchColumn();
$users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(); ?><h1>Admin Dashboard</h1>
<p class="text-secondary">Add, edit or delete website content. Changes appear on the public site immediately.</p>
<div class="row g-3">
    <div class="col-md-3">
        <div class="card p-4">
            <div class="stat"><?= $s ?></div>Scholarships
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4">
            <div class="stat"><?= $u ?></div>Universities
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4">
            <div class="stat"><?= $f ?></div>Fields
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4">
            <div class="stat"><?= $users ?></div>Users
        </div>
    </div>
</div><?php require '_footer.php'; ?>