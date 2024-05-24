function showInputImage(id) {
    var inputImage = document.getElementById(id);
    inputImage.addEventListener('change', function () {
        var file = inputImage.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('img-upload').src = e.target.result;
            document.getElementById('img-upload').style.display = "block";
        }
        reader.readAsDataURL(file);
    });
}
showInputImage('file-upload');