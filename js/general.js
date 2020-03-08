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
const body = document.getElementsByTagName("body")[0];
if (body) {
  body.addEventListener("load", event => {
    let popup = document.getElementById("popup");
    popup.classList.remove("hidden");
  });
} else console.log("no body");
