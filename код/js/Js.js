/**/
document.addEventListener('DOMContentLoaded', () => {

    window.onbeforeunload = () => sessionStorage.setItem('scrollPos', window.scrollY);
    window.onload = () => window.scrollTo(0, sessionStorage.getItem('scrollPos') || 0);
    
    const burger = document.getElementById('burger');
    const navBlock = document.getElementById('NavigateBlock');
    
    burger.addEventListener('click', () => 
    {
    navBlock.classList.toggle('active');
    burger.classList.toggle('active');
    })
    })








