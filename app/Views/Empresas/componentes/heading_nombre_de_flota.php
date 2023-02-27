
<?php if (session() -> get('isLoggedInAdmin')){ ?>
    <div style="margin-top:0px;">
        <h3><?= $fleet['name'] ?></h3>
        <hr class="ptl-separator-title">
    </div>

<?php }else{ ?>
    <div>
        <h3><?= $fleet['name'] ?></h3>
        <hr class="ptl-separator-title">
    </div>

<?php } ?>