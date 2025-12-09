document.addEventListener("DOMContentLoaded", function () {
    
    const imageSelection = document.getElementById("imageSelection");
    const preview = document.getElementById("preview");

    imageSelection.addEventListener("change", function (event) {
        const image = this.files[0];
        if (image) {
            preview.src = URL.createObjectURL(image);
            preview.style.display = "block";
        } else {
            preview.style.display = "none";
            preview.src = "";
        }
    });
});
