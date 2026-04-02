<?php $titulo = "Uploade de evento" ;?>
<?php include_once("templates/header.php");?>
<main>
    <div class="ferramentas">
        <?php 
    // ---------------------INCLUIR-----------------------------
            if(isset($_POST["submitIncluir"])) {
                if (is_uploaded_file($_FILES['foto']['tmp_name'])) {

                    $name = $_FILES['foto']['name'];
                    $type = $_FILES['foto']['type'];
                    $size = $_FILES['foto']['size'];
                    $temp = $_FILES['foto']['tmp_name'];
                    $error = $_FILES['foto']['error'];

                    $target_dir = "data/eventos/";
                    $target_file = $target_dir . basename($name);
                    $uploadOk = false;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $imageName = basename($_FILES['foto']['name'], (".".$imageFileType));

                    // Checa se a imagem é real
                        $check = getimagesize($temp);
                        if($check !== false) {
                            $uploadOk = true;
                        } else {
                            echo "Arquivo <b>". $name ."</b> não é uma imagem. <br>";
                            $uploadOk = false;
                        }

                        // Checa se a imagem já existe
                    if (file_exists($target_file)) {
                        echo "Arquivo <b>". $name ."</b> já existe no banco de dados. <br>";
                        $uploadOk = false;
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

                        // Se o arquivo da foto estiver ok, as informações são gravadas no XML
                    if($uploadOk){

                        // Configuração do DOMDocument para formatação do XML
                        $dom=new DOMDocument;
                        $dom->ownerDocument;
                        $dom->preserveWhiteSpace = false;
                        $dom->formatOutput = true;
                        $dom->loadXML($xml->asXML());

                        // Define onde está a raiz do XML
                        $root = $dom->getElementsByTagName('evento')->item(0);

                        // Cria o elemento mesa com um atributo ID
                        $mesa = $dom->createElement('mesa');
                        $root->appendChild($mesa);
                        $mesa->setAttribute('id', $name);

                        // Cria e inclui os elemntos de nome da coleção e as imagens
                        $nome = $dom->createElement('nome', $_POST['nomeEvento']);
                        $mesa->appendChild($nome);

                        // Cria e formata o elemento data
                        // $formatado = str_replace("-","/",$_POST['date']);
                        $array = explode("-",$_POST['date']);
                        $formatado = $array[2]."/".$array[1]."/".$array[0];
                        $date = $dom->createElement('data', $formatado);
                        $mesa->appendChild($date);

                        // Cria e separa o elemento foto de sua extenxão
                        $foto = $dom->createElement('foto', $imageName);
                        $mesa->appendChild($foto);
                        $foto->setAttribute('type', $imageFileType);

                        if (move_uploaded_file($temp, $target_file)) {
                            echo " > O arquivo <b>". htmlspecialchars( basename($name)). "</b> do evento  <b>". $_POST['nomeEvento'] ."</b> foi enviado com sucesso! <br><br>";
                        } else {
                            echo "<br>Erro ao enviar arquivo. <br>";
                        }

                        // Salva o arquivo usando o DOMDocument para manter a formatação
                        $dom->save('data/dados.xml') or die('XML Create Error');
                        echo "<br><br><h1>Envio finalizado com sucesso!</h1><br>";
                    }else{
                        echo "Erro, arquivo <b>". $name ."</b> não foi enviado. <br>";
                        echo "<br><br><h1>Envio cancelado.</h1><br>";
                    }
                }else{
                    echo "<br><br><h1>Erro no carregamento da imagem.</h1><br>";
                }
            }

    // ---------------------EXCLUIR-----------------------------  

            if(isset($_POST["submitExcluir"])) {
                $eventoRD = $_POST['eventoRD'];

                $dom=new DOMDocument;
                $dom->ownerDocument;
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($xml->asXML());

                $root = $dom->getElementsByTagName('evento')->item(0);
                $mesas = $root->getElementsByTagName('mesa');

                foreach($mesas as $mesa){
                    $id = $mesa->getAttribute('id');

                    if ($id == $eventoRD){
                        $root->removeChild($mesa);
                    }
                }

                $dom->save('data/dados.xml') or die('XML Create Error');

                // Remove os arquivos
                unlink("data/eventos/$eventoRD");
                echo "<br><br><h1>Evento ".$eventoRD." foi excluido com sucesso!<br><br><h1>";
            }

    // ---------------------EDITAR------------------------------ 
                
            if(isset($_POST["submitEditar"])){
                    $dom=new DOMDocument;
                    $dom->ownerDocument;
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;
                    $dom->loadXML($xml->asXML());

                    $eventoRD = $_POST['eventoRD'];

                    // Define onde está a raiz do XML
                    $root = $dom->getElementsByTagName('evento')->item(0);
                    $mesas = $root->getElementsByTagName('mesa');

                if($_POST['nomeEvento'] != ""){

                    foreach($mesas as $mesa){
                        $id = $mesa->getAttribute('id');
                        
                        if ($id == $eventoRD){

                            $nomeAtual = $mesa->getElementsByTagName('nome')->item(0);
                            $nome = $dom->createElement('nome', $_POST['nomeEvento']);

                            $mesa->replaceChild($nome, $nomeAtual);
                        }
                    }
                    echo "<br><br><h1>Atualização do nome finalizado com sucesso!</h1><br>";
                }
                
                if($_POST['date'] != ""){

                    foreach($mesas as $mesa){
                        $id = $mesa->getAttribute('id');
                        
                        if ($id == $eventoRD){

                            $dataAtual = $mesa->getElementsByTagName('data')->item(0);
                            $array = explode("-",$_POST['date']);
                            $formatado = $array[2]."/".$array[1]."/".$array[0];
                            $date = $dom->createElement('data', $formatado);

                            $mesa->replaceChild($date, $dataAtual);
                        }
                    }
                    echo "<br><br><h1>Atualização da data finalizada com sucesso!</h1><br>";
                }

                if (is_uploaded_file($_FILES['foto']['tmp_name'])) {

                    $name = $_FILES['foto']['name'];
                    $type = $_FILES['foto']['type'];
                    $size = $_FILES['foto']['size'];
                    $temp = $_FILES['foto']['tmp_name'];
                    $error = $_FILES['foto']['error'];

                    $target_dir = "data/eventos/";
                    $target_file = $target_dir . basename($name);
                    $uploadOk = false;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $imageName = basename($_FILES['foto']['name'], (".".$imageFileType));


                    $check = getimagesize($temp);
                    if($check !== false) {
                        $uploadOk = true;
                    } else {
                        echo "Arquivo <b>". $name ."</b> não é uma imagem. <br>";
                        $uploadOk = false;
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

                        foreach($mesas as $mesa){
                            $id = $mesa->getAttribute('id');
                            
                            if ($id == $eventoRD){
                                $fotoAtual = $mesa->getElementsByTagName('foto')->item(0);
                                $fotoAtualValue = $fotoAtual->textContent.".".$fotoAtual->getAttribute('type');

                                unlink("data/eventos/$fotoAtualValue");

                                // Cria e separa o elemento foto de sua extenxão
                                $foto = $dom->createElement('foto', $imageName);
                                $mesa->replaceChild($foto, $fotoAtual);
                                $foto->setAttribute('type', $imageFileType);
                                $mesa->setAttribute('id', $imageName.".".$imageFileType);

                                if (move_uploaded_file($temp, $target_file)) {
                                    echo " > A foto <b>". htmlspecialchars( basename($name)). " foi enviada com sucesso! <br><br>";
                                } else {
                                    echo "<br>Erro ao enviar arquivo. <br>";
                                }
                            }
                        }
                        echo "<br><br><h1>Atualização da foto finalizada com sucesso!</h1><br>";
                    }else{
                        echo "Erro, arquivo <b>". $name ."</b> não foi enviado. <br>";
                        echo "<br><br><h1>Envio cancelado.</h1><br>";
                    }

                }

                $dom->save('data/dados.xml') or die('XML Create Error');
                
            }

        ?>
        <div class="voltar">
            <a href="<?=$BASE_URL?>gerenciamento.php"><h1>Voltar</h1></a>
        </div>
    </div>
</main>
<?php include_once("templates/footer.php");?>