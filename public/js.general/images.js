const compressImg = (imagenComoArchivo, porcentajeCalidad) => {
    return new Promise((resolve, reject) => {
        const $canvas = document.createElement("canvas");
        const imagen = new Image();
        imagen.onload = () => {
            $canvas.width = imagen.width;
            $canvas.height = imagen.height;
            $canvas.getContext("2d").drawImage(imagen, 0, 0);
            $canvas.toBlob(
                (blob) => {
                    if (blob === null) {
                        return reject(blob);
                    } else {
                        const src = URL.createObjectURL(blob);
                        const result = { blob, src };
                        resolve(result);
                    }
                },
                "image/jpeg",
                porcentajeCalidad / 100
            );
        };
        imagen.src = URL.createObjectURL(imagenComoArchivo);
    });
};

async function createFile(url) {
    let response = await fetch(url);
    let data = await response.blob();
    let metadata = {
        type: "image/jpeg",
    };
    let file = new File([data], "test.jpg", metadata);
    return { data, file };
}
