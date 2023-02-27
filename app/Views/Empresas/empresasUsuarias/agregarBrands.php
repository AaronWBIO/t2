<script>
    let ContadorFormularios = 0;
    let Company = <?= json_encode($company) ?>;
    let Eliminados = [];    

    $(document).ready(function(){
        
        setTimeout(function(){
            $('#mensaje').empty();
        },3000)

        //Cargar tablas
        loadTables();

        //Agregar compañia
        $('.agregarCompania').on('click',function(){
            let table_companias = `
            
            <tr class="b-${ContadorFormularios}" data-form="${ContadorFormularios}">           
                
                <td>                              
                    <input type="text" name="${ContadorFormularios}#name" value="" class="form-control brandName">
                </td>
                <td>
                    <a class="btn btn-danger eliminarCompania" data-form="b-${ContadorFormularios}">X</a>
                </td>                
            </tr>

            `;

            ContadorFormularios += 1;
    
            $('.table-companias > tbody').append(table_companias);
        })

        //Eliminar compañia
        $('.table-companias').on('click','.eliminarCompania', function() {
            let formName = $(this).data('form');
            let id = $(this).parent().parent().data('a');           

            $('.' + formName).each(function() {
                $(this).remove();
            })

            if (id != undefined){
                Eliminados.push(id);
            }
        })

        //Guardar información
        $('.button-submit').on('click',function(){
            
            $('#mensaje').empty();

            let data = $('.form-empresa-companias').serializeObject();
            // data['eliminados'] = Eliminados;
            
            var rj = jsonF('<?= base_url(); ?>/Empresas/empresa/guardarBrands', {
                eliminados: Eliminados,
                data: data,
                eliminados:Eliminados
            });
            
            rj = JSON.parse(rj);            

            if (rj.ok == 1){
                window.location = `<?= base_url(); ?>/Empresas/empresa/agregarBrands`;                
            }else{
                mostrarMensaje(rj.errores,'error');
            }
        });
    })

     /**
     * Funcion para cargar las tablas 
     * @author Luis Hernandez <luis07hernandez05@outlook.es> 
     * @created 18/10/2021
     */
    function loadTables(){

        //Compañias        
        let brands = <?= json_encode($brands) ?>;

        let table_companias = '';      

        for (brand of brands) { 
         
            table_companias += `
            
            <tr class="b-${ContadorFormularios}" data-form="${ContadorFormularios}" data-a="${brand.id}">                          
                <td>
                    <input type="hidden" name="${ContadorFormularios}#id" value="${brand.id}" class="form-control">
                    <input type="text" name="${ContadorFormularios}#name" value="${brand.name}" class="form-control brandName">
                </td>nav-tab-01
                <td>
                    <a class="btn btn-danger eliminarCompania" data-form="b-${ContadorFormularios}">X</a>
                </td>                
            </tr>

            `;

            ContadorFormularios += 1;
        }

        $('.table-companias > tbody').html(table_companias);        
    }

</script>

<div style="text-align:justify;">
    <p>La plataforma Transporte Limpio para empresas usuarias del transporte de carga (o generadoras de carga) calcula las emisiones de contaminantes (CO2, NOx, PM2.5, PM10 y Carbono negro) asociadas con las actividades relacionadas con el movimiento de sus cargas y con los datos de desempeño ambiental de las flotas de los transportistas que contrata.</p>

    <p>Recuerde que entre más eficientes sean los tranportistas que contrata para mover sus cargas, menores serán sus emisiones de CO2.</p>

    <p>Asimismo, la Plataforma Transporte Limpio le permite dividir las actividades del movimiento de sus cargas, por Unidades de Negocio. Tome en cuenta que, si usted enlista varias Unidades de Negocio, deberá proporcionar información detallada para cada una de ellas.</p>

    <p>Nota: <strong>Una Unidad de Negocio es una división de su empresa que funciona de forma independiente y autónoma de otras Unidades de Negocio de dicha empresa, y que puede tener una misión y objetivos propios, pero que están vinculadas por el logro de los objetivos corporativos y la planificación global de la empresa.</strong></p>

    <p>
        A continuación podrá capturar las distintas Unidades de Negocio de su empresa. Para ello debe de dar clic en el botón “Agregar nueva unidad de negocio”, posteriormente escribir el nombre de la Unidad de Negocio y, por último, dar clic en el botón “Guardar”.
    </p>
    <p>
        Para eliminar alguna Unidad de Negocio solo debe dar clic en el botón “X” que aparece a la derecha del nombre.
    </p>

</div>
<form class="form-empresa-companias">
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link nav-tab-01" id="nav-tab-01" data-toggle="tab" href="#nav-01" role="tab" aria-controls="nav-01" aria-selected="true">Unidad de negocio</a>
            </li>                  
        </ul>

        <div class="tab-content <?= $company['rev_year'] == date('Y') ? 'ptl-disabled' :'' ?>" id="nav-tabContent">
            <div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01">
                <div class="overflow-x">
                    <table class="table table-companias">
                        <thead>
                            <tr>
                                <th>
                                    <span class="glyphicon glyphicon-question-sign ptl-tooltip" data-tipo="nom_unidad" id="ayuda"></span>
                                    Nombre de la unidad de negocio
                                </th>
                                <!-- <th>SCIAN Código</th>                                 -->
                                <th>Remover</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div style="text-align:right;">
                        <a href="/Empresas/Empresa/Inicio" class="btn btn-danger">Cancelar</a>
                        <button type="button" class="btn btn-primary button-submit">Guardar</button>
                        <br>
                        <br>
                        <a class="btn btn-primary agregarCompania">
                            Agregar nueva unidad de negocio
                        </a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</form>