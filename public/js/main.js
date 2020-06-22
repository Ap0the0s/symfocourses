function togglePreloader() {
    $('.preloader').toggleClass('show');
}

$('.nav_btn').click(function () {

    var current_page = parseInt($('.current_p').text());
    var count_page = parseInt($('.count_p').text());
    var per_page = $('.per_page').val();

    if($(this).hasClass('prev')) {
        var lead_page = (current_page - 1) > 0 ? (current_page - 1) : 1;
    }else if($(this).hasClass('next')){
        var lead_page = (current_page + 1) < count_page ? (current_page + 1) : count_page;
    }

    $('.current_p').text(lead_page);

    switch (lead_page) {
        case 1:
            $('.nav_btn.prev').attr('disabled','disabled');
            break;
        case count_page:
            $('.nav_btn.next').attr('disabled','disabled');
            break;
        default:
            $('.nav_btn.prev').removeAttr('disabled');
            $('.nav_btn.next').removeAttr('disabled');
    }

    getSlice(lead_page, per_page);
})

function getSlice(page,per_page) {
    $.ajax({
        'type': "POST",
        'url': '/',
        'data': "page="+page + "&per_page="+ per_page,
        'beforeSend': function () {
            togglePreloader();
        },
        'success': function (answer) {
            togglePreloader();
            if(answer.length) {
                $('table.table tbody').html(answer);
            } else {
                alert('Что-то пошло не так');
            }
        },
        'error': function () {
            togglePreloader();
            alert('Что-то пошло не так');
        }

    });
}