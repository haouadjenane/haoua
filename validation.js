window.onload = function () {
  const params = new URLSearchParams(window.location.search);
  const image = params.get("image");
  const price = params.get("price");
  const reference = params.get("reference");

  if (image) {
    document.getElementById("product-img").src = image;
    document.getElementById("product-image-hidden").value = image; // ✅ نرسل الصورة إلى PHP
  }

  if (price) {
    document.getElementById("product-price").value = price;
  }

  if (reference) {
    const refInputs = document.getElementsByName("reference");
    if (refInputs.length > 0) {
      refInputs[0].value = reference;
    }
  }
};

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("commande-form").addEventListener("submit", function (e) {
    const colorSelected = [...document.getElementsByName("color")].some(c => c.checked);
    if (!colorSelected) {
      alert("Please choose a Color.");
      e.preventDefault();
    }
  });
});