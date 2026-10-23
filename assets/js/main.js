$(function () {

  // Menu mobile
  $('.nav-toggle').on('click', function () {
    const open = $('.nav-links').toggleClass('open').hasClass('open');
    $(this).attr('aria-expanded', open);
  });
  $('.nav-links a').on('click', () => $('.nav-links').removeClass('open'));

  // Slider antes/depois
  $('[data-ba]').each(function () {
    const $ba = $(this), $before = $ba.find('.ba-before'), $handle = $ba.find('.ba-handle');
    let dragging = false;

    function setPos(pct) {
      pct = Math.max(0, Math.min(100, pct));
      $before.css('clip-path', `inset(0 ${100 - pct}% 0 0)`);
      $handle.css('left', pct + '%').attr('aria-valuenow', Math.round(pct));
    }
    function move(e) {
      const x = (e.originalEvent.touches ? e.originalEvent.touches[0] : e).clientX;
      const r = $ba[0].getBoundingClientRect();
      setPos(((x - r.left) / r.width) * 100);
    }
    $ba.on('mousedown touchstart', e => { dragging = true; move(e); });
    $(window).on('mouseup touchend', () => dragging = false)
             .on('mousemove touchmove', e => { if (dragging) move(e); });
    $handle.on('keydown', e => {
      const v = +$handle.attr('aria-valuenow');
      if (e.key === 'ArrowLeft') setPos(v - 5);
      if (e.key === 'ArrowRight') setPos(v + 5);
    });
  });

  // Clique num serviço em destaque já preenche o formulário
  $('.feat').on('click', function () {
    $('#booking-form [name=service]').val($(this).data('service'));
  });

  // Data mínima = hoje; salão fecha segunda e domingo
  const today = new Date().toISOString().split('T')[0];
  $('#booking-form [name=date]').attr('min', today).on('change', function () {
    const day = new Date(this.value + 'T00:00').getDay();
    if (day === 0 || day === 1) {
      $(this).val('');
      showMsg('We are open Tuesday to Saturday. Please choose another date.', false);
    }
  });

  // Envio do agendamento
  const $form = $('#booking-form'), $msg = $form.find('.form-msg');
  function showMsg(text, ok) { $msg.text(text).toggleClass('ok', ok).toggleClass('err', !ok); }

  $form.on('submit', function (e) {
    e.preventDefault();
    let valid = true;
    $form.find('[required]').each(function () {
      const bad = !this.value.trim();
      $(this).toggleClass('error', bad);
      if (bad) valid = false;
    });
    if (!valid) return showMsg('Please fill in the highlighted fields.', false);

    const $btn = $form.find('button').prop('disabled', true);
    $.post('api/booking.php', $form.serialize(), null, 'json')
      .done(res => { showMsg(res.message, true); $form[0].reset(); })
      .fail(xhr => showMsg((xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong. Please try again.', false))
      .always(() => $btn.prop('disabled', false));
  });
});
