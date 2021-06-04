class NhapMa {
    content;
    idElement;
    code;
    constructor(content) {
        this.content = content
    }
    GetCodeByQrcode() {
        var res = this.content.split("/");
        return res[res.length - 1];
    }
    async   SaveCode() {
        this.code = this.GetCodeByQrcode();
        var CodeTem = this.code;
        var url = "/dashboard/index/savecode/" + this.code;
        await  $.ajax({
            "url": url,
        }).done(function(result) {
            $("#alertCode").append("<div class='bg-green timeout'  >Đã Quét Code: " + CodeTem + "</div>");
            $(".timeout").each(function() {
                $(this).hide(2000);
            });
        });
    }

}

try {
    let opts = {
        continuous: true,
        video: document.getElementById('preview'),
        mirror: false,
        captureImage: false,
        backgroundScan: true,
        refractoryPeriod: 100,
        scanPeriod: 1
    };
    window.URL.createObjectURL = (stream) => {
        opts.video.srcObject = stream;
        return stream;
    };
    var scanner = new Instascan.Scanner(opts);
    scanner.addListener('scan', function(content) {
//        new ScanOption().GetCode(content);
//        alert(content);
        var nhapMa = new NhapMa(content);
        nhapMa.SaveCode();
    });
    Instascan.Camera.getCameras().then(function(cameras) {
//        console.log(cameras.length);
//        console.log(Object.values(cameras));
//        for (index in cameras) {
//            $("#Cams").append(Object.values(cameras[index]).toString());
//        }
        if (cameras.length > 0) {
            var CamIndex = 0;
            var CameraIndex = window.localStorage.getItem("Camera");
            if (CameraIndex) {
                CamIndex = parseInt(CameraIndex);
            }
            scanner.start(cameras[CamIndex]);
            $('[name="options"]').on('change', function() {
                scanner.stop();
                var $vtCam = $(this).val();
                if (cameras[$vtCam] != "") {
                    scanner.start(cameras[$vtCam]);
                    window.localStorage.setItem("Camera", $vtCam);
                } else {
                    alert('No Front camera found!');
                }
            });
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(e) {
        console.error(e);
        alert(e);
    });

} catch (e) {
    console.log(e);
}