import Dropzone from "dropzone";
import 'preline'

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: '.png,.jpg,.jpeg,.gif',
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    // en caso de que falte valores de los input y al enviar no se borre la imagen cargada
    init: function() {
        const inputImagen = document.querySelector('[name="imagen"]').value.trim();
        const inputImagenValor = document.querySelector('[name="imagen"]').value;

        if(inputImagen) {
            const imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name = inputImagenValor;

            this.options.addedfile.call( this, imagenPublicada);

            this.options.thumbnail.call( 
                this, imagenPublicada, 
                `/uploads/${imagenPublicada.name}`
            );

            imagenPublicada.previewElement.classList.add(
                'dz-success',
                'dz-complete'
            );
        }
    }
})

dropzone.on('success', function (file, response) {
    // console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
})

dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value = '';
});