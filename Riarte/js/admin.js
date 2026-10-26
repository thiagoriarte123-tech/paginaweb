// ============================================
// PANEL — vista previa de la foto antes de guardar
// ============================================
const inputFoto = document.getElementById("foto");
const vistaPrevia = document.getElementById("vista-previa");

if (inputFoto && vistaPrevia) {
    inputFoto.addEventListener("change", () => {
        const archivo = inputFoto.files[0];
        if (archivo) {
            vistaPrevia.src = URL.createObjectURL(archivo);
        }
    });
}
