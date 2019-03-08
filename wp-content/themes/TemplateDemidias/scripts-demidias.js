/* Scripts DEMIDIAS */

$(document).ready(function(){

/* URL Modal */

  if(window.location.hash.substr(1) != ""){
      $('#'+ window.location.hash.substr(1)).modal('show');
  }

 });

/* Botao Top */

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("botaoSubir").style.display = "block";
    } else {
        document.getElementById("botaoSubir").style.display = "none";
    }
}

function topFunction() {
    $('body,html').animate({
        scrollTop : 0
    }, 500);
}


/* Masonry Layout */

var $grid = $('.trabalhos').masonry({
  itemSelector: 'none', // select none at first
  columnWidth: '.grid__col-sizer',
  gutter: '.grid__gutter-sizer',
  percentPosition: true,
  stagger: 30,
  // nicer reveal transition
  visibleStyle: { transform: 'translateY(0)', opacity: 1 },
  hiddenStyle: { transform: 'translateY(100px)', opacity: 0 },
});

// get Masonry instance
var msnry = $grid.data('masonry');

// initial items reveal
$grid.imagesLoaded( function() {
  $grid.removeClass('are-images-unloaded');
  $grid.masonry( 'option', { itemSelector: '.trabalho' });
  var $items = $grid.find('.trabalho');
  $grid.masonry( 'appended', $items );
});


/* Infinte Scroll */


if ( $('a.next.page-numbers').length ) {

$grid.infiniteScroll({
  path: 'a.next.page-numbers',
  append: '.trabalho',
  outlayer: msnry,
  status: '.page-load-status',
  hideNav: '.navegacao'
});


}

/* Revelando Busca Mobile */

document.querySelector(".botao-lupa").addEventListener("click", function(){
    
    if ($('.input-pesquisar').is(':visible')) {
    document.querySelector(".input-pesquisar").style.display = "none";
    }
    else {
    document.querySelector(".input-pesquisar").style.display = "block";
    }

    if ($('.bg-pesquisar').is(':visible')) {
    document.querySelector(".bg-pesquisar").style.display = "none";
    }
    else {
    document.querySelector(".bg-pesquisar").style.display = "block";
    }

});

/* Revelando iFrame Login */

if ($('.botao-logar-topo')[0]) {

  document.querySelector(".botao-logar-topo").addEventListener("click", function(){
      
      if ($('#iframeLogin').is(':visible')) {
      document.querySelector("#iframeLogin").style.display = "none";
      }
      else {
      document.querySelector("#iframeLogin").style.display = "block";
      }

  });
}

/* Revelando iFrame Logado */

if ($('.icone-usuario')[0]) {

  document.querySelector(".icone-usuario").addEventListener("click", function(){
      
      if ($('#iframeLogado').is(':visible')) {
      document.querySelector("#iframeLogado").style.display = "none";
      }
      else {
      document.querySelector("#iframeLogado").style.display = "block";
      }

  });
}

/* Revelando Categorias */

if($('.cat').length){

  document.querySelector(".cat").addEventListener("click", function(){
      
      if ($('.menu-oculto').is(':visible')) {
      document.querySelector(".menu-oculto").style.display = "none";
      }
      else {
      document.querySelector(".menu-oculto").style.display = "block";
      }

  });

}