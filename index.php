<?php $titulo = "Artes" ;?>
<?php include_once("templates/header.php");?>
    <main>
        <div class="restrito">
             <a href="<?=$BASE_URL?>login.php">
                <img src="img/editar.png" alt="Editar">
            </a>
        </div>
        <!-- Seção para as coleções de artes -->
        <section>
            <!-- Cria o carrossel de imagens, variável $i é usado para conseguir criar vários carrosseis TinySlider2 na página -->
            <?php $i = 0; foreach($xml->posts->colecao as $colecao):?>
                <script type="module">
                    var slider = tns({
                        container: '.my-slider<?= $i ?>',
                        items: 2, // Quantidade de itens que são exibidos ao mesmo tempo
                        slideBy: 2,
                        Lazyload: true,
                        touch: true,
                        autoplay: true,
                        autoWidth:true,
                        mouseDrag: true, // Seta se o carousel pode ser rotacionado com o movimento de clicar e arrastar do mouse
                        autoplayButtonOutput: false, // Seta visibilidade do botão de auto play
                        controls: true, // seta visibilidade das setas de controle
                        controlsText: ["",""],
                        nav: false, // Seta visibilidade da navegação (3 pontinhos)
                        responsive:{
                            500:{
                                items: 4,
                            }
                        }
                    });
                </script>
                <!-- Puxa o nome da coleção do XML --> 
                <div class="colecao-linhas">
                    <div class="nome-conteiner">
                        <h1 class="colecao-nome"><?=$colecao->nome?></h1>
                    </div>
                    <!-- Cria o conteudo dos carrosseis -->
                    <div class="my-slider<?= $i?>" >
                        <?php foreach($colecao->img as $arquivo):?>
                            <div class="colecao-img" style ="background: url(<?=$BASE_URL?>data/artes/<?= str_replace(' ','_',$colecao->nome)?>/<?= str_replace(' ', '%20', $arquivo)?>.<?=$arquivo['type']?>);background-size:100% 100%;background-repeat: no-repeat;" >
                                <a href="<?=$BASE_URL?>data/artes/<?= str_replace(' ','_',$colecao->nome)?>/<?= str_replace(' ', '%20', $arquivo)?>.<?=$arquivo['type']?>" data-lightbox="<?=$colecao->nome?>" data-title="<?=$arquivo?>" draggable="false">
                                    <!-- Cria o overlay com o nome da imagem --> 
                                    <div class = "colecao-img-overlay">
                                        <span><h1><?php echo str_replace('_', ' ', $arquivo); ?></h1></span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php $i++; endforeach; ?>
        </section>
        <!-- Seção para os eventos anteriores -->
        <section>
            <div class="evento-conteiner">
                <div class="nome-conteiner">
                    <h1 class="colecao-nome">Eventos já participados: </h1>
                </div>
                <div class="evento-grid">
                    <?php foreach($xml->evento->mesa as $mesas):?>
                        <div class="evento-img" style ="background: url(<?=$BASE_URL?>data/eventos/<?= str_replace(' ', '%20', $mesas->foto)?>.<?=$mesas->foto['type']?>);
                                                        background-position: center;
                                                        background-repeat: no-repeat;
                                                        background-size: cover;
                                                        ">
                            <!-- Cria o overlay com o nome da imagem -->
                            <a href="<?=$BASE_URL?>data/eventos/<?= str_replace(' ', '%20', $mesas->foto)?>.<?=$mesas->foto['type']?>" data-lightbox="eventos" data-title="<?=$mesas->nome?> - <?=$mesas->data?>" draggable="false">
                                <div class = "evento-img-overlay">
                                    <span>
                                        <h1><?php echo $mesas->nome?></h1>
                                        <h1><?php echo $mesas->data?></h1>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </section>
    </main>
<?php include_once("templates/footer.php");?>