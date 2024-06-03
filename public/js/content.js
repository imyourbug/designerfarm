// document.addEventListener("DOMContentLoaded", function() {
//     // Lấy ra tất cả các ID cần thao tác
//     var freepik = document.getElementById("Freepik");
//     var envato = document.getElementById("Envato");
//     var pikbest = document.getElementById("Pikbest");
//     var motionarray = document.getElementById("MotionArray");
//     var lovepik = document.getElementById("Lovepik");
//     var pngtree = document.getElementById("Pngtree");
//     var artlist = document.getElementById("Artlist");
//     var flaticon = document.getElementById("Flaticon");
//     var storyblock = document.getElementById("Storyblock");
//     var vecteezy = document.getElementById("Vecteezy");
//     var adobestock = document.getElementById("AdobeStock");

//     // Lấy ra các form-group tương ứng
//     var freepikContent = document.getElementById("freepikContent");
//     var envatoContent = document.getElementById("envatoContent");
//     var pikbestContent = document.getElementById("pikbestContent");
//     var motionContent = document.getElementById("motionContent");
//     var lovepikContent = document.getElementById("lovepikContent");
//     var pngtreeContent = document.getElementById("pngtreeContent");
//     var artlistContent = document.getElementById("artlistContent");
//     var flaticonContent = document.getElementById("flaticonContent");
//     var storyblocksContent = document.getElementById("storyblocksContent");
//     var vecteezyContent = document.getElementById("vecteezyContent");
//     var adobestockContent = document.getElementById("adobestockContent");

//     // Đối tượng chứa thông tin về các ID và các lựa chọn tương ứng
//     var options = {
//         "Freepik": [
//             { value: "image", label: "JPG/PSD/AI" },
//             { value: "video", label: "VIDEO" }
//         ],
//         "Envato": [
//             { value: "nolicense", label: "FILE" },
//             { value: "license", label: "LICENSE" }
//         ],
//         "Motion": [
//             { value: "nolicense", label: "FILE" },
//             { value: "license", label: "LICENSE" }
//         ],
//         "Artlist": [
//             { value: "nolicense", label: "MUSIC/VIDEO" },
//             { value: "license", label: "LICENSE" }
//         ]
//     };

//     // Xử lý sự kiện click trên các ID
//     function handleIDClick(id) {
//         // Ẩn tất cả các form-group trước khi hiển thị nội dung mới
//         hideAllContent();
//         // Hiển thị nội dung của ID được click
//         var content = document.getElementById(id.toLowerCase() + "Content");
//         if (content) {
//             content.style.display = "block";
//         }

//         // Xóa tất cả các radio buttons cũ
//         clearRadioButtons();

//         // Thêm radio buttons mới cho ID được click
//         var idOptions = options[id];
//         if (idOptions) {
//             var radioButtonsHTML = '<div style="text-align: center;">';
//             idOptions.forEach(function(option) {
//                 radioButtonsHTML += `
//                     <div class="form-check form-check-inline">
//                         <input class="form-check-input" type="radio" name="typeDownload" value="${option.value}" data-dashlane-rid="${generateDashlaneRid()}" data-form-type="">
//                         <label class="form-check-label">${option.label}</label>
//                     </div>
//                 `;
//             });
//             radioButtonsHTML += '</div>';

//             var messageInputContainer = document.querySelector(".message-input-container");
//             messageInputContainer.insertAdjacentHTML('afterend', radioButtonsHTML);
//         }
//     }

//     // Xử lý sự kiện click trên các ID
//     freepik.addEventListener("click", function() {
//         handleIDClick("Freepik");
//         resetForm();
//     });

//     envato.addEventListener("click", function() {
//         handleIDClick("Envato");
//         resetForm();
//     });

//     pikbest.addEventListener("click", function() {
//         handleIDClick("Pikbest");
//         resetForm();
//     });

//     motionarray.addEventListener("click", function() {
//         handleIDClick("Motion");
//         resetForm();
//     });

//     lovepik.addEventListener("click", function() {
//         handleIDClick("Lovepik");
//         resetForm();
//     });

//     pngtree.addEventListener("click", function() {
//         handleIDClick("Pngtree");
//         resetForm();
//     });

//     artlist.addEventListener("click", function() {
//         handleIDClick("Artlist");
//         resetForm();
//     });

//     flaticon.addEventListener("click", function() {
//         handleIDClick("Flaticon");
//         resetForm();
//     });

//     storyblock.addEventListener("click", function() {
//         handleIDClick("Storyblocks");
//         resetForm();
//     });

//     vecteezy.addEventListener("click", function() {
//         handleIDClick("Vecteezy");
//         resetForm();
//     });

//     adobestock.addEventListener("click", function() {
//         handleIDClick("AdobeStock");
//         resetForm();
//     });

//     // Thêm xử lý cho các ID khác tương tự
//     // ...

//     // Hàm ẩn tất cả các form-group
//     function hideAllContent() {
//         freepikContent.style.display = "none";
//         envatoContent.style.display = "none";
//         pikbestContent.style.display = "none";
//         motionContent.style.display = "none";
//         lovepikContent.style.display = "none";
//         pngtreeContent.style.display = "none";
//         artlistContent.style.display = "none";
//         flaticonContent.style.display = "none";
//         storyblocksContent.style.display = "none";
//         vecteezyContent.style.display = "none";
//         adobestockContent.style.display = "none";
//         // Ẩn thêm các form-group khác nếu có
//     }

//     // Hàm xóa tất cả các radio buttons
//     function clearRadioButtons() {
//         var radioButtons = document.querySelectorAll('input[name="typeDownload"]');
//         radioButtons.forEach(function(radioButton) {
//             radioButton.parentNode.remove();
//         });
//     }

//     // Hàm tạo một dashlane-rid ngẫu nhiên (chỉ mô phỏng)
//     function generateDashlaneRid() {
//         return Math.random().toString(36).substr(2, 10);
//     }

//     // Lấy ra tất cả các liên kết trong .sidenav
//     var links = document.querySelectorAll(".sidenav a");

//     // Xử lý sự kiện click cho mỗi liên kết
//     links.forEach(function(link) {
//         link.addEventListener("click", function(event) {
//             // Loại bỏ lớp selected từ tất cả các liên kết
//             links.forEach(function(link) {
//                 link.classList.remove("selected");
//             });

//             // Thêm lớp selected cho liên kết được click
//             event.target.classList.add("selected");
//         });
//     });
// });

$(document).ready(function () {
    // Lấy ra tất cả các ID cần thao tác
    var freepik = document.getElementById("Freepik");
    var envato = document.getElementById("Envato");
    var pikbest = document.getElementById("Pikbest");
    var motionarray = document.getElementById("MotionArray");
    var lovepik = document.getElementById("Lovepik");
    var pngtree = document.getElementById("Pngtree");
    var artlist = document.getElementById("Artlist");
    var flaticon = document.getElementById("Flaticon");
    var storyblock = document.getElementById("Storyblock");
    var vecteezy = document.getElementById("Vecteezy");
    var adobestock = document.getElementById("AdobeStock");

    // Lấy ra các form-group tương ứng
    var freepikContent = document.getElementById("freepikContent");
    var envatoContent = document.getElementById("envatoContent");
    var pikbestContent = document.getElementById("pikbestContent");
    var motionContent = document.getElementById("motionContent");
    var lovepikContent = document.getElementById("lovepikContent");
    var pngtreeContent = document.getElementById("pngtreeContent");
    var artlistContent = document.getElementById("artlistContent");
    var flaticonContent = document.getElementById("flaticonContent");
    var storyblocksContent = document.getElementById("storyblocksContent");
    var vecteezyContent = document.getElementById("vecteezyContent");
    var adobestockContent = document.getElementById("adobestockContent");

    // Đối tượng chứa thông tin về các ID và các lựa chọn tương ứng
    var options = {
        "Freepik": [
            { value: "image", label: "JPG/PSD/AI" },
            { value: "video", label: "VIDEO" }
        ],
        "Envato": [
            { value: "nolicense", label: "FILE" },
            { value: "license", label: "LICENSE" }
        ],
        "Motion": [
            { value: "nolicense", label: "FILE" },
            { value: "license", label: "LICENSE" }
        ],
        "Artlist": [
            { value: "nolicense", label: "MUSIC/VIDEO" },
            { value: "license", label: "LICENSE" }
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
            idOptions.forEach(function (option) {
                radioButtonsHTML += `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="typeDownload" value="${option.value}" data-dashlane-rid="${generateDashlaneRid()}" data-form-type="">
                        <label class="form-check-label">${option.label}</label>
                    </div>
                `;
            });
            radioButtonsHTML += '</div>';

            var messageInputContainer = document.querySelector(".message-input-container");
            messageInputContainer.insertAdjacentHTML('afterend', radioButtonsHTML);
        }
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
    $(document).on('click', '#Motion', function () {
        handleIDClick("Motion");
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
        freepikContent.style.display = "none";
        envatoContent.style.display = "none";
        pikbestContent.style.display = "none";
        motionContent.style.display = "none";
        lovepikContent.style.display = "none";
        pngtreeContent.style.display = "none";
        artlistContent.style.display = "none";
        flaticonContent.style.display = "none";
        storyblocksContent.style.display = "none";
        vecteezyContent.style.display = "none";
        adobestockContent.style.display = "none";
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