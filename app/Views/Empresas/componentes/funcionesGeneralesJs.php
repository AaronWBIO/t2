<script>
    $(document).ready(function() {
        /**
         * Funcion para mostrar tooltip
         * @author Luis Hernandez <luis07hernandez05@outlook.es> 
         * @created 18/10/2021
         */
         $(document).on('click','.ptl-tooltip',function(){
            let tipo = $(this).data('tipo');
            popUp('<?= base_url(); ?>/Empresas/empresa/tooltips',{tipo: tipo});
         })
    })


    /**
     * Funcion para limpiar mensajes
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function emptyMensajes() {
        $('#mensaje').empty();
        $('#mensajes').empty();
        $('#mensaje-errores').empty();
        $('#mensaje-success').empty();
        $('#mensaje-error').empty();
    }

    /**
     * Funcion para mostrar mensaje alerta
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function mostrarMensaje(mensaje, type = null) {

        let alertHTML = '';

        switch (type) {
            case 'success':
                alertHTML = buildAlert(mensaje, 'success');
                $('#mensaje').show();
                $('#mensaje').html(alertHTML);
                break;
            case 'error':
                alertHTML = buildAlert(mensaje, 'danger');
                $('#mensaje').show();
                $('#mensaje').html(alertHTML);
                break;
            default:
                alertHTML = buildAlert(mensaje, 'success');
                $('#mensaje').show();
                $('#mensaje').html(alertHTML);
                break;
        }
    }

    /**
     * Funcion para construir mensaje alerta HTML
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function buildAlert(msj, type) {
        return `
        <div class="alert alert-${type} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            ${msj}
        </div>
    `;
    }
</script>