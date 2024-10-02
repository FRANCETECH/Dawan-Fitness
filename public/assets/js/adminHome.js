let togg1 = document.getElementById("togg1");
let togg2 = document.getElementById("togg2");

let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");

togg1.addEventListener("click", () => {
  if(
    getComputedStyle(d1).display != "none" && 
    getComputedStyle(d1).animationPlayState != "paused"
  ){
    d1.style.animationPlayState = "paused";
    d1.style.display = "none";
  } else {
    d1.style.animationPlayState = "running";
    d1.style.display = "block";
  }
})

togg2.addEventListener("click", () => {
  if(
    getComputedStyle(d2).display != "none" && 
    getComputedStyle(d2).animationPlayState != "paused"
  ){
    d2.style.display = "none";
    d2.style.animationPlayState = "paused";
  } else {
    d2.style.display = "block";
    d2.style.animationPlayState = "running";
  }
})