/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/options.js ***!
  \*********************************/
$(document).ready(function () {
  // alert("Внимание! Данный сайт исключительно демонстрационный: здесь вы можете выбрать товары, добавить их в корзину, зарегистрироваться. Однако, кнопка покупки товаров не приведет к непосредстенной оплате. Все товары вымешлены, совпадения случайны.")

  // Сообщение успех
  if ($('.mess_success')) {
    setTimeout(function () {
      $('.mess_success').slideUp();
    }, 2000);
  }
});
/******/ })()
;