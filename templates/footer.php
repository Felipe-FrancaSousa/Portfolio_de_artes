
<footer>
    <div class="rodape">
        <div class="rodape-img">
            <a href="#top"><img src="img/logo-footer.png" alt="logo2" title="Voltar pro topo"></a>
        </div>
    </div>
    <p style="text-align: center;">Copyright Largatixa Tropical - 2026.</p>
    <p style="text-align: center;"> Todos os direitos reservados. O compartilhamento de todas as imagens presentes nesse site, sem o consentimento da artista, estão proibidas</p>
</footer>
<script src="<?= $BASE_URL ?>/helpers/lightbox2-2.11.5/js/lightbox.js"></script>
<script>

    $("a[href='#top']").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
    });
 
    lightbox.option({
      'fadeDuration': 100,
      'wrapAround': true,
      'imageFadeDuration': 0,
      'showImageNumberLabel': false,
      'alwaysShowNavOnTouchDevices': true,
    })
</script>
</body>