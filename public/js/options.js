/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/options.js ***!
  \*********************************/
$(document).ready(function () {
  // alert("Внимание! Данный сайт исключительно демонстрационный: здесь вы можете выбрать товары, оставить отзывы, добавить их в корзину, зарегистрироваться и произвести иммитацию оплаты. Однако, кнопка покупки товаров не приведет к непосредстенной оплате. Все товары вымешлены, совпадения случайны.")

  // Сообщение успех
  if ($('.mess_success')) {
    setTimeout(function () {
      $('.mess_success').slideUp();
    }, 2000);
  }

  // Форма поиска
  $('header input').on('focus', function () {
    $('.search').addClass('search-show');
    $('.mask').fadeIn('fast');
    $('header input').blur();
    $('.search form input').focus();
  });
  var closeSearch = function closeSearch() {
    $('.search').removeClass('search-show');
    $('.mask').fadeOut('fast');
    $('.search form input').blur();
  };
  $('.mask').click(function () {
    closeSearch();
  });
  $('.search .close').click(function () {
    closeSearch();
  });

  // Запуск функции показа кнопки наверх
  if ($(window).width() > 1024) {
    $(window).scroll(showImage);
  }
});

// Скрыть/показать кнопку наверх от скролла
var temp = false;
var showImage = function showImage() {
  scrollTop = window.scrollY;
  if (scrollTop == 0 && temp) {
    $('#downBtn').show();
  } else {
    $('#downBtn').hide();
  }
  if (scrollTop >= 500) {
    $('#upBtn').show();
  }
  if (scrollTop < 500) $('#upBtn').hide();
};

// Нажатие кнопки наверх
$('#upBtn').click(function () {
  $('#upBtn').hide();
  $('#downBtn').show();
  tmpScroll = scrollTop;
  $(window).scrollTop(0);
  temp = true;
});

// Нажатие кнопки вниз
$('#downBtn').click(function () {
  $('#downBtn').hide();
  $('#upBtn').show();
  $(window).scrollTop(tmpScroll);
  temp = false;
});
/******/ })()
;