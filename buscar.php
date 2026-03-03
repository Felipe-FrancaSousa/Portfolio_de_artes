<?php include_once("helpers/url.php");?> 
<?php
    $valor = $_GET['colecao'];
?>              
            <div class="excluirCB-all">
                <input type="checkbox" name="all" id="all" onClick="toggle(this)" />
                <label for="all">(Selecionar tudo)</label>
                <br/>
            </div>
            <div class="excluirCB-grid">
<?php
    foreach($xml->posts->colecao as $colecao):
        if($colecao['id'] == $valor):
            foreach($colecao->img as $arquivo):
?>
            <div class="excluirCB-opcao">
                <input type='checkbox' name='excluirCB[]' id='<?=$arquivo?>' value='<?=$arquivo?>'>
                <label for='<?=$arquivo?>' id='labelCB'><?=$arquivo?>
                <div class="colecao-img" style ="margin: 0 auto;width: 10vw;height: 10vw;background: url(<?=$BASE_URL?>data/artes/<?= str_replace(' ','_',$colecao->nome)?>/<?= str_replace(' ', '%20', $arquivo)?>.<?=$arquivo['type']?>);background-size:100% 100%;"></div>
                </label>
            </div>
<?php
            endforeach;
        endif;
    endforeach;
?>
</div>