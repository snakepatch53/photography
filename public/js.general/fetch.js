let fetch_query = (formData, entity, operation) => {
    return fetch(`${http_domain}services/${entity}/${operation}`, {
        method: "POST",
        headers: new Headers().append("Accept", "application/json"),
        body: formData,
    })
        .then((res) => (res.ok ? res.json() : false))
        .then((res) => res);
};
