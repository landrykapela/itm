// buttons and menus
//menus
const popupClose = document.getElementById("close-popup");
const popup = document.getElementById("popup");
if (popupClose) {
  popupClose.addEventListener("click", () => {
    popup.classList.add("hidden");
  });
}

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
      switch (targetViewId.toLowerCase()) {
        case "section_services":
        case "section_contacts":
          scrollToView(targetViewId);
          break;
        case "section_about":
          window.location.pathname = "/about.html";
          break;
        case "section_events":
          window.location.pathname = "/events.html";
          break;
        case "section_jobs":
          window.location.pathname = "/jobs.html";
          break;
        case "section_home":
          window.location.pathname = "/index.html";
          break;
        case "section_training":
          window.location = "https://registration.itmafrica.co.tz";
          break;
      }
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
    $("#slider").slick({
      dots: true,
      speed: 500,
      autoplay: true,
      infinite: true,
      arrows: true,
      swipe: true
    });

    setTimeout(() => {
      popup.classList.remove("hidden");
    }, 10000);
  });
}

const logos1 = document.getElementsByClassName("can-go-right");
const logos2 = document.getElementsByClassName("can-go-left");
// const logos = logos1.concat(logos2);
if (logos1) {
  let items = Array.from(logos1);
  items.forEach(item => {
    item.addEventListener("mouseover", event => {
      item.style.animationPlayState = "paused";
    });
    item.addEventListener("mouseout", () => {
      item.style.animationPlayState = "running";
    });
  });
}
if (logos2) {
  let items = Array.from(logos2);
  items.forEach(item => {
    item.addEventListener("mouseover", event => {
      item.style.animationPlayState = "paused";
    });
    item.addEventListener("mouseout", () => {
      item.style.animationPlayState = "running";
    });
  });
}

const backToTop = document.getElementById("scroll_top");
if (backToTop) {
  backToTop.addEventListener("click", () => {
    scrollToView("navigation");
  });
}

window.addEventListener("scroll", e => {
  if (window.scrollY > 0.75 * window.innerHeight) {
    backToTop.classList.remove("hidden");
  } else backToTop.classList.add("hidden");
});
