
// As taken from https://gist.github.com/Windstalker/94a176945135e0a31fe0

/**
* Create the blob of html page and setting its src to appended <iframe>
**/
function print(str) {

    let contentType = 'text/html;charset=utf-8'
    let contentBlob = new Blob([str], {type : contentType});
    let frame = document.createElement('iframe')

    let removeFrame = function () {
        if (frame) {
            document.body.removeChild(frame);
            frame = null;
        }
    };

    // Commence printing
    frame.style.display = "none";
    frame.onload = function () {
        try {
            this.contentWindow.print();
            setTimeout(function () {
                // Timeout is used due to Firefox bug, when <iframe> is being removed before print occurs
                removeFrame();
            }, 10);
        } catch (e) {
            console.log(e);
            this.alert(e.message);
        }
    };

    frame.src = URL.createObjectURL(contentBlob);
    document.body.appendChild(frame);

    return frame.contentWindow;
}

export default print;
