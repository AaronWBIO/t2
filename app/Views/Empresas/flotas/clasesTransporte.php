<script>
    $(document).ready(function() {
        var edited = false;

        $('.preventLink').click(function (e) {
            e.preventDefault();
            console.log('rrr');
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

<form role="form">
  <div>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link preventLink active" id="nav-tab-01" data-toggle="tab" href="#nav-01" role="tab" aria-controls="nav-01" aria-selected="true">Año modelo del motor y claseAAA</a>
      </li>
      <li class="nav-item">
        <a class="nav-link preventLink" id="nav-tab-02" data-toggle="tab" href="#nav-02" role="tab" aria-controls="nav-01" aria-selected="true">Información de actividad</a>
      </li>
      <li class="nav-item">
        <a class="nav-link preventLink" id="nav-tab-03" data-toggle="tab" href="#nav-03" role="tab" aria-controls="nav-01" aria-selected="true">Reducción de PM</a>
      </li>
      <br>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane active fade in" id="nav-01" role="tabpanel" aria-labelledby="nav-tab-01">
        <ul>
          <li>
            <h5>Ingresa el número de camiones que tienes al 31 de diciembre del año que se reporta por clase y año modelo del motor.</h5>
          </li>
          <li>
            <h5>El total de cada clase se calcula automáticamente.</h5>
          </li>
        </ul>
      </div>
      <div class="tab-pane fade" id="nav-02" role="tabpanel" aria-labelledby="nav-tab-02">
        <p>Pestaña 2</p>
      </div>
      <div class="tab-pane fade" id="nav-03" role="tabpanel" aria-labelledby="nav-tab-03">
        <p>Pestaña 3</p>
      </div>
    </div>
  </div>
  <h2>Diesel</h2>
  <label style="font-weight: lighter;">Nota: Las siluetas representan un ejemplo de los tipos de camiones para cada clase, más no incluye todos</label>
  <div class="form-group">
    <span class="icon-infocircle" aria-hidden="true"></span>
    <label style="font-weight: lighter;">Peso bruto vehicular (toneladas)</label>
  </div>
  </form>

<form class="form-inline" role="form">
  <div class="form-group">
    <label class="sr-only" for="email-02">Agregar mas clases</label>
    <select class="form-control" id="vClase" name="vClase">
      <option value="">Agregar mas clases</option>
      <option>A</option>
      <option>B</option>
      <option>C</option>
      <option>D</option>
      <option>E</option>
    </select>
  </div>
  &nbsp&nbsp&nbsp&nbsp
  <button class="btn btn-light disabled" type="submit" disabled>Validar información</button>
  <button class="btn btn-light disabled" type="submit" disabled>Guardar y continuar</button>
</form>
<br>
  <table class="table">
<thead class="bg-primary-600">
  <tr>
    <th>Año</th>
    <th>Total camiones</th>
    <?php
    if (isset($transporte)) {
      foreach ($transporte as $dato) { 
    ?>
      <th>
        <?=$dato->vCodigo.'<br>'?>
        <img src="<?php echo "http://".$_SERVER['SERVER_NAME']?>/assets/images/<?=$dato->vIcon?>" width="50%" height="50%" ><br>
        <?=$dato->vNombre?>
      </th>
    <?php
      }//foreach
    }//IF
    ?>
  </tr>
    </thead>
    <tbody>
      <?php
        for ($i=0; $i<count($anios); $i++) {
      ?>
      <tr>
        <td><?=$anios[$i];?></td>
        <td><input class="form-control" type="text" id="iTotal-<?=$i?>" name="iTotal" readonly disabled></td>
      <?php
      if (isset($transporte)) {
        foreach ($transporte as $exData) { 
      ?>
        <td>
          <input class="form-control" type="text" id="totalTracto-<?=$i?>" name="totalTracto-<?=$i?>" onkeyup="totalServiciosV1(<?=$i?>);">
        </td>
      <?php
       }//foreach
      }//IF
      ?>
      </tr>
      <?php
        }//For
      ?>
    </tbody>
  </table>
