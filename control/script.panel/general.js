function handleResize() {
    if (window.innerWidth <= "768") {
        document.body.classList.add("sidebar-minimize");
    } else {
        document.body.classList.remove("sidebar-minimize");
    }
}
const handleBurgerSidebar = () => document.body.classList.toggle("sidebar-minimize");
handleResize();
window.onresize = () => {
    handleResize();
    if (typeof handleHeightTableGift != "undefined") {
        handleHeightTableGift();
    }
};

function logout() {
    fetch_query(null, "user", "logout").then((res) => {
        if (res) return (location.href = `${$proyect.url}login`);
    });
}
