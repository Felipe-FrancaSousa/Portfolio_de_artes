<?php $titulo = "Uploade de evento" ;?>
<?php include_once("templates/header.php");?>
<main>
    <div class="ferramentas">
        <?php 
        // ---------------------EDITAR------------------------------  


        // ---------------------EXCLUIR-----------------------------  

            if(isset($_POST["submitExclude"])) {
                $eventoRD = $_POST['eventoRD'];

                $dom=new DOMDocument;
                $dom->ownerDocument;
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $dom->loadXML($xml->asXML());

                $root = $dom->getElementsByTagName('evento')->item(0);
                $child = $root->getElementsByTagName('mesa');

                foreach($child as $evento){
                    $id = $evento->getAttribute('id');

                    if ($id == $eventoRD){
                        $root->removeChild($evento);
                    }
                }

                $dom->save('data/dados.xml') or die('XML Create Error');

                // Remove os arquivos
                unlink("data/eventos/$eventoRD");

                echo "<p>Evento ".$eventoRD." foi excluido com sucesso!<p/>";
            }

        // ---------------------INCLUIR-----------------------------

            if (isset($_FILES['foto'])) {

            $name = $_FILES['foto']['name'];
            $type = $_FILES['foto']['type'];
            $size = $_FILES['foto']['size'];
            $temp = $_FILES['foto']['tmp_name'];
            $error = $_FILES['foto']['error'];

            $target_dir = "data/eventos/";
            $target_file = $target_dir . basename($name);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $imageName = basename($_FILES['foto']['name'], (".".$imageFileType));

            // Checa se a imagem é real
            if(isset($_POST["submit"])) {
            $check = getimagesize($temp);
            if($check !== false) {
                echo "Imagem ". $name ." foi processada. <br>";
                $uploadOk = 1;
            } else {
                echo "Arquivo <b>". $name ."</b> não é uma imagem. <br>";
                $uploadOk = 0;
            }
            }

            // Checa se a imagem já existe
            if (file_exists($target_file)) {
            echo "Arquivo <b>". $name ."</b> já existe no banco de dados. <br>";
            $uploadOk = 0;
            }

            // Checa o tamanho do arquivo
            if ($size > 5120000) {
            echo "Arquivo <b>". $name ."</b> é muito grande, máximo permitido de 5MB. <br>";
            $uploadOk = 0;
            }

            // Define quais formatos de arquivos são aceitos
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Apenas arquivos no formato JPG, JPEG, PNG e GIF são permitidos. <br>";
            $uploadOk = 0;
            }

            // Checa se o $uploadOk foi definido pra 0 por algum erro
            if ($uploadOk == 0) {
            echo "Erro, arquivo <b>". $name ."</b> não foi enviado. <br>";

            // Se tudo estiver ok, tenta enviar o arquivo
            } else {
            if (move_uploaded_file($temp, $target_file)) {
                echo " > O arquivo <b>". htmlspecialchars( basename($name)). "</b> do evento  <b>". $_POST['nomeEvento'] ."</b> foi enviado com sucesso! <br><br>";
            } else {
                echo "<br>Erro ao enviar arquivo. <br>";
            }
            }

            // Se o arquivo da foto estiver ok, as informações são gravadas no XML
            if($uploadOk == 1){

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

            // Salva o arquivo usando o DOMDocument para manter a formatação
            $dom->save('data/dados.xml') or die('XML Create Error');
            echo "<br><br><h1>Envio finalizado com sucesso!</h1><br>";
            }
        }
        ?>
        <div class="voltar">
            <a href="<?=$BASE_URL?>reservado.php"><h1>Voltar</h1></a>
        </div>
    </div>
</main>
</body>