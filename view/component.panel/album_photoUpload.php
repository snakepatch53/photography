<div class="modal fade" id="element-modalPhotoUpload" tabindex="-1" aria-labelledby="element-modalPhotoUploadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="element-modalPhotoUploadLabel">Subir fotos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="modal-body" id="element-formPhotos" onsubmit="return false" enctype="multipart/form-data">
                <input type="hidden" name="album_id" value="">
                <!-- dropArea | ini -->
                <div class=" container modalPhotoBody">
                    <p class="fw-bold drag-n">Arrastra y suelta fotos</p>
                    <p class="fw-bold drag-y">Suelta para subir los archivos</p>
                    <span class="fw-bold">O</span>
                    <button class="btn btn-outline-primary" name="btn_photos">Selecciona tus fotos</button>
                    <input type="file" name="btn_filePhotos" hidden multiple>
                </div>
                <div class="container photos-preview" id="element-photos-preview"></div>
                <!-- dropArea | end -->
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="submit" class="btn btn-primary">Subir</button> -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="element-modalViewPhoto" tabindex="-1" aria-labelledby="element-modalViewPhotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="element-modalViewPhotoLabel">Fotos del album</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- dropArea | ini -->
                <div class="container">
                    <div class="row g-2" id="element-photo-view-container"></div>
                </div>
                <!-- dropArea | end -->
            </div>
            <div class="modal-footer">
                <!-- Hacer links y direccionar al script download -->
                <button type="submit" class="btn btn-primary" onclick="viewPhoto_uiFunction.download(1)">
                    <i class="fa-solid fa-download"></i>
                    <span>Descargar seleccion</span>
                </button>
                <button type="submit" class="btn btn-success" onclick="viewPhoto_uiFunction.download(0)">
                    <i class="fa-solid fa-download"></i>
                    <span>Descargar album</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Cerrar</span>
                </button>
            </div>
        </div>
    </div>
</div>