import '../styles/movie.scss';

// start the Stimulus application
import '../bootstrap';


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
               let html = '' +
                   '<div class="card col-2 my-2 mx-1 p-2">\n' +
                   '    <img class="card-img-top" src="https://image.tmdb.org/t/p/w500/' +  movie.poster_path + '" alt="Card image cap">\n' +
                   '    <div class="card-body">\n' +
                   '        <h5 class="card-title">' + movie.title + '</h5>\n' +
                   '        <p class="card-title">(' + movie.original_title + ')</p>\n' +
                   '    </div>\n' +
                   '    <a href="#" class="btn btn-primary mb-3">Ajouter</a>\n' +
                   '</div>' ;
               container.append(html);
           });
           $('html, body').animate({
               scrollTop: $('#movieNb').offset().top
           }, 400)
        }
    })
});

