<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?></h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <form action="/login" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu email" class="formulario__input">
        </div>
        <input type="submit" class="formulario__submit" value="Enviar instrucciones">
        <div class="acciones">
            <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
            <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obtener una</a>
        </div>
    </form>
</main>