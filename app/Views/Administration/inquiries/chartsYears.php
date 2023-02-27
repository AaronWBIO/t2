

<div class="row">
    <div class="col-md-12">
        <?php
            // print2($fleetsYears);
            $data = array();
            $data['div_name'] = 'chart_years';
            $data['data'] = $fleetsYears;
        ?>
        <?= view('Administration/inquiries/chartAllPollutants',$data) ?>
    </div>
</div> 