<?php $titulo = "Gerenciamento" ;?>
<?php include_once("templates/header.php");?>    
    <main>
        <script type="application/javascript">
            function alterarForm(selecao){
                const valor = selecao.value;

                fetch("buscar.php?colecao=" + valor)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("excluir").innerHTML = data;
                    });
            }
            function toggle(source) {
                checkboxes = document.getElementsByName('excluirCB[]');
                for(var checkbox in checkboxes)
                    checkboxes[checkbox].checked = source.checked;
            }
        </script>
    <!-- Gerenciamento de coleções -->
        <div class="ferramentas">
            <!--Inclusão nova coleção-->
            <form action="gerenciaColecao.php" method="post" enctype="multipart/form-data">
                <h1>Gerenciamento das coleções</h1>
                <h2>Inclua uma nova coleção:</h2>
                <p>Nome da coleção: <input type="text" name="colecao" id="colecao" required></p>
                <p>Arquivos: <input type="file" name="arquivo[]" id="arquivo" multiple required></p>
                <p><input type="submit" value="Enviar coleção" name="submitColecao"></p>
            </form>
            <br>

            <!--Inclusão em coleção já existente-->
            <form action="gerenciaColecao.php" method="post" enctype="multipart/form-data">
                <h2>Inlcuir em coleção já existente: </h2>
                <p>Coleção: <select name="incluirDD" id="incluirDD" required>
                    <option value="" disabled selected>-Coleções-</option>
                    <?php foreach($xml->posts->colecao as $pasta):?>
                    <option value="<?=$pasta['id']?>" ><?=$pasta->nome?></option>
                    <?php endforeach?>
                </select></p>
                <p>Arquivos: <input type="file" name="arquivo[]" id="arquivo" multiple required></p>
                <p><input type="submit" value="Incluir na coleção" name="submitIncluir"></p>
            </form>
            <br>

            <!--Exclusão-->
            <form action="gerenciaColecao.php" method="post" enctype="multipart/form-data">
                <h2>Selecione uma coleção para editar</h2>
                <p><label for="colections">Selecione as imagens para excluir:</label></p>
                <select name="excluirDD" id="excluirDD" required onchange="alterarForm(this)">
                    <option value="" disabled selected>-Coleções-</option>
                    <?php foreach($xml->posts->colecao as $pasta):?>
                    <option value="<?=$pasta['id']?>" ><?=$pasta->nome?></option>
                    <?php endforeach?>
                </select>
                <br>
                    <div id="excluir">
                    </div>
                <p><input type="submit" value="excluir" name="submitExcluir"></p>
            </form>
        </div>


        <!-- Gerenciamento de eventos -->
        <div class="ferramentas">
            <!--Inclusão-->
            <form action="gerenciaEvento.php" method="post" enctype="multipart/form-data">
                <h1>Selecionar foto de evento anterior para upload:</h1>
                <p>Nome do evento: <input type="text" name="nomeEvento" id="nomeEvento" required></p>
                <p>Data do evento: <input type="date" name="date" id="date" required></p>
                <p>Foto: <input type="file" name="foto" id="foto" required></p>
                <p><input type="submit" value="Enviar fotos" name="submit"></p>
            </form>
            <br>

            <!--Exclusão-->
            <form action="gerenciaEvento.php" method="post" enctype="multipart/form-data">
                <h2>Selecionar Evento para excluir:</h2>
                <p><label for="colections">Selecione o evento:</label></p>
                <br>
                    <div class="excluirEvento-grid">
                        <?php foreach($xml->evento->mesa as $mesa):?>
                            <div class="excluirEvento-opcao">
                                <input type='radio' name='eventoRD' id='<?=$mesa['id']?>' value='<?=$mesa['id']?>'>
                                <label for='<?=$mesa['id']?>' id='labelRD'><?=$mesa->nome?>
                                <div class="colecao-img" style ="margin: 0 auto;width: 10vw;height: 10vw;background: url(<?=$BASE_URL?>data/eventos/<?= str_replace(' ', '%20', $mesa->foto)?>.<?=$mesa->foto['type']?>);background-size:100% 100%;"></div>
                                </label>
                            </div>
                        <?php endforeach?>
                    </div>
                </select>
                <p><input type="submit" value="Excluir" name="submitExclude"></p>
            </form>
        </div>
        </div>
            <div class="voltar">
                <a href="<?=$BASE_URL?>/index.php"><h1>Voltar</h1></a>
            </div>
    </main>
</body>