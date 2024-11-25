@props(['startAtEnd'])
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<div {{ $attributes->merge(['class' => 'swiper progress-slide-carousel swiper-container relative space-y-4']) }}
    data-start-at-end="{{ $startAtEnd ?? false }}">
    <div class="flex w-full gap-4 justify-end text-lg">
        <i class="fa-solid fa-pause" id="pauseCarousel" role="button" onclick="pauseCarousel()"></i>
        <i class="fa-solid fa-play hidden" id="playCarousel" role="button" onclick="continueCarousel()"></i>
        <i class="fa-solid fa-rotate" role="button" onclick="restartCarousel()"></i>
    </div>
    <div class="swiper-wrapper">
        {{ $slot }}
    </div>
    <div class="swiper-pagination !bottom-2 !top-auto !w-80 right-0 mx-auto bg-gray-100"></div>
</div>
<script>
    var swiper = new Swiper(".progress-slide-carousel", {
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".progress-slide-carousel .swiper-pagination",
            type: "progressbar",
        },
        loop: true, // Loops the carousel indefinitely
        allowTouchMove: false, // Deshabilita los gestos táctiles
        simulateTouch: false,
        on: {
            slideChange: function() {
                // Detener el autoplay cuando llegue a la última diapositiva
                if (this.isEnd) {
                    this.autoplay.stop();
                }
            },
        },
    });

    // Configurar si debe empezar en la última diapositiva
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.querySelector(".progress-slide-carousel");
        const startAtEnd = carousel.getAttribute("data-start-at-end") === "1";

        if (startAtEnd) {
            swiper.slideTo(swiper.slides.length - 1); // Mover al último slide
            swiper.autoplay.stop(); // Detener autoplay
        }
    });

    function pauseCarousel() {
        swiper.autoplay.pause();
        document.getElementById('pauseCarousel').classList.toggle('hidden');
        document.getElementById('playCarousel').classList.toggle('hidden');
    }

    function continueCarousel() {
        swiper.autoplay.start();
        document.getElementById('pauseCarousel').classList.toggle('hidden');
        document.getElementById('playCarousel').classList.toggle('hidden');

    }

    function restartCarousel() {
        // Detiene el autoplay si está en curso
        swiper.autoplay.stop();

        // Reinicia el carrusel a la primera diapositiva
        swiper.slideTo(0);

        // Reactiva el autoplay
        swiper.autoplay.start();
    }
</script>
