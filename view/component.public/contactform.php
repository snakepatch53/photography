<form class="needs-validation" novalidate onsubmit="return false">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="validationServer01" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="validationServer01" placeholder="Mark" name="client_name" required>
            <div class="invalid-feedback">
                Escribe tu nombre!
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationServer02" class="form-label">Celular <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="validationServer02" placeholder="Celular" name="client_phone" required>
            <div class="invalid-feedback">
                Escribe tu numero de celular!
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationServer04" class="form-label">Correo Electronico <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="validationServer04" placeholder="Email" name="client_mail" required>
            <div class="invalid-feedback">
                Escribe tu email!
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationServer03" class="form-label">Facebook</label>
            <input type="text" class="form-control" id="validationServer03" placeholder="Url" name="client_fb">
        </div>
        <div class="col-md-12">
            <label for="validationServer05" class="form-label">Descripcion</label>
            <textarea name="client_descr" class="form-control" id="validationServer05" rows="3"></textarea>
        </div>
        <div class="col-md-12">
            <p class="text-info msg-feetback"></p>
        </div>
        <div class="col-md-12 text-center">
            <button class="btn btn-primary px-5 py-2" name="btnSubmit">
                <span>Enviar</span>
                <i class="fa-sharp fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</form>