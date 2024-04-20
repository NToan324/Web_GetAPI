function liked(x) {
    if (x.classList.contains('far')) {
        x.classList.remove('far');
        x.classList.add('fas');
        x.classList.add('fill');
    } else {
        x.classList.remove('fill');
        x.classList.remove('fas');
        x.classList.add('far');
    }
}