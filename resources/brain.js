window.addEventListener("DOMContentLoaded",init);
function init(){
    if (document.getElementById("extra-remove") === null){
        return;
    }
    document.getElementById("extra-remove").addEventListener("click",removeExtra);
    document.getElementById("deck").classList.add("halovany");
}
function removeExtra(){
    document.getElementById("extrak").removeChild(document.getElementById("extra"));
    document.getElementById("deck").classList.remove("halovany");
}