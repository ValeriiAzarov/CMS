function loadLogo() {
  var element = document.getElementById("anim");
  var from = -50; // начальная координата X.
  var to = 0; // конечная координата X.
  var duration = 2000; // длительность - 2 секунда.
  var start = new Date().getTime(); // время старта.
  function delta(progress) {
    for (let a = 0, b = 1, result; 1; a += b, b /= 2) {
      if (progress >= (7 - 4 * a) / 11) {
        return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2)
      }
    }
  }
  setTimeout(function() {
    var now = (new Date().getTime()) - start; // текущее время.
    var progress = now / duration; // прогресс анимации.
    if (progress > 1) {    
      progress = 1;
    }
    var result = (to - from) * delta(progress) + from;
    element.style.top = result + "px";
    if (progress < 1) { // если анимация не закончилась, продолжаем.
      setTimeout(arguments.callee, 10);
    }
  }, 10);
}  