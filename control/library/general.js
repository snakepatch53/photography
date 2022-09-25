function ObjectToFormdata(object) {
    var formData = new FormData();
    for (let key in object) {
        formData.append(key, object[key]);
    }
    return formData;
}

function setValuesForm(values, $form) {
    for (let key in values) {
        if ($form[key]) {
            $form[key].value = values[key];
        }
    }
}

function timeout(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
}
