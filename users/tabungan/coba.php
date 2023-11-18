<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Knobs</title>
    <!-- Sertakan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Sertakan jQuery Knob -->
    <script src="https://cdn.jsdelivr.net/jquery.knob/1.2.13/jquery.knob.min.js"></script>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan Anda */
        .knob {
            display: inline-block;
        }
    </style>
</head>
<body>

<!-- Tambahkan elemen knob -->
<input class="knob animated" value="0" rel="60" readonly>
<input class="knob animated" value="0" rel="70">
<input class="knob animated" value="0" rel="90">

<script>
    // Tunggu hingga dokumen selesai dimuat
    $(document).ready(function () {
        // Iterasi melalui setiap elemen dengan kelas 'knob'
        $('.knob').each(function () {
            var $this = $(this);
            var myVal = $this.attr("rel");
            
            // Inisialisasi knob
            $this.knob();

            // Animasi knob
            $({ value: 0 }).animate({
                value: myVal
            }, {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    $this.val(Math.ceil(this.value)).trigger('change');
                }
            });
        });
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Custom Knob</title>
  <style>
    .knob-container {
      position: relative;
      width: 60px;
      height: 60px;
    }

    .knob {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background-color: #eee;
      text-align: center;
      line-height: 60px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="knob-container">
  <div  id="customKnob" data-value="<?= number_format($hitung_persen, 0, '', '') ?>">0%</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var knobElement = document.getElementById('customKnob');
    var knobValue = knobElement.getAttribute('data-value');
    var duration = 2000; // Animation duration in milliseconds
    var startValue = 0;

    function updateKnob() {
      var currentTime = Date.now();
      var deltaTime = currentTime - startTime;
      var progress = Math.min(1, deltaTime / duration);
      var animatedValue = Math.ceil(startValue + progress * (knobValue - startValue));
      knobElement.textContent = animatedValue + '%';

      if (progress < 1) {
        requestAnimationFrame(updateKnob);
      }
    }

    function animateKnob() {
      startTime = Date.now();
      requestAnimationFrame(updateKnob);
    }

    animateKnob();
  });
</script>

</body>
</html>
