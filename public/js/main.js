function requisitarPagina(url) {

    document.getElementById('content').innerHTML = ''

    let ajax = new XMLHttpRequest();

    ajax.open('GET', url);
    ajax.onreadystatechange = () => { 
        if(ajax.readyState == 4 && ajax.status == 200) {
            document.getElementById('content').innerHTML = ajax.responseText;
        }
    } 

    ajax.send();    
}