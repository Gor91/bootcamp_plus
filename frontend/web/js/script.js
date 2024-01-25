$(document).ready(function () {
    $(".banner__nav__link, .header__link").click(function (event) {
        event.preventDefault();
        $("html, body").animate({scrollTop: $($(this).attr("href")).offset().top}, 500);
    });

    // var owl = $('.owl-carousel');
    // $('.agenda__cont').owlCarousel({
    //     loop: false,
    //     margin: 25,
    //     nav: false,
    //     slideSpeed: 1000,
    //     paginationSpeed: 1000,
    //     singleItem: true,
    //     navigation: true,
    //     stagePadding: 20,
    //     scrollPerPage: true,
    //     startPosition: 300,
    //     autoplay: true,
    //
    //     responsive: {
    //         0: {
    //             items: 1
    //         },
    //         560: {
    //             items: 1
    //         },
    //         650: {
    //             items: 2
    //         },
    //         1000: {
    //             items: 3
    //         },
    //         1200: {
    //             items: 4
    //         }
    //     }
    // });
    owl.on('mousewheel', '.owl-stage', function (e) {
        if (e.deltaY > 0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    });

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        var bannerHegiht = $('.banner').height();
        //>=, not <=
        if (scroll >= bannerHegiht) {
            //clearHeader, not clearheader - caps H
            $(".header").addClass("header__show");
        } else {
            $(".header").removeClass("header__show");
        }
    });

    $('.sign__up__input').on('input',function(){
        if($(this).val() != '') {
            $(this).addClass('sign__up__input__vall');
        } else {
            $(this).removeClass('sign__up__input__vall');
        }
    });

    $(document).on("scroll", onScroll);

    //smoothscroll
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");

        $('a').each(function () {
            $(this).removeClass('active');
        })
        $(this).addClass('active');

        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top+2
        }, 500, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
});

function onScroll(event){
    var scrollPos = $(document).scrollTop();
    $('.navbar-nav a').each(function () {
        let currLink = $(this);
        let refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('.header__list a').removeClass("active");
            currLink.addClass("active");
        }
        else{
            currLink.removeClass("active");
        }
    });

    $('.banner__nav__block a').each(function () {
        let currLink = $(this);
        let refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('.banner__nav__block a').removeClass("active");
            currLink.addClass("active");
        }
        else{
            currLink.removeClass("active");
        }
    });
}
$('.agenda__cont_slider').owlCarousel({
    loop:true,
    margin:20,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});