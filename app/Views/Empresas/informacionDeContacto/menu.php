<script>
    $(document).ready(function() {
        var edited = false;

        $('.preventLink').click(function (e) {
            e.preventDefault();

            var link = $(this).attr('href');
            
            if(edited){
                conf('<?= base_url(); ?>/general/general/confirmation',
                    'Estás a punto de dejar esta página y no haz guardado la información, ¿Estás seguro que deseas continuar?',
                    {},function(){
                        window.location.href = link;
                    });
            }else{
                window.location.href = link;
            }

        });

        $('input').change(function(event) {
            edited = true;
        });

    });
</script>


<li class="nav-item <?= $formulario == 'informacionDeSocios' ? 'active' : '' ?>">
    <a href="/Empresas/empresa/informacionDeSocios" class="nav-link preventLink">Datos de la empresa</a>
</li>
<li class="nav-item <?= $formulario == 'contactos' ? 'active' : '' ?>">
    <a href="/Empresas/empresa/contactos" class="nav-link preventLink" >Contactos</a>
</li>