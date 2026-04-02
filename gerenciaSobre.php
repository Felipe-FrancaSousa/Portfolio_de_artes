<?php $titulo = "Uploade de coleção" ;?>
<?php include_once("templates/header.php");?>
<main>
    <div class="ferramentas">
        <?php
            if (is_uploaded_file($_FILES['foto']['tmp_name'])) {

                $name = $_FILES['foto']['name'];
                $type = $_FILES['foto']['type'];
                $size = $_FILES['foto']['size'];
                $temp = $_FILES['foto']['tmp_name'];
                $error = $_FILES['foto']['error'];

                $target_dir = "data/sobre/";
                $target_file = $target_dir . basename($name);
                $uploadOk = false;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $imageName = basename($_FILES['foto']['name'], (".".$imageFileType));

                if(isset($_POST["submitSobre"])) {
                    $check = getimagesize($temp);
                    if($check !== false) {
                        $uploadOk = true;
                    } else {
                        echo "Arquivo <b>". $name ."</b> não é uma imagem. <br>";
                        $uploadOk = false;
                    }
                }

                    // Checa o tamanho do arquivo
                if ($size > 5120000) {
                    echo "Arquivo <b>". $name ."</b> é muito grande, máximo permitido de 5MB. <br>";
                    $uploadOk = false;
                }

                    // Define quais formatos de arquivos são aceitos
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "webp" ) {
                    echo "Apenas arquivos no formato JPG, JPEG, PNG e WEBP são permitidos. <br>";
                    $uploadOk = false;
                }

                if($uploadOk){

                    // Configuração do DOMDocument para formatação do XML
                    $dom=new DOMDocument;
                    $dom->ownerDocument;
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;
                    $dom->loadXML($xml->asXML());

                    // Define onde está a raiz do XML
                    $root = $dom->getElementsByTagName('sobre')->item(0);
                    $fotoAtual = $root->getElementsByTagName('foto')->item(0);


                    $fotoAtualValue = $fotoAtual->textContent.".".$fotoAtual->getAttribute('type');

                    unlink("data/sobre/$fotoAtualValue");

                    // Cria e separa o elemento foto de sua extenxão
                    $foto = $dom->createElement('foto', $imageName);
                    $root->replaceChild($foto, $fotoAtual);
                    $foto->setAttribute('type', $imageFileType);

                    if (move_uploaded_file($temp, $target_file)) {
                        echo " > A foto <b>". htmlspecialchars( basename($name)). " foi enviada com sucesso! <br><br>";
                    } else {
                        echo "<br>Erro ao enviar arquivo. <br>";
                    }

                    // Salva o arquivo usando o DOMDocument para manter a formatação
                    $dom->save('data/dados.xml') or die('XML Create Error');
                    echo "<br><br><h1>Atualização da foto finalizada com sucesso!</h1><br>";
                }else{
                    echo "Erro, arquivo <b>". $name ."</b> não foi enviado. <br>";
                    echo "<br><br><h1>Envio cancelado.</h1><br>";
                }

            }
            
            if($_POST['texto'] != ""){
                // Configuração do DOMDocument para formatação do XML
                $dom=new DOMDocument;
                $dom->ownerDocument;
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($xml->asXML());

                $root = $dom->getElementsByTagName('sobre')->item(0);
                $textoAtual = $root->getElementsByTagName('texto')->item(0);

                $texto = $dom->createElement('texto', $_POST['texto']);
                $root->replaceChild($texto, $textoAtual);

                $dom->save('data/dados.xml') or die('XML Create Error');
                echo "<br><br><h1>Atualização do texto finalizado com sucesso!</h1><br>";
            }else{
                echo "<br><br><h1>Nenhum texto foi enviado.</h1><br>";
            }
        ?>
    </div>
</main>
        <div class="voltar">
            <a href="<?=$BASE_URL?>gerenciamento.php"><h1>Voltar</h1></a>
        </div>
<?php include_once("templates/footer.php");?>