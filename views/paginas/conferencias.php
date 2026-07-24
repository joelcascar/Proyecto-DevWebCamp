<main class="agenda">
    <h2 class="agenda__heading"><?php echo $titulo ?? ''; ?></h2>
    <p class="agenda__descripcion">Talleres y Conferencias dictados por expertos de desarrollo web</p>

    <div class="eventos">
        <h3 class="eventos__heading">&#60;Conferencias/></h3>
        <p class="eventos__fecha">Viernes 06 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos["conferencias_v"] as $evento) { ?>
                    <?php include __DIR__ . '/../templates/evento.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fecha">Sabado 07 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos["conferencias_s"] as $evento) { ?>
                    <?php include __DIR__ . '/../templates/evento.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div> <!-- Eventos -->

    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&#60;Workshops/></h3>
        <p class="eventos__fecha">Viernes 06 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos["workshops_v"] as $evento) { ?>
                    <?php include __DIR__ . '/../templates/evento.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fecha">Sabado 07 de Octubre</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos["workshops_s"] as $evento) { ?>
                    <?php include __DIR__ . '/../templates/evento.php'; ?>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div> <!-- Eventos -->
</main>