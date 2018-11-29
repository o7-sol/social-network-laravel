       $(document).ready(function() {
       	if(document.getElementById("image") !== null){
            document.getElementById("image").onchange = function () {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById("uploadedimage").src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            };
        }
        });