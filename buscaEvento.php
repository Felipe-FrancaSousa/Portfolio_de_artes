<?php include_once("helpers/url.php");?>
<?php
    $valor = $_GET['evento'];

    foreach($xml->evento->mesa as $evento):
        if($evento['id'] == $valor):

            $dataXML = $evento->data;
            $array = explode("/",$dataXML);
            $formatado = $array[2]."-".$array[1]."-".$array[0];
?>
            <h2>Atualizar informações:</h2>
            <p>Nome do evento: <input type="text" name="nomeEvento" id="nomeEvento" value="<?=$evento->nome?>"></p>
            <p>Data do evento: <input type="date" name="date" id="date" value="<?=$formatado?>"></p>
            <p>Foto: <input type="file" name="foto" id="foto" ></p>
            <p><input type="submit" value="Enviar" name="submitEditar"></p>
<?php
        endif;
    endforeach;
?>