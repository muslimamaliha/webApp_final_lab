<?php $title = 'Scholarships | ScholarHub';
require 'includes/header.php';
require 'config/db.php';
$q = trim($_GET['q'] ?? '');
$country = trim($_GET['country'] ?? '');
$level = trim($_GET['level'] ?? '');
$sql = 'SELECT * FROM scholarships WHERE 1';
$p = [];
if ($q !== '') {
    $sql .= ' AND (title LIKE ? OR provider LIKE ? OR fields LIKE ?)';
    $x = "%$q%";
    $p = [$x, $x, $x];
}
if ($country !== '') {
    $sql .= ' AND country=?';
    $p[] = $country;
}
if ($level !== '') {
    $sql .= ' AND study_level LIKE ?';
    $p[] = "%$level%";
}
$sql .= ' ORDER BY title';
$st = $pdo->prepare($sql);
$st->execute($p);
$items = $st->fetchAll();
$countries = $pdo->query('SELECT DISTINCT country FROM scholarships ORDER BY country')->fetchAll(PDO::FETCH_COLUMN); ?>
<div class="container py-5">
    <h1>Scholarship Discovery</h1>
    <p class="text-secondary">Search the database and open the official provider source for current requirements and deadlines.</p>
    <form class="filterbar row g-2 my-4">
        <div class="col-md-5"><input name="q" value="<?= e($q) ?>" class="form-control" placeholder="Scholarship, provider or field"></div>
        <div class="col-md-4"><select name="country" class="form-select">
                <option value="">All countries</option><?php foreach ($countries as $c): ?><option <?= $country === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
            </select></div>
        <div class="col-md-2"><select name="level" class="form-select">
                <option value="">All levels</option>
                <option <?= $level === 'Undergraduate' ? 'selected' : '' ?>>Undergraduate</option>
                <option <?= $level === 'Master' ? 'selected' : '' ?>>Master</option>
                <option <?= $level === 'PhD' ? 'selected' : '' ?>>PhD</option>
            </select></div>
        <div class="col-md-1"><button class="btn btn-primary w-100">Go</button></div>
    </form>
    <div class="row g-4"><?php foreach ($items as $r): ?><div class="col-md-6 col-lg-4">
                <div class="card h-100 p-4">
                    <h5><?= e($r['title']) ?></h5>
                    <p class="text-secondary mb-2"><?= e($r['provider']) ?></p>
                    <div class="mb-2"><span class="badge soft"><?= e($r['country']) ?></span> <span class="badge soft"><?= e($r['study_level'] ?? 'Not specified') ?></span></div>
                    <p><strong>Funding:</strong> <?= e($r['funding_type'] ?? 'See official source') ?></p>
                    <p class="small text-secondary"><?= e($r['fields'] ?? 'Multiple fields / Program-specific') ?></p><a target="_blank" rel="noopener" class="btn btn-primary" href="<?= e($r['official_url']) ?>">Official details ↗</a>
                </div>
            </div><?php endforeach;
                            if (!$items): ?><div class="col-12">
                <div class="alert alert-warning">No result found.</div>
            </div><?php endif; ?></div>
</div><?php require 'includes/footer.php'; ?>