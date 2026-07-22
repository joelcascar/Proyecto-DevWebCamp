<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Evento</label>
        <input type="text" class="formulario__input" id="nombre" name="nombre" placeholder="Nombre Evento" value="<?php echo $evento->nombre; ?>">
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="descripcion">Descripción</label>
        <textarea class="formulario__input" id="descripcion" name="descripcion" placeholder="Descripción Evento" rows="8"><?php echo $evento->descripcion; ?></textarea>
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="categoria">Categoría o tipo de evento</label>
        <select class="formulario__select" name="categoria_id" id="categoria">
            <option value="" selected>-- Seleccione --</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Seleciona el dia</label>
        <div class="formulario__radio">
            <?php foreach ($dias as $dia) { ?>
                <div>
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre ?></label>
                    <input type="radio" name="dia" id="<?php echo strtolower($dia->nombre); ?>" value="<?php echo $dia->id ?>" />
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="dia_id" value="">
    </div>

    <div id="horas" class="formulario__campo">
        <label class="formulario__label">Seleccionar Hora</label>
        <ul id="horas" class="horas">
            <?php foreach ($horas as $hora) { ?>
                <li data-hora-id="<?php echo $hora->id ?>" class="horas__hora horas__hora--deshabilitada "><?php echo $hora->hora; ?></li>
            <?php } ?>
        </ul>
        <input type="hidden" name="hora_id" value="">
    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="ponentes">Ponente</label>
        <input type="text" class="formulario__input" id="ponentes" placeholder="Buscar ponente">
        <!-- Lo vamos a llenar con JavaScript -->
        <ul id="listado-ponentes" class="listado-ponentes"></ul>

        <input type="hidden" name="ponente_id" value="">
    </div>
    <div class="formulario__campo">
        <label class="formulario__label" for="disponibles">Lugares disponibles</label>
        <input type="number" min="1" class="formulario__input" id="disponibles" name="disponibles" placeholder="Ej. 20" value='<?php echo $evento->disponibles; ?>'>
    </div>
</fieldset>