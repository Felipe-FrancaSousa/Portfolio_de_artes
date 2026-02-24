<?php $titulo = "Gerenciamento" ;?>
<?php include_once("templates/header.php");?>    
    <main>
    <!-- Gerenciamento de coleções -->
        <div class="ferramentas">
            <form action="gerenciaColecao.php" method="post" enctype="multipart/form-data">
                <h1>Gerenciamento das coleções</h1>
                <h2>Inclua uma nova coleção:</h2>
                <p>Nome da coleção: <input type="text" name="colecao" id="colecao" required></p>
                <p>Arquivo: <input type="file" name="arquivo[]" id="arquivo" multiple required></p>
                <p><input type="submit" value="Enviar coleção" name="submitUpload"></p>
            </form>
            <br>
            <form action="gerenciaColecao.php" method="post" enctype="multipart/form-data">
                <h2>Selecionar coleção para excluir:</h2>
                <p><label for="colections">Selecione a coleção:</label></p>
                <select name="colecaoDD" id="colecaoDD" required>
                    <option value="" disabled selected>-Coleções-</option>
                    <?php foreach($xml->posts->colecao as $pasta):?>
                    <option value="<?=$pasta['id']?>" ><?=$pasta->nome?></option>
                    <?php endforeach?>
                </select>
                <p><input type="submit" value="Excluir" name="submitExclude"></p>
            </form>
        </div>
        <!-- Gerenciamento de eventos -->
        <div class="ferramentas">
            <form action="gerenciaEvento.php" method="post" enctype="multipart/form-data">
                <h1>Selecionar foto de evento anterior para upload:</h1>
                <p>Nome do evento: <input type="text" name="nomeEvento" id="nomeEvento" required></p>
                <p>Data do evento: <input type="date" name="date" id="date" required></p>
                <p>Foto: <input type="file" name="foto" id="foto" required></p>
                <p><input type="submit" value="Enviar fotos" name="submit"></p>
            </form>
            <br>
            <form action="gerenciaEvento.php" method="post" enctype="multipart/form-data">
                <h2>Selecionar Evento para excluir:</h2>
                <p><label for="colections">Selecione o evento:</label></p>
                <select name="eventoDD" id="eventoDD" required>
                    <option value="" disabled selected>-Eventos:-</option>
                    <?php foreach($xml->evento->mesa as $mesa):?>
                    <option value="<?=$mesa['id']?>" ><?=$mesa->nome?></option>
                    <?php endforeach?>
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