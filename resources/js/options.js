$(document).ready(() => {
    // alert("Внимание! Данный сайт исключительно демонстрационный: здесь вы можете выбрать товары, добавить их в корзину, зарегистрироваться. Однако, кнопка покупки товаров не приведет к непосредстенной оплате. Все товары вымешлены, совпадения случайны.")

    // Сообщение успех
    if($('.mess_success')) {
        setTimeout(() => {
            $('.mess_success').slideUp();
        }, 2000);
    }

    // Форма поиска
    $('header input').on('focus', () => {
        $('.search').addClass('search-show');
        $('.mask').fadeIn('fast');
    })

    const closeSearch = () => {
        $('.search').removeClass('search-show');
        $('.mask').fadeOut('fast');
    }
    
    $('.mask').click(() => {
        closeSearch();
    });
    
    $('.search .close').click(() => {
        closeSearch();
    })

    // Запуск функции показа кнопки
    $(window).scroll(showImage)
});

// Скрыть/показать кнопку наверх от скролла
const showImage = () => {
    scrollTop = window.scrollY
    if(scrollTop == 0 && temp) {
        $('#downBtn').show();
    } else {
        $('#downBtn').hide();
    }
    if(scrollTop >= 500) {
        $('#upBtn').show();
    }
    if(scrollTop < 500)
        $('#upBtn').hide();
}

// Нажатие кнопки наверх
$('#upBtn').click(() => {
    $('#upBtn').hide();
    $('#downBtn').show();
    tmpScroll = scrollTop;
    $(window).scrollTop(0);
    temp = true;
})

// Нажатие кнопки вниз
$('#downBtn').click(() => {
    $('#downBtn').hide();
    $('#upBtn').show();
    $(window).scrollTop(tmpScroll);
    temp = false;
})