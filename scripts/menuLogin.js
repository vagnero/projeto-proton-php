// menuLogin.js

function toggleMenu() {
    var menu = document.getElementById('menu');
    menu.style.display = (menu.style.display === 'block' || menu.style.display === '') ? 'none' : 'block';
}

// Fecha o menu se o usuário clicar fora dele
document.addEventListener('mouseup', function(e) {
    var menu = document.getElementById('menu');
    if (!menu.contains(e.target)) {
        menu.style.display = 'none';
    } else if (isClickInsideAvatar) {
        toggleMenu();
    }
});


