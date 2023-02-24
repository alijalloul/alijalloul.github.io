const sideNavBtns = document.querySelectorAll('.exp-btns');

sideNavBtns.forEach(function(e) {
    if(e.attributes.selected.nodeValue == 1)
    {  
        let test = e;
        e.style.backgroundColor = 'rgb(56, 56, 56)';
    }
});