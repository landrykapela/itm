// buttons and menus
//menus
const popupClose = document.getElementById("close-popup");
const popup = document.getElementById("popup");
const contactPopup = document.getElementById("popup2");
const popup2Close = document.getElementById("close-popup2");
if (popupClose) {
  popupClose.addEventListener("click", () => {
    popup.classList.add("hidden");
  });
}
if (popup2Close) {
  popup2Close.addEventListener("click", () => {
    contactPopup.classList.add("hidden");
  });
}
const nav = document.getElementById("navigation");
if (nav) {
  let navItems = Array.from(nav.children);

  navItems.forEach((cn) => {
    cn.addEventListener("click", (event) => {
      navItems.forEach((c) => {
        if (c.classList.contains("active")) c.classList.remove("active");
      });
      cn.classList.add("active");
      let targetViewId = "section_" + event.target.id;
      console.log(targetViewId);
      switch (targetViewId.toLowerCase()) {
        case "section_services":
          if (window.location.pathname !== "/index.html") {
            window.location = window.location.origin + "/services.html";
          } else scrollToView(targetViewId);
          break;
        case "section_contacts":
          scrollToView(targetViewId);
          break;
        case "section_about":
          window.location = window.location.origin + "/about.html";
          break;
        case "section_news":
          window.location = window.location.origin + "/events/events.php";
          break;
        case "section_jobs":
          window.location = window.location.origin + "/jobs/jobs.php";
          break;
        case "section_home":
          window.location = window.location.origin + "/index.html";
          break;
        case "section_training":
          window.location = window.location.origin + "/training/training.php";
          break;
      }
    });
    if (cn.id === "services") {
      let expandable = document.getElementById("expandable");
      cn.addEventListener("mouseover", () => {
        expandable.classList.remove("hidden");
        // cn.classList.add("accent-bg");
        // cn.classList.add("dark-text");
      });
      cn.addEventListener("mouseout", () => {
        expandable.classList.add("hidden");
        // cn.classList.remove("accent-bg");
        // cn.classList.add("dark-text");
      });
    }
  });
} else {
  console.log("no navigation");
}

const scrollToView = (targetId) => {
  let view = document.getElementById(targetId);
  if (view) {
    view.scrollIntoView({ behavior: "smooth" });
  }
};

//newsletter signup
const body = document.body;
console.log("path: ", window.location.pathname);
const hideAllSlides = (slides) => {
  slides.forEach((slide) => {
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
  setTimeout((index) => {
    hideSlide(slides, index - 1);
    showSlide(slides, index);
  }, 5000);
};
const handlePopupFeedback = () => {
  if (window.location.search) {
    let fb = decodeURI(window.location.search.split("=")[1]);
    alert(fb);
  } else {
    setTimeout(() => {
      popup.classList.remove("hidden");
    }, 10000);
  }
};
const showForm = (id) => {
  console.log("showing form..." + id);

  let login = document.getElementById("login");
  let reset = document.getElementById("p_reset");
  let signup = document.getElementById("signup");

  reset.classList.add("hidden");
  login.classList.add("hidden");
  signup.classList.add("hidden");

  const target = document.getElementById(id);
  target.classList.remove("hidden");
};
let paths = window.location.pathname.split("/");
window.addEventListener("load", (event) => {
  if (paths[paths.length - 1] == "index.html") {
    $("#slider2").slick({
      slidesToShow: 10,
      slidesToScroll: 5,
      dots: true,
      speed: 500,
      autoplay: true,
      infinite: true,
      arrows: true,
      swipe: true,
    });
    handlePopupFeedback();
  } else {
    if (paths[paths.length - 1] == "signup.html") {
      let hash = window.location.hash.toLowerCase();
      let target = hash.substr(1).split("?")[0];

      console.log("hash: ", target);
      if (target.length > 0) showForm(target);
      else showForm("signup");
    }
  }
});
window.addEventListener(
  "hashchange",
  (event) => {
    if (paths[paths.length - 1] == "signup.html") {
      let hash = window.location.hash.toLowerCase();
      let target = hash.substr(1);
      console.log("hash: ", target);
      if (target.length > 0) showForm(target);
      else showForm("signup");
    }
  },
  false
);
const logos1 = document.getElementsByClassName("can-go-right");
const logos2 = document.getElementsByClassName("can-go-left");
// const logos = logos1.concat(logos2);
if (logos1) {
  let items = Array.from(logos1);
  items.forEach((item) => {
    item.addEventListener("mouseover", (event) => {
      item.style.animationPlayState = "paused";
    });
    item.addEventListener("mouseout", () => {
      item.style.animationPlayState = "running";
    });
  });
}
if (logos2) {
  let items = Array.from(logos2);
  items.forEach((item) => {
    item.addEventListener("mouseover", (event) => {
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

window.addEventListener("scroll", (e) => {
  if (window.scrollY > 0.1 * window.innerHeight) {
    document.getElementById("floating-header").classList.add("primary-bg");
  } else
    document.getElementById("floating-header").classList.remove("primary-bg");
  if (window.scrollY > 0.75 * window.innerHeight) {
    backToTop.classList.remove("hidden");
  } else backToTop.classList.add("hidden");
});

const menuButton = document.getElementById("menu");
if (menuButton) {
  menuButton.addEventListener("click", (event) => {
    if (nav.style.display === "none") {
      nav.style.display = "flex";
      menuButton.innerHTML = '<i class="material-icons">close</i>';
    } else {
      nav.style.display = "none";
      menuButton.innerHTML = '<i class="material-icons">menu</i>';
    }
  });
}

const count = (ids) => {
  ids.forEach((id) => {
    let target = document.getElementById(id);
    let number = parseInt(target.textContent);
    // alert(number);
    let x = 0;
    setInterval(() => {
      if (x <= number) {
        target.textContent = x + "+";

        x++;
      }
    }, 20);
  });
};
const stats = document.getElementById("stats");
if (stats) {
  var bounding = stats.getBoundingClientRect();
  if (
    bounding.top >= 0 &&
    bounding.left >= 0 &&
    bounding.right <= (window.innerWidth || stats.clientWidth)
  ) {
    count(["trainings", "outsource", "recruitment", "partners"]);
  }
}

const btnAbout = document.getElementById("btn-about");
if (btnAbout) {
  btnAbout.addEventListener("click", () => {
    window.location = window.location.origin + "/about.html";
  });
}

const btnService = document.getElementById("btn-services");
if (btnService) {
  btnService.addEventListener("click", () => {
    window.location = window.location.origin + "/services.html";
  });
}

const btnJobs = document.getElementById("btn-jobs");
if (btnJobs) {
  btnJobs.addEventListener("click", () => {
    window.location = window.location.origin + "/jobs/jobs.php";
  });
}

const btnTraining = document.getElementById("btn-training");
if (btnTraining) {
  btnTraining.addEventListener("click", () => {
    window.location = window.location.origin + "/training/training.php";
  });
}

const btnHr = document.getElementById("s_hr");
const btnSales = document.getElementById("s_sales");
const btnIndustrial = document.getElementById("s_industrial");
const btnB2b = document.getElementById("s_b2b");

const buttons = [btnHr, btnSales, btnIndustrial, btnB2b];
buttons.forEach((b) => {
  if (b) {
    b.addEventListener("click", () => {
      let id = b.id;
      let target = id.split("_")[1];
      window.location = window.location.origin + "/services.html#" + target;
      // window.location.hash = target;
    });
  }
});

//subscribe on events page
const btnSubscribe = document.getElementById("btn-subscribe");
if (btnSubscribe) {
  btnSubscribe.addEventListener("click", () => {
    popup.classList.remove("hidden");
  });
}

const btnContactUs = document.getElementById("btnContactUs");
if (btnContactUs) {
  btnContactUs.addEventListener("click", () => {
    contactPopup.classList.remove("hidden");
  });
}

const btnRequestQuote1 = document.getElementById("request_quote1");
if (btnRequestQuote1) {
  btnRequestQuote1.addEventListener("click", () => {
    contactPopup.classList.remove("hidden");
  });
}

const btnRequestQuote2 = document.getElementById("request_quote2");
if (btnRequestQuote2) {
  btnRequestQuote2.addEventListener("click", () => {
    contactPopup.classList.remove("hidden");
  });
}

const btnRequestQuote3 = document.getElementById("request_quote3");
if (btnRequestQuote3) {
  btnRequestQuote3.addEventListener("click", () => {
    contactPopup.classList.remove("hidden");
  });
}

const btnRequestQuote4 = document.getElementById("request_quote4");
if (btnRequestQuote4) {
  btnRequestQuote4.addEventListener("click", () => {
    contactPopup.classList.remove("hidden");
  });
}
