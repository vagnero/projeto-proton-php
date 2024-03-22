// menuLogin.js

function toggleMenu() {
    var menu = document.getElementById('menu');
    menu.style.display = (menu.style.display === 'block' || menu.style.display === '') ? 'none' : 'block';
}


// Fecha o menu se o usuário clicar fora dele
// document.addEventListener('mouseup', function(e) {
//     var menu = document.getElementById('menu');
    
//     if (!menu.contains(e.target)) {
//         menu.style.display = 'none';
//     } 
// });

document.getElementById('menu').style.display = 'none';
document.addEventListener("click", function(){
    var menu = document.getElementById('menu');
    if (menu.style.display === 'block' || menu.style.display === ''){
        toggleMenu();
    }
    

});



document.querySelector(".cidadao").addEventListener("click", function(e){
    e.stopPropagation();
    
    toggleMenu();
    

});
