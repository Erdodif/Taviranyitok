window.addEventListener("DOMContentLoaded", init);
function init() {
    extrak();
    elerhetoek();
}
function elerhetoek() {
    let list = document.getElementsByClassName("elerhetoek");
    if (list === null || list === undefined) {
        return;
    }
    for(const elem of list){
        let tartalom = elem.innerHTML == 1;
        elem.classList.add("text-white");
        elem.classList.add("p-1");
        if (tartalom){
            elem.innerHTML = "Raktáron";
            elem.classList.add("bg-success");
        }
        else{
            elem.innerHTML = "Kifogyott";
            elem.classList.add("bg-danger");
        }
    }
}

function extrak() {
    if (document.getElementById("extra-remove") === null) {
        return;
    }
    document.getElementById("extra-remove").addEventListener("click", removeExtra);
    document.getElementById("deck").classList.add("halovany");
}
function removeExtra() {
    document.getElementById("extrak").removeChild(document.getElementById("extra"));
    document.getElementById("deck").classList.remove("halovany");
}