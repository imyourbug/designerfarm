$(document).ready(function () {
    // Lấy ra các form-group tương ứng
    var freepikContent = $('#freepikContent');
    var envatoContent = $('#envatoContent');
    var pikbestContent = $('#pikbestContent');
    var motionContent = $('#motionarrayContent');
    var lovepikContent = $('#lovepikContent');
    var pngtreeContent = $('#pngtreeContent');
    var artlistContent = $('#artlistContent');
    var flaticonContent = $('#flaticonContent');
    var storyblocksContent = $('#storyblocksContent');
    var vecteezyContent = $('#vecteezyContent');
    var adobestockContent = $('#adobestockContent');

    // Đối tượng chứa thông tin về các ID và các lựa chọn tương ứng
    var options = {
        "Freepik": [
            { value: "image", label: "JPG/PSD/AI" },
            { value: "video", label: "VIDEO" }
        ],
        "Envato": [
            { value: "file", label: "FILE" },
            { value: "license", label: "LICENSE" }
        ],
        "MotionArray": [
            { value: "file", label: "FILE" },
            { value: "license", label: "LICENSE" }
        ],
        "Artlist": [
            { value: "file", label: "MUSIC/VIDEO" },
            { value: "license", label: "LICENSE" }
        ],
        "Lovepik": [
            { value: "image", label: "JPG/PSD/AI" },
            { value: "video", label: "VIDEO" }
        ]
    };

    // Xử lý sự kiện click trên các ID
    function handleIDClick(id) {
        // Ẩn tất cả các form-group trước khi hiển thị nội dung mới
        hideAllContent();
        // Hiển thị nội dung của ID được click
        var content = document.getElementById(id.toLowerCase() + "Content");
        if (content) {
            content.style.display = "block";
        }

        // Xóa tất cả các radio buttons cũ
        clearRadioButtons();

        // Thêm radio buttons mới cho ID được click
        var idOptions = options[id];
        if (idOptions) {
            var radioButtonsHTML = '<div style="text-align: center;">';
            let i = 0;
            idOptions.forEach(function (option) {
                radioButtonsHTML += `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" ${i == 0 ? 'checked' : ''} type="radio" name="typeDownload" value="${option.value}" data-dashlane-rid="${generateDashlaneRid()}" data-form-type="">
                        <label class="form-check-label">${option.label}</label>
                    </div>
                `;
                i = 1;
            });
            radioButtonsHTML += '</div>';

            $('.message-input-container').append(radioButtonsHTML);
        }
    }

    function resetForm() {
        document.getElementById('messageInput').value = '';
        document.getElementById('notification').style.display = 'none';
    }

    // Xử lý sự kiện click trên các ID
    $(document).on('click', '#Freepik', function () {
        handleIDClick("Freepik");
        resetForm();
    });
    $(document).on('click', '#Envato', function () {
        handleIDClick("Envato");
        resetForm();
    });
    $(document).on('click', '#Pikbest', function () {
        handleIDClick("Pikbest");
        resetForm();
    });
    $(document).on('click', '#MotionArray', function () {
        handleIDClick("MotionArray");
        resetForm();
    });
    $(document).on('click', '#Lovepik', function () {
        handleIDClick("Lovepik");
        resetForm();
    });

    $(document).on('click', '#Pngtree', function () {
        handleIDClick("Pngtree");
        resetForm();
    });

    $(document).on('click', '#Artlist', function () {
        handleIDClick("Artlist");
        resetForm();
    });
    $(document).on('click', '#Flaticon', function () {
        handleIDClick("Flaticon");
        resetForm();
    });
    $(document).on('click', '#Storyblocks', function () {
        handleIDClick("Storyblocks");
        resetForm();
    });

    $(document).on('click', '#Vecteezy', function () {
        handleIDClick("Vecteezy");
        resetForm();
    });

    $(document).on('click', '#AdobeStock', function () {
        handleIDClick("AdobeStock");
        resetForm();
    });
    // Thêm xử lý cho các ID khác tương tự
    // ...

    // Hàm ẩn tất cả các form-group
    function hideAllContent() {
        freepikContent.css('display', 'none');
        envatoContent.css('display', 'none');
        pikbestContent.css('display', 'none');
        motionContent.css('display', 'none');
        lovepikContent.css('display', 'none');
        pngtreeContent.css('display', 'none');
        artlistContent.css('display', 'none');
        flaticonContent.css('display', 'none');
        storyblocksContent.css('display', 'none');
        vecteezyContent.css('display', 'none');
        adobestockContent.css('display', 'none');
        // Ẩn thêm các form-group khác nếu có
    }

    // Hàm xóa tất cả các radio buttons
    function clearRadioButtons() {
        var radioButtons = document.querySelectorAll('input[name="typeDownload"]');
        radioButtons.forEach(function (radioButton) {
            radioButton.parentNode.remove();
        });
    }

    // Hàm tạo một dashlane-rid ngẫu nhiên (chỉ mô phỏng)
    function generateDashlaneRid() {
        return Math.random().toString(36).substr(2, 10);
    }

    // Lấy ra tất cả các liên kết trong .sidenav
    var links = document.querySelectorAll(".sidenav a");

    // Xử lý sự kiện click cho mỗi liên kết
    links.forEach(function (link) {
        link.addEventListener("click", function (event) {
            // Loại bỏ lớp selected từ tất cả các liên kết
            links.forEach(function (link) {
                link.classList.remove("selected");
            });

            // Thêm lớp selected cho liên kết được click
            event.target.classList.add("selected");
        });
    });
})