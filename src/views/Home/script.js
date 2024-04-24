// Like effect
function liked(x) {
    if (x.classList.contains('far')) {
        x.classList.remove('far');
        x.classList.add('fas');
    } else {
        x.classList.remove('fas');
        x.classList.add('far');
    }
}

// Show notification
document.getElementById('a-notification').addEventListener('click', function () { 
    var widthDefault = window.innerWidth;
    if (widthDefault >= 740 && widthDefault <= 1024) {
        var notification = document.getElementById('container-notification').classList.toggle('active');
    } else if (widthDefault > 1024) {
        var notification = document.getElementById('sidebar').classList.toggle('change-tablet');
        var notification = document.getElementById('sidebar').classList.toggle('active');
        var notification = document.getElementById('container-notification').classList.toggle('active');
    } else {
        var notification = document.getElementById('container-notification').classList.toggle('active-mobile');
    }
    
});

window.addEventListener('resize', function () {
    widthDefault = window.innerWidth;
    if (widthDefault < 740 && document.getElementById('container-notification').classList.contains('active')) {
        document.getElementById('container-notification').classList.remove('active');
        document.getElementById('sidebar').classList.remove('change-tablet');
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('container-notification').style.display = 'none';
    } else if (widthDefault > 1024 && document.getElementById('container-notification').classList.contains('active')) {
        document.getElementById('container-notification').classList.remove('active');
        document.getElementById('sidebar').classList.remove('change-tablet');
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('container-notification').style.display = 'none';
    } else if (widthDefault >= 740 && widthDefault <= 1024 && document.getElementById('container-notification').classList.contains('active-mobile')) {
        document.getElementById('container-notification').classList.remove('active-mobile');
        document.getElementById('container-notification').style.display = 'none';
    } else {
        document.getElementById('container-notification').style.display = 'block';

    }
});