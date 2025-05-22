<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus datos</p>

<?php 
    // Mostrar errores de alertas
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
        />
    </div> <!--.campo -->

    <div class="campo">
        <label for="password">Paswword:</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu Password"
            name="password"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">Olvidaste tu password?</a>
    <a href="https://lucid.app/lucidspark/3edeb27d-5f36-4491-9133-eccf2ffc861c/edit?viewport_loc=3162%2C424%2C5338%2C2717%2C0_0&invitationId=inv_c554a911-266d-4565-8eeb-74cff6635ef3" target="_blank">Mapa de navegación</a>
</div>