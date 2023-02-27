<div style="text-align: center; font-size: 2em;margin-top: 100px;">

	<?= TR('hello'); ?> <?= session()->get('forename')." ".session()->get('surname'); ?>,<br/>

</div>
<div style="text-align: center; font-size: 2em;; margin-top: 15px;">
	<?= TR('tokenFor'); ?> <?= $opId; ?>
</div>

<div style="text-align: center; font-size: 3em;margin-top: 50px;">
	<?= TR('token'); ?><br/>
</div>
<br/>
<div style="text-align: center; font-size: 3em;color:red;">
	<?= $token; ?><br/>
</div>
<br/>
<br/>
<div style="text-align: center; font-size: 1.2em;">
	<?= TR('tokenTime'); ?><br/><br/>
	<?= date('Y-m-d H:i'); ?><br>
	<?= TR('mexTime'); ?>
</div>
<br/><br/>