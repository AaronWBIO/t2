

<div class="row">
    <div class="col-md-12">
        <?php
        	$data = array();
            $data['div_name'] = 'chart_categories';
            $data['data'] = $fleetsCats;
        ?>
        <?= view('Administration/inquiries/chartAllPollutants',$data) ?>
    </div>
</div> 