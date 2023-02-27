
<div class="row">
    <?php foreach ($fleetsYearsCats as $c => $fleets){ ?>
        <div class="col-md-12">
            <h3><?= $c; ?></h3>
            <?php
                $data = array();
                $data['category'] = $c;
                $data['div_name'] = 'chart_combinado_'.(isset($fleets[0])?$fleets[0]['ccode']:'A');
                $data['data'] = $fleets;
            ?>
            <?= view('Administration/inquiries/chartAllPollutants',$data) ?>
            
        </div>
    <?php } ?>
</div> 