<?php  
echo($this->extend('Layout/template'));
echo($this->section('content'));
?>
<br>



<h1 class="text-center">Závod <?= $zavod->default_name; ?></h1>


<?= $this->endSection(); ?>