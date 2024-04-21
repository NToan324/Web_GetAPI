function liked(x) {
    if (x.classList.contains('far')) {
        x.classList.remove('far');
        x.classList.add('fas');
    } else {
        x.classList.remove('fas');
        x.classList.add('far');
    }
}