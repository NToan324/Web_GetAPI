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

// Show Function Page
function toggleElement(containerId, className) {
    var widthDefault = window.innerWidth;
    var container = document.getElementById(containerId);
    var sidebar = document.getElementById('sidebar');
    var containers = document.querySelectorAll('.container');
    var sidebarFlag = sidebar.classList.contains('flag');

    containers.forEach(function(item) {
        if (item.id !== containerId) {
            item.classList.remove('active');
        }
    });

    if (widthDefault >= 740 && widthDefault <= 1024) {
        container.classList.toggle('active');
    } else if (widthDefault > 1024) {
        sidebar.classList.toggle('change-tablet');
        sidebar.classList.toggle('active');
        if (!sidebarFlag) {
            sidebar.classList.add('flag');
        }
        container.classList.toggle('active');
    } else if (widthDefault < 740) {
        container.classList.toggle('active-mobile');
        sidebar.classList.remove('flag');
    }
}

// Notification
document.getElementById('a-notification').addEventListener('click', function() {
    toggleElement('container-notification', 'active');

});
// Search
document.getElementById('a-search').addEventListener('click', function() {
    toggleElement('container-search', 'active');
});
//Post
document.getElementById('a-post').addEventListener('click', function() {
    toggleElement('container-post', 'active');

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