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
var clickValues = {};
function toggleElement(containerId, className) {
    var widthDefault = window.innerWidth;
    var container = document.getElementById(containerId);
    var sidebar = document.getElementById('sidebar');
    var containers = document.querySelectorAll('.container-function');
    var sidebarFlag = sidebar.classList.contains('flag');

    if (sidebarFlag) {
        containers.forEach(function (item) {
            var itemId = item.id;
            if (clickValues[itemId] == true && containerId != itemId) {
                document.getElementById(itemId).classList.remove('active');
                // Check if any container is active before removing 'change-tablet'
                var anyActive = Array.from(containers).some(function (container) {
                    return container.classList.contains('active');
                });
                if (!anyActive) {
                    sidebar.classList.toggle('change-tablet');
                    sidebar.classList.remove('active');
                }
                for (var prop in clickValues) {
                    if (clickValues.hasOwnProperty(prop)) {
                        delete clickValues[prop];
                    }
                }
            }
        });
    }


    if (widthDefault >= 740 && widthDefault <= 1024) {
        container.classList.toggle('active');
        sidebar.classList.add('flag');
    } else if (widthDefault > 1024) {
        sidebar.classList.toggle('change-tablet');
        sidebar.classList.toggle('active');
        if (!sidebarFlag) {
            sidebar.classList.add('flag');
        }
        container.classList.toggle('active');
    }
    clickValues[containerId] = container.classList.contains('active') || container.classList.contains('active-mobile');
}

// Notification
document.getElementById('a-notification').addEventListener('click', function (e) {
    e.preventDefault();
    toggleElement('container-notification', 'active');

});
// Search
document.getElementById('a-search').addEventListener('click', function (e) {
    e.preventDefault();
    toggleElement('container-search', 'active');
});

// Setting
document.getElementById('a-setting').addEventListener('click', function (e) {
    e.preventDefault();
    toggleElement('container-setting', 'active');
});




//Break sidebar when resize
function resize(id) {
    var widthDefault = window.innerWidth;
    var idSidebar = document.getElementById('sidebar');
    if (widthDefault >= 740 && widthDefault < 1024) {
        window.addEventListener('resize', function () {
            widthAfter = window.innerWidth;
            if (widthAfter >= 1024 || widthAfter < 740) {
                document.getElementById(id).classList.remove('active');
                idSidebar.classList.remove('change-tablet');
                idSidebar.classList.remove('active');
                idSidebar.classList.remove('flag');
            }
        });
    } else if (widthDefault >= 1024) {
        window.addEventListener('resize', function () {
            widthAfter = window.innerWidth;
            if (widthAfter < 1024) {
                document.getElementById(id).classList.remove('active');
                idSidebar.classList.remove('change-tablet');
                idSidebar.classList.remove('active');
                idSidebar.classList.remove('flag');
            }
        });
    }
}

window.addEventListener('resize', function () {
    if(this.document.getElementById('container-notification').classList.contains('active')){
        resize('container-notification');
    }
});
window.addEventListener('resize', function () {
    if(this.document.getElementById('container-search').classList.contains('active')){
        resize('container-search');
    }
});
window.addEventListener('resize', function () {
    if(this.document.getElementById('container-setting').classList.contains('active')){
        resize('container-setting');
    }
});

// Confirm logout
function confirmLogout (id) {
    document.getElementById(id).addEventListener('click', function () {
        document.getElementById('confirmBox').style.visibility = 'visible';
        var cancelLogout = document.getElementById('cancelBtn');
        cancelLogout.addEventListener('click', function () {
            document.getElementById('confirmBox').style.visibility = 'hidden';
        });
    });
}
confirmLogout('logout-btn');
confirmLogout('mobile-logout-btn')

// Mode mobile
function modeMobile(id) {
    document.getElementById(id).addEventListener('click', function () {
            var href = '';
        var widthDefault = window.innerWidth;
        if(widthDefault < 740){
            if(id == 'a-search') {
                href = '/Web_RestAPI/src/views/Search/index.html';
                window.location.href = href;
            } else if (id == 'a-notification') {
                href = '/Web_RestAPI/src/views/Notification/index.html';
                window.location.href = href;
            }
        }
    });
}

modeMobile('a-search');
modeMobile('a-notification');
    