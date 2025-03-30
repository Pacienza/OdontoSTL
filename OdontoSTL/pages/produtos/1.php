<style>
.produto-detalhe {
  padding: 2rem;
}

.produto-container {
  display: flex;
  gap: 2rem;
  align-items: flex-start;
  flex-wrap: wrap;
}

.galeria {
  position: relative;
  max-width: 500px;
  flex: 1;
}

.area-principal {
  background-color: #d0d570;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 350px;
  overflow: hidden;
}

.area-principal img,
.area-principal video {
  max-height: 100%;
  max-width: 100%;
}

.navegacao {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 100%;
  display: flex;
  justify-content: space-between;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.galeria:hover .navegacao {
  opacity: 1;
}

.navegacao button {
  background: rgba(0,0,0,0.4);
  border: none;
  color: white;
  font-size: 2rem;
  padding: 0.5rem 1rem;
  cursor: pointer;
}

.gallery-role {
  display: flex;
  gap: 0.5rem;
  overflow-x: auto;
  margin-top: 1rem;
  padding-bottom: 0.5rem;
}

.gallery-role img,
.gallery-role video {
  height: 60px;
  cursor: pointer;
  border: 2px solid transparent;
  border-radius: 4px;
}

.gallery-role img:hover,
.gallery-role video:hover {
  border-color: #007BFF;
}

.detalhes {
  flex: 1;
  min-width: 250px;
}

.detalhes h1 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
}

.detalhes p {
  margin-bottom: 1rem;
  font-size: 1rem;
  line-height: 1.4;
}

.detalhes .price {
  font-size: 1.5rem;
  font-weight: bold;
  color: #333;
}

.btn-compra {
  display: inline-block;
  padding: 0.8rem 2rem;
  background-color: #00c853;
  color: white;
  font-weight: bold;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.btn-compra:hover {
  background-color: #009624;
}
</style>

<section class="produto-detalhe">
  <div class="produto-container">
    <div class="galeria">
      <div class="navegacao setas">
        <button id="prev">&#60;</button>
        <button id="next">&#62;</button>
      </div>

      <div class="area-principal">
        <img id="media-principal" src="assets/img/produtos/articulador_1.jpg" alt="Articulador">
      </div>

      <div class="gallery-role">
        <img class="miniatura" src="assets/img/produtos/articulador_1.jpg" data-src="assets/img/produtos/articulador_1.jpg">
        <img class="miniatura" src="assets/img/produtos/articulador_2.jpg" data-src="assets/img/produtos/articulador_2.jpg">
        <video class="miniatura" data-src="assets/videos/articulador_demo.mp4" src="assets/videos/articulador_demo.mp4"></video>
      </div>
    </div>

    <div class="detalhes">
      <h1>Articulador</h1>
      <p>Descrição detalhada do produto. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nibh ex, facilisis quis odio eu, congue suscipit ipsum.</p>
      <p class="price">R$ 25,00</p>
      <a href="scripts/pagamento.php?id=1" class="btn btn-compra">ADQUIRIR</a>
    </div>
  </div>
</section>

<script>
  const miniaturas = document.querySelectorAll('.miniatura');
  let mediaPrincipal = document.getElementById('media-principal');
  const prev = document.getElementById('prev');
  const next = document.getElementById('next');
  let index = 0;

  const midias = Array.from(miniaturas);

  function exibirMidia(i) {
    const novaSrc = midias[i].getAttribute('data-src');
    if (novaSrc.endsWith('.mp4')) {
      mediaPrincipal.outerHTML = `<video id=\"media-principal\" controls autoplay src=\"${novaSrc}\"></video>`;
    } else {
      mediaPrincipal.outerHTML = `<img id=\"media-principal\" src=\"${novaSrc}\" alt=\"Midia do produto\">`;
    }
    mediaPrincipal = document.getElementById('media-principal');
  }

  miniaturas.forEach((m, i) => {
    m.addEventListener('click', () => {
      index = i;
      exibirMidia(i);
    });
  });

  prev.addEventListener('click', () => {
    index = (index - 1 + midias.length) % midias.length;
    exibirMidia(index);
  });

  next.addEventListener('click', () => {
    index = (index + 1) % midias.length;
    exibirMidia(index);
  });
</script>
