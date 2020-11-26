// Récupère le modal
var modal = document.getElementById("myModal");

// Récupère l'élément <span> qui ferme le modal
var span = document.getElementsByClassName("close")[0];

// Lorsque je clique sur <span> (x), je ferme le modal
span.onclick = function() {
    modal.style.display = "none";
}
// Lorsque je clique n'importe où en dehors du modal, je le ferme
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}