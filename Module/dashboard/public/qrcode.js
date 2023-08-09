class NhapMa {
    content;
    idElement;
    code;
    constructor(content) {
        this.content = content
    }
    GetCodeByQrcode() {

        var res = this.content.split("/");
        // alert(this.content);
        // alert(res[3]);
        return res[4];
    }
    async SaveCode() {
        this.code = this.GetCodeByQrcode();
        var CodeTem = this.code;
        var url = `/dashboard/index/savecode/` + CodeTem + `/`;
        if (CodeTem) {
            await $.ajax({
                "url": url,
            }).done(function (result) {
                $("#alertCode")
                    .append("<div  class='bg-green timeout'  ><span style='font-size:20px' >Đã Quét Code: " + CodeTem + "</span></div>");
                $(".timeout").each(function () {
                    $(this).hide(3000);
                });
            });
        }

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
        stream.video = { pan: true, tilt: true, zoom: true };
        opts.video.srcObject = stream;
        return stream;
    };
    var scanner = new Instascan.Scanner(opts);
    // console.log(scanner.captureImage);
    scanner.addListener('scan', function (content) {
        //        new ScanOption().GetCode(content);
        // alert(content);
        var nhapMa = new NhapMa(content);
        nhapMa.SaveCode();
    });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            var CamIndex = 0;
            var CameraIndex = window.localStorage.getItem("Camera");
            if (CameraIndex) {
                CamIndex = parseInt(CameraIndex);
            }
            scanner.start(cameras[CamIndex]);
            $('[name="options"]').on('change', function () {
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
    }).catch(function (e) {
        console.error(e);
        alert(e);
    });

} catch (e) {
    console.log(e);
}