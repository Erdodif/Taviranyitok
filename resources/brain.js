window.addEventListener("DOMContentLoaded", init);
function init() {
    extrak();
    elerhetoek();
    formFigyeles();
}
function formFigyeles(){
    in_all = document.getElementById("in_all");
    if (in_all === null || in_all === undefined){
        return;
    }
    in_all.addEventListener("submit",(e)=>{
        if(!validacio(true)) {
            e.preventDefault();
        }
    });
    for (const elem of document.getElementsByClassName("in")) {
        elem.addEventListener("input",validacio);
    }
    validacio(false);
}

function hibaTakarit(){
    let idk = ["gyarto","termek_nev","megjelenes","ar"];
    for(id of idk){
        let temp = document.getElementById("in_"+id+"_hiba");
        let tempSzulo = document.getElementById("parent_"+id);
        if(temp!==null && temp!==undefined){
            tempSzulo.removeChild(temp);
        }
    }
}
function hibaKreal(id,szoveg){
    let tempSzulo = document.getElementById("parent_"+id);
    let temp = document.createElement("span");
    temp.id = ("in_"+id+"_hiba");
    temp.classList.add("hiba");
    temp.innerHTML = szoveg;
    console.log(temp);
    tempSzulo.appendChild(temp);
}

function validacio(kuldes = false){
    //todo hiba megjelenítése
    console.log("validacio kezdete");
    let termek_nev = document.getElementById("in_termek_nev").value;
    let gyarto = document.getElementById("in_gyarto").value;
    let megjelenes = document.getElementById("in_megjelenes").value;
    let ar = document.getElementById("in_ar").value;
    termek_nevHossz= termek_nev.length;
    gyartoHossz= gyarto.length;
    hibaTakarit();
    let ok = true;
    if (termek_nevHossz < 5){
        ok = false;
        hibaKreal("termek_nev","5 karakternél hosszabbnak kell lennie!");
    }
    else if (termek_nevHossz > 20){
        ok = false;
        hibaKreal("termek_nev","20 karakternél rövidebbnek kell lennie!");
    }
    if (gyartoHossz < 2){
        ok = false;
        hibaKreal("gyarto","2 karakternél hosszabbnak kell lennie!");
    }
    else if (gyartoHossz > 20){
        ok = false;
        hibaKreal("gyarto","20 karakternél rövidebbnek kell lennie!");
    }
    if (megjelenes instanceof Date && !isNaN(megjelenes.valueOf())){
        ok = false;
        hibaKreal("megjelenes","Helyes adat várt!");
    }
    else if (megjelenes == "0000-00-00"){
        ok = false;
        hibaKreal("megjelenés","A megadás kötelező!");
    }
    if (isNaN(ar)){
        ok = false;
        hibaKreal("ar","Szám várt!");
    }
    else if (ar < 0){
        ok = false;
        hibaKreal("ar","Nem lehet negatív!");
    }
    if (!ok && kuldes === true){
        alert("Nem megfelelőek az adatok!");
    }
    return ok;
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