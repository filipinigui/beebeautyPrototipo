$(function () {
  const $toast = $('.toast');
  let timer;

  // Enquanto não há banco, os botões só avisam. Depois, trocar por chamadas $.post às rotas de /admin/api/.
  $(document).on('click', '[data-demo]', function () {
    clearTimeout(timer);
    $toast.text('Modo demonstração: esta ação será ligada ao banco de dados depois.').addClass('show');
    timer = setTimeout(() => $toast.removeClass('show'), 2800);
  });
});
