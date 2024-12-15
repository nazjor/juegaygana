<?php
session_start();
$title = 'Seleccionar Ganador - Juega y Gana';
require_once 'admin/components/init.php';
require_once DIRPAGE.'components/header.php';
require_once DIRPAGE_ADMIN . 'repositories/RifaRepository.php';
$rifaRepo = new RifaRepository();
$rifaActiva = $rifaRepo->findActiveRifa();

$ganador = null;

// Verifica si el usuario está logueado y tiene el rol de admin
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    // Solo se mostrará el botón para el usuario admin
    $mostrarBoton = true;
} else {
    $mostrarBoton = false;
}

$existeGanador = $ganador == null ? "¡ Gana un <strong>". ($rifaActiva['titulo'])."<strong> !" : "Felicidades ".$ganador['nombre'];
?>

<!-- Main -->
<main class="flex-1 max-w-4xl mx-auto px-4">
  <section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
    <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900" id="resultado"><?php echo($existeGanador)?></h2>
  </section>
    
  <!-- New Image Section -->
  <section class="relative rounded-xl overflow-hidden mb-6">
    <img src="<?php echo HOST_ADMIN.'assets/'.$rifaActiva['imagen_rifa']?>" alt="Imagen de promoción" class="w-full h-72 object-cover rounded-lg shadow-lg">
  </section>

  <section class="bg-white rounded-lg p-8 shadow-2xl mb-8">
    <?php if ($ganador === null): ?>
      <?php if ($mostrarBoton): ?>
        <div class="text-center mb-8">
          <button id="botonSeleccionar" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">
            Sortear
          </button>
        </div>
      <?php else: ?>
        <p class="text-center text-xl font-semibold">El ganador será seleccionado muy pronto.</p>
      <?php endif; ?>

      <div id="animacion" class="hidden text-center">
        <div id="boletos" class="boletos">0001</div>
        <p id="eligiendoGanador" class="text-xl font-semibold">Eligiendo ganador...</p>
      </div>

      <div id="ganador" class="mt-2 text-center"></div>

    <?php else: ?>
      <div id="ganador" class="mt-8 text-center hidden">
        <h3 class="text-2xl font-semibold">¡Nuestro ganador!</h3>
        <p class="text-lg">Ganador: <strong><?php echo $ganador['nombre']; ?></strong></p>
        <p class="text-lg">Cédula: <strong><?php echo $ganador['cedula']; ?></strong></p>
        <p class="text-lg">Boleto: <strong><?php echo $ganador['boleto']; ?></strong></p>
        <p class="text-lg">Premio: <strong><?php echo $ganador['premio']; ?></strong></p>
      </div>
    <?php endif; ?>
  </section>
</main>

<script>
  document.getElementById('botonSeleccionar').addEventListener('click', function() {

    const rifa = ` <?php echo $rifaActiva['titulo'] ?> `;
    const boletosElement = document.getElementById('boletos');
    const animacionElement = document.getElementById('animacion');
    const botonSeleccionar = document.getElementById('botonSeleccionar');
    const ganadorElement = document.getElementById('ganador');
    const eligiendoGanador = document.getElementById('eligiendoGanador');

    // Ocultar el botón de sortear
    botonSeleccionar.style.display = 'none';

    // Mostrar la animación
    animacionElement.classList.remove('hidden');

    // Animación de rotación de números
    let numero = 1;
    const interval = setInterval(function() {
      // Genera un número aleatorio de 0001 a 9999
      numero = Math.floor(Math.random() * 9999) + 1;
      boletosElement.textContent = numero.toString().padStart(4, '0');
    }, 50); // Actualiza cada 50ms

    // Detener la animación después de 5 segundos y mostrar el ganador
    setTimeout(function() {
      clearInterval(interval);
      numero = Math.floor(Math.random() * 9999) + 1;
      boletosElement.textContent = numero; // Aquí puedes poner el número ganador real si lo tienes

      // Cambiar el fondo del body a un gif
      document.body.style.backgroundImage = "url('https://juegayganaconmanolo.com/assets/images/ganador.gif')";

      // Ocultar la animación
      eligiendoGanador.classList.add('hidden');

      // Mostrar los datos del ganador (esto se puede hacer si tienes los datos disponibles)
      ganadorElement.classList.remove('hidden');
      
      // Aquí puedes reemplazar estos datos con los datos reales obtenidos del backend
      let nombreGanador = "Jose Vazquez"; // Simulando el ganador
      let cedulaGanador = "21159302";
      let premioGanador = rifa;

      ganadorElement.innerHTML = `
        <p class="text-lg">Ganador: <strong>${nombreGanador}</strong></p>
        <p class="text-lg">Cédula: <strong>${cedulaGanador}</strong></p>
       `;
    }, 5000); // 5 segundos
  });
</script>

<?php include_once DIRPAGE.'components/footer.php'; ?>

<style>
  /* Estilo para el boleto que girará */
#boletos {
  font-size: 2rem;
  font-family: monospace;
  font-weight: bold;
  padding: 30px;
  background-color: #f3f3f3;
  border-radius: 10px;
  width: 150px;
  margin: 20px auto;
  text-align: center;
}
</style>