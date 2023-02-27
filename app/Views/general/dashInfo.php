<div class="info-box <?= $bgClass; ?>" style="min-height: 120px;">
	<span class="info-box-icon"><i class="fa faico <?= $icon ?>"></i></span>

	<div class="info-box-content">
		<span class="dashTitle"><?= $title; ?></span>
		<span class="info-box-number dashNumber"><?= number_format($number); ?></span>

		<?php if (isset($progress) && $progress != null){ ?>
			<div class="progress">
				<div class="progress-bar" style="width: <?= $progress; ?>%"></div>
			</div>
		<?php } ?>
		<?php if (isset($description) && $description != null){ ?>
			<span class="progress-description">
				<?= $description; ?>
			</span>
		<?php } ?>
	</div>
</div>
