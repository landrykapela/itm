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
if (window.location.pathname == "/index.html") {
  window.addEventListener("load", event => {
    let header = document.getElementById("header");
    let bg = "bg-img-header";
    let index = 1;
    setInterval(() => {
      if (index > 4) index = 1;
      let currentBg = bg + index;
      let nextBg = bg + (index + 1);
      if (index == 4) nextBg = bg + 1;
      console.log("bg: ", currentBg, nextBg);
      header.classList.add(nextBg);
      header.classList.remove(currentBg);

      index++;
    }, 5000);

    let slider = document.getElementById("slider");
    let children = Array.from(slider.children);
    console.log("children: ", children);
    let k = 0;

    // children[k].classList.add("can-slide");
    setInterval(() => {
      if (k > 2) {
        children[2].classList.add("hidden");
        children[2].classList.remove("can-slide");
        k = 0;
        children[k].classList.remove("hidden");
        children[k].classList.add("can-slide");
      } else {
        children[k].classList.add("hidden");
        children[k].classList.remove("can-slide");

        if (k == 2) {
          children[0].classList.remove("hidden");
          children[0].classList.add("can-slide");
          k = 0;
        } else {
          k++;
          children[k].classList.remove("hidden");
          children[k].classList.add("can-slide");
        }
      }
    }, 5000);
  });
}
let testBut = document.getElementById("test");
let target = document.getElementById("testImg");
if (testBut) {
  testBut.addEventListener("click", event => {
    console.log("testing...");
    event.preventDefault();
    target.classList.add("can-go-right");
  });
}
