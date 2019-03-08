
<footer>

	<button onclick="topFunction()" id="botaoSubir" title="Voltar para o topo">&#9650;</button>

	<div class="bg-footer">
		<div class="container-footer">
			<div class="visite-footer">
				<a href="http://www.cchla.ufpb.br/ccmd" target="_blank">Visite o site do curso de Mídias Digitais</a>
			</div>
			<div class="menus-footer">
				<p><a href="http://www.cchla.ufpb.br/ccmd" target="_blank">CCMD</a> | <a href="http://www.cchla.ufpb.br" target="_blank">CCHLA</a> | <a href="http://www.ufpb.br/" target="_blank">UFPB</a> | <a href="<?php echo esc_url( home_url( '/' ) ); ?>sobre">Sobre o DEMIDIAS</a> | <a href="https://www.instagram.com/midias2016.2/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icone-insta.png"></a> <a href="https://www.facebook.com/pages/Departamento-de-M%C3%ADdias-Digitais-UFPB/211241932405616" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icone-face.png"></a>
			</div>
		</div>
	</div>
</footer>

<!-- Scripts DEMIDIAS -->
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/jquery.min.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/jquery-ui.min.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/jquery.modal.min.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/masonry.pkgd.min.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/infinite-scroll.pkgd.min.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/scripts-demidias.js"></script>

<?php wp_footer(); ?>

</body>
</html>