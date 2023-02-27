<script>
    $(document).ready(function() {
        $('#rechazar').click(function (e) {
            e.preventDefault();
            var html = '';

            html += '<h4>Deja un comentario </h4>';
            html += '<textarea id="refuseComment" class="form-control"></textarea>';

            // console.log(<?= atj($company) ?>)

            conf('<?= base_url(); ?>/general/general/confirmation',html,{},function(data){

                var companies_id = <?= $company['id']; ?>;
                var brands_id = <?= $company['brand']['id']; ?>;

                var refuseComment = $('#refuseComment').val();
                var rj = jsonF(
                    '<?= base_url(); ?>/Administration/UsersValidations/refuseBrand/' + companies_id + '/' + brands_id,
                    {refuseComment:refuseComment}
                );
                var r = $.parseJSON(rj);

                if (r.ok == 1) {
                    location.reload();
                }
            });

        });
        $('#aceptar').click(function(e) {
            // console.log('aaa');
            e.preventDefault();

            html = '¿Estás seguro que deseas validar la información?'
            conf('<?= base_url(); ?>/general/general/confirmation',html,{},function(data){

                var brands_id = <?= $company['brand']['id']; ?>;
                // console.log('aas');
                var rj = jsonF('<?= base_url(); ?>/Administration/UsersValidations/acceptBrands/' + brands_id);
                var r = $.parseJSON(rj);
                if (r.ok == 1) {
                    location.reload();
                }

            })
        });


    });

</script>

<br>
<br>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-danger w-100 rechazar" id="rechazar">Rechazar</a>
        <button type="submit" class="btn btn-primary w-100 button-submit" id ="aceptar">Aceptar</button>
    </div>
</div>