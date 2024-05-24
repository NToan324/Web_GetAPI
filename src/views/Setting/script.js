function inputImage(id) {
    var input = document.getElementById(id);
    input.addEventListener('change', function(){
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('showImage').style.display = 'block';
            var img = document.getElementById('showImage'); 
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}

inputImage('change-avt');