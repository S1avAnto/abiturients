document.addEventListener('DOMContentLoaded', (e) => {
    document.getElementById("requests__close__button").addEventListener('click', (e)=> {
        document.getElementById("requests").classList.add("is-non-active");
    });
    document.getElementById("requests__add__button").addEventListener('click', (e)=> {
        document.getElementById("requests").classList.remove("is-non-active");
    });

    document.getElementById("ege_results__close__button").addEventListener('click', (e)=> {
        document.getElementById("ege_results").classList.add("is-non-active");
    });
    document.getElementById("ege_results__add__button").addEventListener('click', (e)=> {
        document.getElementById("ege_results").classList.remove("is-non-active");
    });

    document.getElementById("ege_results__close__button").addEventListener('click', (e)=> {
        document.getElementById("ege_results").classList.add("is-non-active");
    });
    document.getElementById("ege_results__add__button").addEventListener('click', (e)=> {
        document.getElementById("ege_results").classList.remove("is-non-active");
    });
});