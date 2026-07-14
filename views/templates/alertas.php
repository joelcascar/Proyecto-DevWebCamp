<?php

foreach ($alertas as $p => $alerta) {
    foreach ($alerta as $mensaje) { ?>
        <div class="alerta alerta__<?php echo $p; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php } ?>
<?php } ?>