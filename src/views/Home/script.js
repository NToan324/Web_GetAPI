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

    var count = 1;
    if (sidebarFlag) {
        containers.forEach(function (item) {
            var itemId = item.id;
            if (clickValues[itemId] == true && containerId != itemId) {
                console.log("Before click: " + itemId + "\nAfter click: " + containerId + "\nActive: " + clickValues[itemId] + "\nCount: " + count++);
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
document.getElementById('a-notification').addEventListener('click', function () {
    toggleElement('container-notification', 'active');

});
// Search
document.getElementById('a-search').addEventListener('click', function () {
    toggleElement('container-search', 'active');
});

// Setting
document.getElementById('a-setting').addEventListener('click', function () {
    toggleElement('container-setting', 'active');
});




//Break sidebar when resize
function resize(id) {
    var widthDefault = window.innerWidth;
    if (widthDefault >= 740 && widthDefault < 1024) {
        window.addEventListener('resize', function () {
            widthAfter = window.innerWidth;
            if (widthAfter >= 1024 || widthAfter < 740) {
                document.getElementById(id).classList.remove('active');
                document.getElementById('sidebar').classList.remove('change-tablet');
                document.getElementById('sidebar').classList.remove('active');
            }
        });
    } else if (widthDefault >= 1024) {
        window.addEventListener('resize', function () {
            widthAfter = window.innerWidth;
            if (widthAfter < 1024) {
                document.getElementById(id).classList.remove('active');
                document.getElementById('sidebar').classList.remove('change-tablet');
                document.getElementById('sidebar').classList.remove('active');
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
                href = '/src/views/Search/index.html';
                window.location.href = href;
            } else if (id == 'a-notification') {
                href = '/src/views/Notification/index.html';
                window.location.href = href;
            }
        }
    });
}

modeMobile('a-search');
modeMobile('a-notification');
    