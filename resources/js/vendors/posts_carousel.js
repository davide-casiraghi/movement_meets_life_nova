/**
 * Blog posts carousel in the homepage (resources/views/partials/pages/home/blog_carousel.blade.php).
 * Three posts visible, scrolled with the left and right arrows.
 */
import 'slick-carousel';

jQuery('.postsCarousel').not('.slick-initialized').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    infinite: true,
    responsive: [
        { breakpoint: 1024, settings: { slidesToShow: 2 } },
        { breakpoint: 640, settings: { slidesToShow: 1 } },
    ],
});
