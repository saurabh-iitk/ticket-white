//Multi Image Previev
window.onload = function () {
    var MultifileUpload = document.getElementById("Multifileupload");
    if (MultifileUpload) {
        MultifileUpload.onchange = function () {
            if (typeof (FileReader) != "undefined") {
                var MultidvPreview = document.getElementById("MultidvPreview");
                MultidvPreview.innerHTML = "";
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                for (var i = 0; i < MultifileUpload.files.length; i++) {
                    var file = MultifileUpload.files[i];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = document.createElement("IMG");
                        img.height = "100";
                        img.width = "100";
                        img.src = e.target.result;
                        img.id = "Multifileupload_image";
                        MultidvPreview.appendChild(img);
                        $("#Multifileupload_button").show();
                    }
                    reader.readAsDataURL(file);
                }
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        }
    }

    var Multivideoupload = document.getElementById("Multivideoupload");
    if (Multivideoupload) {
        Multivideoupload.onchange = function () {
            if (typeof (FileReader) != "undefined") {
                var VideoPreview = document.getElementById("VideoPreview");
                VideoPreview.innerHTML = "";
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.mp4|.mkv|.wmv|.webm|.3gp)$/;
                for (var i = 0; i < Multivideoupload.files.length; i++) {
                    var file = Multivideoupload.files[i];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        // var img = document.createElement("IMG");
                        // img.height = "100";
                        // img.width = "100";
                        // img.src = e.target.result;
                        // img.id = "Multifileupload_image";
                        // VideoPreview.appendChild(img);

                        var span = document.createElement('span');
                        span.innerHTML = ['<span class="remove"><i class="fa fa-times" style="position: absolute;color: red;background-color: #ccc;padding: 0px;z-index: 12;cursor: pointer;" ></i><video width="64" height="64" style="margin-left:5px;" controls><source src="', e.target.result,'" type="video/mp4"></video></span>'].join('');
                        VideoPreview.appendChild(span);

                        $("#Multifileupload_button").show();
                        $(".remove").click(function(){
                            $(this).parent("span").remove();
                        });
                    }
                    reader.readAsDataURL(file);
                }
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        }
    }
};