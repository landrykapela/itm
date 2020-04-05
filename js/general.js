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
          window.location = window.location.origin + "/events.html";
          break;
        case "section_jobs":
          window.location = window.location.origin + "/jobs.html";
          break;
        case "section_home":
          window.location = window.location.origin + "/index.html";
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
  // switch (id.toLowerCase) {
  //   case "signup":
  //     console.log("hiding... reset and login");
  //     login.classList.add("hidden");
  //     reset.classList.add("hidden");
  //     break;
  //   case "login":
  //     console.log("hiding... reset and signup");
  //     reset.classList.add("hidden");
  //     signup.classList.add("hidden");
  //     break;
  //   case "p_reset":
  //     console.log("hiding... login and signup");
  //     login.classList.add("hidden");
  //     signup.classList.add("hidden");
  //     break;
  //   // default:
  //   //   console.log("hiding... default");
  //   //   reset.classList.add("hidden");
  //   //   login.classList.add("hidden");
  //   //   signup.classList.remove("hidden");
  // }
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

    setTimeout(() => {
      popup.classList.remove("hidden");
    }, 10000);
  } else {
    if (paths[paths.length - 1] == "signup.html") {
      let hash = window.location.hash.toLowerCase();
      let target = hash.substr(1);
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
  if (window.scrollY > 0.75 * window.innerHeight) {
    backToTop.classList.remove("hidden");
  } else backToTop.classList.add("hidden");
});

let btnSubmit = document.getElementById("btnSubmitPopup");
if (btnSubmit) {
  btnSubmit.addEventListener("click", (event) => {
    let email = document.getElementById("email").value;
    let name = document.getElementById("name").value;
    let data = { email: email, name: name };
    fetch("https://registration.itmafrica.co.tz/admin/verify/index.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((response) => {
        alert(response.message);
        popup.classList.add("hidden");
      })
      .catch((error) => {
        popup.classList.add("hidden");
      });
  });
}
const menuButton = document.getElementById("menu");
if (menuButton) {
  menuButton.addEventListener("click", (event) => {
    if (nav.style.display === "none") nav.style.display = "flex";
    else nav.style.display = "none";
  });
}

const count = (id) => {
  target = document.getElementById(id);
  let number = parseInt(target.textContent);
  // alert(number);
  let x = 0;
  setInterval(() => {
    if (x <= number) {
      target.textContent = x + "+";

      x++;
    }
  }, 20);
};
const stats = document.getElementById("stats");
if (stats) {
  var bounding = stats.getBoundingClientRect();
  if (
    bounding.top >= 0 &&
    bounding.left >= 0 &&
    bounding.right <= (window.innerWidth || stats.clientWidth)
  ) {
    // count("outsource");
    count("recruitment");
    // count("training");
    // count("partners");
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
    window.location = window.location.origin + "/jobs.html";
  });
}

const btnTraining = document.getElementById("btn-training");
if (btnTraining) {
  btnTraining.addEventListener("click", () => {
    window.location = "https://registration.itmafrica.co.tz";
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
