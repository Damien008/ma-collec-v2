import '../styles/movie.scss';

// start the Stimulus application
import '../bootstrap';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

//Chargement d'une nouvelle page de films lors de la recherche
$('.nbPage').on('click', function () {
    $.ajax({
        url: '/movie/search_by_page',
        type: 'GET',
        data: {
            page: $(this).data('page'),
            search: $(this).data('search'),
        },
        success: function (data) {
            let container = $('#cardsMoviesSearch');
            container.html('');
           $.each(data['results'], function (index, movie) {
               let imgUrl = movie.poster_path ? "https://image.tmdb.org/t/p/w500/" + movie.poster_path : "../../images/image-non-disponible.jpg";
               let html = '' +
                   '<div class="card col-2 my-2 mx-1 p-2">\n' +
                   '    <img class="card-img-top" src="' +  imgUrl + '" alt="Card image cap">\n' +
                   '    <div class="card-body">\n' +
                   '        <h5 class="card-title">' + movie.title + ' <i class="fa fa-xs fa-info-circle text-info" aria-hidden="true" title="' + movie.overview + '"></i></h5>' +
                   '        <p>(' + movie.original_title + ')</p>' +
                   '    </div>\n' +
                   '    <a href="#" class="btn btn-primary mb-3">Ajouter</a>' +
                   '</div>' ;
               container.append(html);
           });
           $('html, body').animate({
               scrollTop: $('#movieNb').offset().top
           }, 100)
        }
    })
});

//ajout du support pour uin film

$('.addSupport').on('click', function () {
    let id = $(this).data('id');
    $.ajax({
        url: '/movie/ajout-support',
        type: 'GET',
        success: function (data) {
            $('#supportModal').modal('show');
            $('#modal-form').html(data);
            $('#support_idMovie').val(id);
        }
    })
})

//ajout d'un film à la collection d'un utilisateur
$('#addMovie').on('click', function () {
    $.ajax({
        url: '/movie/ajout-film',
        type: 'POST',
        data:  $('#modal-form form').serialize(),
        error: function(){
            console.error(xhr.responseText); // Affichage des détails de l'erreur dans la console
            alert('Une erreur est survenue. Veuillez vérifier la console pour plus de détails.');
        },
        success: function (data) {
                $('#supportModal').modal('toggle');
                $('#successModal .modal-body').html(data.message);
                $('#successModal').modal('toggle');
        }
    })
})

//affichage du détails d'une carte de film dans la collection
$('.movie-card').on('click', function(){
    let box = $('.box');
    box.removeClass('d-none').addClass('zoom-in');
    $('.img-box-front').attr('src', 'https://image.tmdb.org/t/p/w500' + $(this).data('posterpath'))
    $('.movie-title').text($(this).data('title'));
    $('.movie-originalTitle').text($(this).data('originaltitle'));
    $('.movie-runtime').text($(this).data('runtime') + ' min');
    $('.movie-overview').text($(this).data('overview'));
    $('.movie-detail').attr('href', '/movie/show/' + $(this).data('id') );

    $('.cross-icon').on('click', function () {
        box.removeClass('zoom-in').addClass('d-none');
    })
    $('.arrow-icon').on('click', function () {
        $('.box-inner').css('transform', 'rotateY(180deg)');
    })
    $('.arrow-iconBack').on('click', function () {
        $('.box-inner').css('transform', 'rotateY(0)');
    })
})

