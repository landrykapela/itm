// buttons and menus
//menus

const nav = document.getElementById("navigation");
if (nav) {
  let navItems = Array.from(nav.children);
  navItems.forEach(cn => {
    cn.addEventListener("click", event => {
      navItems.forEach(c => {
        if (c.classList.contains("active")) c.classList.remove("active");
      });
      cn.classList.add("active");
      let targetViewId = "section_" + event.target.id;
      console.log(targetViewId);
      scrollToView(targetViewId);
    });
  });
} else {
  console.log("no navigation");
}

const scrollToView = targetId => {
  let view = document.getElementById(targetId);
  if (view) {
    view.scrollIntoView({ behavior: "smooth" });
  }
};

//newsletter signup
const body = document.body;
console.log("path: ", window.location.pathname);
const hideAllSlides = slides => {
  slides.forEach(slide => {
    slide.classList.add("hidden");
    slide.classList.remove("can-slide");
  });
};
const hideSlide = (slides, index) => {
  if (index > slides.length - 1) {
    hideAllSlides(slides);
  } else {
    slides[index].classList.add("hidden");
    slides[index].classList.remove("can-slide");
  }
};
const showSlide = (slides, index) => {
  if (index > slides.length - 1 || index == -1) {
    slides[0].classList.remove("hidden");
    slides[0].classList.add("can-slide");
  } else {
    slides[index].classList.remove("hidden");
    slides[index].classList.add("can-slide");
  }
  // setTimeout(() => {
  //   console.log("dismissing...", index);
  //   slides[index].classList.add("hidden");
  //   slides[index].classList.remove("can-slide");

  //   if (index < 2) {
  //     console.log("showing...", index + 1);
  //     slides[index + 1].classList.remove("hidden");
  //     slides[index + 1].classList.add("can-slide");
  //   } else {
  //     console.log("showing...initial");
  //     slides[0].classList.remove("hidden");
  //     slides[0].classList.add("can-slide");
  //   }
  // }, 5000);
};
const slideShow = (slides, index) => {
  setTimeout(index => {
    hideSlide(slides, index - 1);
    showSlide(slides, index);
  }, 5000);
};
if (
  window.location.pathname == "/index.html" ||
  window.location.pathname == "/"
) {
  window.addEventListener("load", event => {
    $("#fader").slick({
      dots: true,
      speed: 500,
      autoplay: true,
      infinite: true,
      arrows: true,
      swipe: true,
      fade: true
    });

    $("#slider").slick({
      dots: true,
      speed: 500,
      autoplay: true,
      infinite: true,
      arrows: true,
      swipe: true
    });
  });
}
