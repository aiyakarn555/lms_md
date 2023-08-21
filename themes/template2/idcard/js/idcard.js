var streaming = false;
var cameraStarted = false;
var videoWidth = 640;
var videoHeight = 480;

var video = document.getElementById('video');

var canvas = document.getElementById('canvas');
var photo = document.getElementById('photo');

var startbutton = document.getElementById('startbutton');
var clearphotoButton = document.getElementById('clearphotoButton');
var startCameraBtn = document.getElementById('startCameraBtn');
var takeCameraMobile = document.getElementById('takeCameraMobile');
var uploadFile = document.getElementById('uploadFile');
var clearCameraMobile = document.getElementById('clearCameraMobile');

var idcard = document.getElementById('idcard');
var idcardWrapper = document.getElementById('idcardWrapper');
var cameraPhotoWrapper = document.getElementById('cameraPhotoWrapper');

function startup() {
    if (isMobile.any()) {
        idcardWrapper.classList.add('mobile');
        idcardWrapper.classList.remove('no-mobile');
    } else {
        idcardWrapper.classList.add('no-mobile');
        idcardWrapper.classList.remove('mobile');
        checkDeviceSupport(function () {
            if (hasWebcam) {
                idcardWrapper.classList.add('has-webcam');
                startupCamera();
                clearphoto();
            } else {
                idcardWrapper.classList.add('no-webcam');
            }
        });
    }
}

startCameraBtn.addEventListener('click',
    function (ev) {
        //startupCamera();
        takepicture();
        ev.preventDefault();
    },
    false);

clearphotoButton.addEventListener('click',
    function (ev) {
        clearphoto();
        ev.preventDefault();
    },
    false);

clearCameraMobile.addEventListener('click',
    function (ev) {
        clearphoto();
        ev.preventDefault();
    },
    false);

function startupCamera() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');

    navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false
    })
        .then(function (stream) {
            video.srcObject = stream;
            video.play();
            cameraStarted = true;
            idcardWrapper.classList.add('camera-started');
        })
        .catch(function (err) {
            Swal.fire({
                title: "คุณไม่มีสิทธิ์เข้าถึง กล้อง บนบราวเซอร์นี้ !",
                text: "กรุณาตั้งค่าตามคู่มือการใช้งาน",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ตกลง',
                allowOutsideClick: false,

            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = "/ShowUsability";
                } else if (result.isDenied) {
                    window.location.href = "/ShowUsability";
                }
            });
        });
    video.addEventListener('canplay',
        function (ev) {
            if (!streaming) {

                videoWidth = cameraPhotoWrapper.offsetWidth;

                if (videoWidth > 640) {
                    videoWidth = 640;
                }


                videoHeight = 480 * videoWidth / 640;


                if (video.videoWidth)
                    videoHeight = video.videoHeight / (video.videoWidth / videoWidth);
                if (isNaN(videoHeight)) {
                    videoHeight = 480 * videoWidth / 640;
                }
                //*/
                // /*
                video.setAttribute('width', videoWidth);
                video.setAttribute('height', videoHeight);
                canvas.setAttribute('width', videoWidth);
                canvas.setAttribute('height', videoHeight);
                // */
                streaming = true;
            }
        },
        false);
}

function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
    idcard.setAttribute('value', '');

    takeCameraMobile.files = null;
    uploadFile.files = null;

    idcardWrapper.classList.remove("captured");
    idcardWrapper.classList.remove('has-photo');
    idcardWrapper.classList.add('no-photo');

}

function takepicture() {
    var context = canvas.getContext('2d');
    if (videoWidth && videoHeight) {
        canvas.width = videoWidth;
        canvas.height = videoHeight;
        context.drawImage(video, 0, 0, videoWidth, videoHeight);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        idcard.setAttribute('value', data);
        idcardWrapper.classList.add("captured");
        idcardWrapper.classList.add('has-photo');
        idcardWrapper.classList.remove('no-photo');
    } else {
        clearphoto();
    }
}

function onfileChange(param) {
    console.log(param.files[0]);
    getBase64(param.files[0]);
}


function getBase64(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        console.log(reader.result);
        var data = reader.result;
        photo.setAttribute('src', data);
        idcard.setAttribute('value', data);

        idcardWrapper.classList.add('has-photo');
        idcardWrapper.classList.remove('no-photo');

        takeCameraMobile.value = null;
        uploadFile.value = null;

    };
    reader.onerror = function (error) {
        console.log('Error: ', error);
        photo.setAttribute('src', '');
        idcardWrapper.classList.add('no-photo');
        idcardWrapper.classList.remove('has-photo');

        takeCameraMobile.value = null;
        uploadFile.value = null;
    };
}

if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
    // Firefox 38+ seems having support of enumerateDevicesx
    navigator.enumerateDevices = function (callback) {
        navigator.mediaDevices.enumerateDevices().then(callback);
    };
}

var MediaDevices = [];
var isHTTPs = location.protocol === 'https:';
var canEnumerate = false;

if (typeof MediaStreamTrack !== 'undefined' && 'getSources' in MediaStreamTrack) {
    canEnumerate = true;
} else if (navigator.mediaDevices && !!navigator.mediaDevices.enumerateDevices) {
    canEnumerate = true;
}

var hasMicrophone = false;
var hasSpeakers = false;
var hasWebcam = false;

var isMicrophoneAlreadyCaptured = false;
var isWebcamAlreadyCaptured = false;

function checkDeviceSupport(callback) {
    if (!canEnumerate) {
        return;
    }

    if (!navigator.enumerateDevices && window.MediaStreamTrack && window.MediaStreamTrack.getSources) {
        navigator.enumerateDevices = window.MediaStreamTrack.getSources.bind(window.MediaStreamTrack);
    }

    if (!navigator.enumerateDevices && navigator.enumerateDevices) {
        navigator.enumerateDevices = navigator.enumerateDevices.bind(navigator);
    }

    if (!navigator.enumerateDevices) {
        if (callback) {
            callback();
        }
        return;
    }

    MediaDevices = [];
    navigator.enumerateDevices(function (devices) {
        devices.forEach(function (_device) {
            var device = {};
            for (var d in _device) {
                device[d] = _device[d];
            }

            if (device.kind === 'audio') {
                device.kind = 'audioinput';
            }

            if (device.kind === 'video') {
                device.kind = 'videoinput';
            }

            var skip;
            MediaDevices.forEach(function (d) {
                if (d.id === device.id && d.kind === device.kind) {
                    skip = true;
                }
            });

            if (skip) {
                return;
            }

            if (!device.deviceId) {
                device.deviceId = device.id;
            }

            if (!device.id) {
                device.id = device.deviceId;
            }

            if (!device.label) {
                device.label = 'Please invoke getUserMedia once.';
                if (!isHTTPs) {
                    device.label = 'HTTPs is required to get label of this ' + device.kind + ' device.';
                }
            } else {
                if (device.kind === 'videoinput' && !isWebcamAlreadyCaptured) {
                    isWebcamAlreadyCaptured = true;
                }

                if (device.kind === 'audioinput' && !isMicrophoneAlreadyCaptured) {
                    isMicrophoneAlreadyCaptured = true;
                }
            }

            if (device.kind === 'audioinput') {
                hasMicrophone = true;
            }

            if (device.kind === 'audiooutput') {
                hasSpeakers = true;
            }

            if (device.kind === 'videoinput') {
                hasWebcam = true;
            }

            // there is no 'videoouput' in the spec.

            MediaDevices.push(device);
        });

        if (callback) {
            callback();
        }
    });
}


var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

//window.addEventListener('load', startup, false);
window.addEventListener('load', startup, false);
