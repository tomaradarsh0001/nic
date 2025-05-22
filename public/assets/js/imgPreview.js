// Minified by Diwakar Sinha at 01-01-2025
// let coapplicantIndex=0;function setupFileInputListeners(){document.querySelectorAll('input[type="file"][name^="coapplicant"], input[type="file"][name^="convcoapplicant"]').forEach((e=>{e.addEventListener("change",(function(e){console.log(e);const t=e.target.files[0],n=(e.target.id.split("_")[1],e.target.parentElement.nextElementSibling.querySelector(".preview_img_hidden")),l=e.target.parentElement.nextElementSibling.querySelector(".preview");if(t){const e=new FileReader;e.onload=function(e){const t=e.target.result;n.value=t,l.src=t,l.style.display="block"},e.readAsDataURL(t)}}))}))}setupFileInputListeners(),document.querySelectorAll(".repeater-add-btn").forEach((e=>{e.addEventListener("click",setupFileInputListeners)})); commented by anil on 11-02-2025
let coapplicantIndex = 0;
function setupFileInputListeners() {
  document
    .querySelectorAll(
      'input[type="file"][name^="coapplicant"][id$="_photo"], input[type="file"][name^="convcoapplicant"][id$="_photo"], input[type="file"][name^="noccoapplicant"][id$="_photo"]'
    )
    .forEach((e) => {
      e.addEventListener("change", function (e) {
        const t = e.target.files[0],
          n = e.target.parentElement.nextElementSibling.querySelector(
            ".preview_img_hidden"
          ),
          l =
            e.target.parentElement.nextElementSibling.querySelector(".preview");
        if (t) {
          const e = new FileReader();
          (e.onload = function (e) {
            const t = e.target.result;
            (n.value = t), (l.src = t), (l.style.display = "block");
          }),
            e.readAsDataURL(t);
        } else (n.value = ""), (l.src = ""), (l.style.display = "none");
      });
    });
}
setupFileInputListeners(),
  document.querySelectorAll(".repeater-add-btn").forEach((e) => {
    e.addEventListener("click", setupFileInputListeners);
  });
