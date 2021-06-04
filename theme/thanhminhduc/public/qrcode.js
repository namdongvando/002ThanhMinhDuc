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
        var url = "/scanqrcode/savecode/" + this.code;
        await  $.ajax({
            "url": url,
        }).done(function(result) {
            $("#listcode").html(result);
        });
    }

}

try {
    let opts = {
        continuous: true,
        video: document.getElementById('preview'),
        mirror: true,
        captureImage: false,
        backgroundScan: true,
        refractoryPeriod: 500,
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
        console.log(cameras.length);
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