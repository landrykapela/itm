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
    let details = Array.from(document.getElementById("section_home").children);
    let bg = "bg-img-header";
    let index = 1;
    let k = 0;
    setInterval(() => {
      if (index > 4) index = 1;
      k;
      let currentBg = bg + index;
      let nextBg = bg + (index + 1);

      if (index == 4) {
        nextBg = bg + 1;
      }

      header.classList.add(nextBg);
      header.classList.remove(currentBg);

      index++;

      if (k > 3) {
        details[3].classList.remove("can-fade");
        details[3].classList.add("hidden");
        k = 0;
        details[k].classList.remove("hidden");
        details[k].classList.add("can-fade");
      } else {
        details[k].classList.remove("can-fade");
        details[k].classList.add("hidden");
        if (k == 3) {
          details[0].classList.add("can-fade");
          details[0].classList.remove("hidden");
          k = 0;
        } else {
          k++;
          details[k].classList.add("can-fade");
          details[k].classList.remove("hidden");
        }
      }
    }, 5000);

    let slider = document.getElementById("slider");
    let children = Array.from(slider.children);
    console.log("children: ", children);
    let j = 0;

    // children[k].classList.add("can-slide");
    setInterval(() => {
      if (j > 2) {
        children[2].classList.add("hidden");
        children[2].classList.remove("can-slide");
        k = 0;
        children[j].classList.remove("hidden");
        children[j].classList.add("can-slide");
      } else {
        children[j].classList.add("hidden");
        children[j].classList.remove("can-slide");

        if (j == 2) {
          children[0].classList.remove("hidden");
          children[0].classList.add("can-slide");
          j = 0;
        } else {
          j++;
          children[j].classList.remove("hidden");
          children[j].classList.add("can-slide");
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
