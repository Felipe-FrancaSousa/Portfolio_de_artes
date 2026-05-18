<?php include_once("helpers/url.php");?>
<?php
    $valor = $_GET['colecao'];

    foreach($xml->posts->colecao as $evento):
        if($evento['id'] == $valor):

            $dataXML = $evento->data;
            $array = explode("/",$dataXML);
            $formatado = $array[2]."-".$array[1]."-".$array[0];
?>
            <h2>Atualizar informações:</h2>
            <p>Nome da imagem: <input type="text" name="nomeImg" id="nomeImg" value="<?=$evento->nome?>"></p>
            <p>Foto: <input type="file" name="foto" id="foto" ></p>
            <p><input type="submit" value="Enviar" name="submitEditar"></p>
<?php
        endif;
    endforeach;
?>