
function start_camera(){
    const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
let stage = 0;  // Track user progress

// Start Webcam
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
    })
    .catch(err => console.log("Webcam Error: " + err));

// Capture Image & Analyze
$("#capture").click(function () {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(blob => {
        var formData = new FormData();
        formData.append("api_key", "4EMenTzRImcVPWlBVJoyx9RWvnTITajr");  // Replace with Face++ API Key
        formData.append("api_secret", "U0e84BF-T4fYMUo_NN4hI9gtKmfw67-z");  // Replace with Face++ API Secret
        formData.append("image_file", blob);
        formData.append("return_attributes", "headpose,smiling");

        $.ajax({
            url: "https://api-us.faceplusplus.com/facepp/v3/detect",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#response").text(JSON.stringify(response, null, 4));

                if (response.faces.length > 0) {
                    let face = response.faces[0].attributes;
                    let yaw = face.headpose.yaw_angle;  // Left/Right movement
                    let smile = face.smile.value;  // Smile intensity

                    if (stage === 0 && yaw > -10 && yaw < 10) {
                        $("#instruction").text("Turn Your Head Left");
                        stage = 1;
                    } else if (stage === 1 && yaw < -15) {
                        $("#instruction").text("Turn Your Head Right");
                        stage = 2;
                    } else if (stage === 2 && yaw > 15) {
                        $("#instruction").text("Smile 😊");
                        stage = 3;
                    } else if (stage === 3 && smile > 50) {
                        $("#instruction").text("✅ All Done!");
                    }
                } else {
                    $("#instruction").text("No face detected. Try again.");
                }
            },
            error: function (err) {
                console.log(err);
                alert("Error analyzing the image.");
            }
        });
    }, 'image/jpeg');
});
}
