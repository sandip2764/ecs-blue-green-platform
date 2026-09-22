document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const suggestions = ['cleaning', 'painting', 'haircut', 'plumbing', 'carpentry', 'electrician'];
    let currentIndex = 0;

    function updatePlaceholder() {
        searchInput.classList.add('animated');
        setTimeout(() => {
            searchInput.placeholder = `Search for ❛ ${suggestions[currentIndex]} ❜`;
            currentIndex = (currentIndex + 1) % suggestions.length;
        }, 800);
    }

    searchInput.placeholder = `Search for ❛ ${suggestions[currentIndex]} ❜`;
    currentIndex++;
    updatePlaceholder();
    setInterval(updatePlaceholder, 4000);
});




let currentIndex = 0;
const slides = document.querySelectorAll('.carousel-item');
const totalSlides = slides.length;

function showSlide(index) {
    if (index >= totalSlides) currentIndex = 0;
    else if (index < 0) currentIndex = totalSlides - 1;
    else currentIndex = index;

    document.querySelector('.carousel-inner').style.transform = `translateX(-${currentIndex * 100}%)`;
}

let autoSlide = setInterval(() => {
    showSlide(currentIndex + 1);
}, 3000);

document.querySelector('.prev').addEventListener('click', () => {
    clearInterval(autoSlide);
    showSlide(currentIndex - 1);
    autoSlide = setInterval(() => {
        showSlide(currentIndex + 1);
    }, 3000);
});

document.querySelector('.next').addEventListener('click', () => {
    clearInterval(autoSlide);
    showSlide(currentIndex + 1);
    autoSlide = setInterval(() => {
        showSlide(currentIndex + 1);
    }, 3000);
});




const sliders = document.querySelectorAll('.slider');
sliders.forEach(slider => {
    const leftArrow = slider.parentElement.querySelector('.arrow.left');
    const rightArrow = slider.parentElement.querySelector('.arrow.right');

    function updateArrows() {
        const scrollLeft = slider.scrollLeft;
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        leftArrow.style.display = scrollLeft > 0 ? 'block' : 'none';
        rightArrow.style.display = scrollLeft < maxScroll ? 'block' : 'none';
    }

    function scrollSlider(direction) {
        const slideWidth = slider.querySelector('.slide').offsetWidth + 20;
        const scrollAmount = direction === 'left' ? -slideWidth : slideWidth;
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }

    slider.addEventListener('scroll', updateArrows);
    updateArrows();
    window.addEventListener('resize', updateArrows);

    leftArrow.addEventListener('click', () => scrollSlider('left'));
    rightArrow.addEventListener('click', () => scrollSlider('right'));
});