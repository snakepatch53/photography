const fetch_query = (formData, entity, operation) => {
    return fetch(`${$proyect.url}model/script/${entity}/${operation}.php`, {
        method: "POST",
        headers: new Headers().append("Accept", "application/json"),
        body: formData,
    })
        .then((res) => res.json())
        .then((res) => res);
};

function fetch_ajax(formData, entity, operation, onprogress) {
    return new Promise(function (resolve, reject) {
        const ajax = new XMLHttpRequest();
        ajax.open("POST", `${$proyect.url}model/script/${entity}/${operation}.php`);
        ajax.upload.onprogress = function (event) {
            const percent = Math.round((event.loaded / event.total) * 100);
            onprogress(event, percent);
        };
        ajax.onload = () => {
            if (ajax.status >= 200 && ajax.status < 300) {
                resolve(JSON.parse(ajax.response));
            } else {
                reject({
                    status: ajax.status,
                    statusText: ajax.statusText,
                });
            }
        };
        ajax.onerror = function () {
            reject({
                status: ajax.status,
                statusText: ajax.statusText,
            });
        };
        ajax.send(formData);
    });
}
