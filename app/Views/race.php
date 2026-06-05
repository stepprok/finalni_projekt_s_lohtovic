<?= $this->extend('Layout/template') ?>
<?= $this->section('content') ?>
<br>
<?php
/**
 * @var object $zavod
 * @var object $year
 */
?>

<?php if ($zavod->vytvoril_uzivatel_id == 1): ?>
  <h1 class="text-center text-danger">Závod: <?= $zavod->real_name ?></h1>
  <p class="text-center text-muted">Tento závod vytvořil uživatel!</p>
<?php else: ?>
  <h1 class="text-center">Závod: <?= $zavod->real_name ?></h1>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <a class="btn btn-secondary" href="<?= base_url('index.php/roky/' . $year) ?>">
    <i class="fa-solid fa-caret-left"></i> Zpět
  </a>
</div>
<div class="card mb-4">
  <div class="card-header">
    Rok: <?= $year ?> (<?= $zavod->real_name ?>)
  </div>

  <div class="card-body">
    <?php if ($zavod->start_date == $zavod->end_date) : ?>
      <span class="d-block text-xs mb-1"><strong>Datum:</strong> <?= !empty($zavod->start_date) ? date('d. m. Y', strtotime($zavod->start_date)) : '-' ?></span>
    <?php else : ?>
      <span class="d-block text-xs mb-1"><strong>Datum:</strong> <?= !empty($zavod->start_date) ? date('d. m. Y', strtotime($zavod->start_date)) : '-' ?> - 
      <?= !empty($zavod->end_date) ? date('d. m. Y', strtotime($zavod->end_date)) : '-' ?>
      </span>
    <?php endif; ?>
    <span class="d-block text-xs mb-1"><strong>Vzdálenost:</strong> <?= $zavod->total_distance ?? 0 ?> km</span>
    <span class="d-block text-xs mb-1"><strong>Převýšení:</strong> <?= $zavod->total_elevation ?? 0 ?> m</span>
  </div>
  
  <?php if (!empty($zavod->logo)): ?>
    <div class="card-footer">
      <strong>Logo</strong>
      <div class="p-3 text-center">
        <img src="<?= base_url('img/logos/' . $zavod->logo) ?>" class="img-fluid" style="max-height: 150px;" alt="Logo závodu">
      </div>
    </div>
  <?php endif; ?>
</div>
<?= $this->endSection() ?>