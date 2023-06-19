$(window).ready(() => {
    setActiveMenu();
});


const setActiveMenu = function(){
    var pathArray = window.location.pathname.split('/');
    console.log(pathArray)
    let menu = !!pathArray[1]?pathArray[1]:'home';
    console.log(menu);
    $(`.menu-item[data-menu$='${window.location.pathname}']`).addClass('active')
    console.log($(`.menu-item[data-menu$='${window.location.pathname}']`))
    $(`.menu-item[data-menu*='${menu}']`).addClass('active')
    if(!!pathArray[2]){
        let submenu = !!pathArray[2]?pathArray[2]:'';
        $(`.menu-item[data-menu*='${submenu}']`).addClass('active')
    }
}