const swiper = new Swiper(".mySwiper", {

slidesPerView: 5,
spaceBetween: 20,
loop: true,

autoplay:{
delay:3000
},

navigation:{
nextEl: ".swiper-button-next",
prevEl: ".swiper-button-prev",
},

breakpoints:{

320:{
slidesPerView:1
},

600:{
slidesPerView:2
},

900:{
slidesPerView:3
},

1200:{
slidesPerView:5
}

}

});