@extends('layout.main')
@push('styles')
    <title>TẢI FILE FREEPIK GIÁ RẺ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
@endpush
@push('scripts')
    {{-- <script src="/js/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/index.js"></script>
    <script src="/js/content.js"></script>
    <script>
        function selectOption(id, event) {
            event.preventDefault();
            var options = document.querySelectorAll('.option div');
            options.forEach(function(option) {
                option.classList.remove('active');
            });
            document.getElementById(id).classList.add('active');

            // Replace 'your_url_here' with the actual URL corresponding to the selected option
            var url = ''; // Add URL corresponding to the selected option
            window.location.href = url + '#' + id;
        }

        // Optional: Highlight the initially selected option based on URL hash
        var hash = window.location.hash.substr(1);
        if (hash) {
            document.getElementById(hash).classList.add('active');
        }

        function goToHomePage() {
            // Replace '/' with the actual URL of your home page
            window.location.href = '/';
        }

        function showLoginModal() {
            var modal = document.getElementById('loginModal');
            modal.classList.toggle('active');
        }

        $(document).on('click', '.btn-login', function() {
            $.ajax({
                type: "POST",
                data: {
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                url: "/api/auth/login",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success(response.message, "Thông báo");
                        closeModal('modalLogin');
                        localStorage.setItem('user', JSON.stringify(response.user));
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        });

        function closeModal(id) {
            $("#" + id).css("display", "none");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        }
        $(document).ready(function() {
            $('#getlink_btn').click(function() {
                // Kiểm tra xem userID đã đăng nhập chưa
                let user = localStorage.getItem('user');
                if (!user) {
                    // Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập trước khi sử dụng chức năng
                    showNotification('Vui lòng đăng nhập trước khi sử dụng chức năng.', 'alert-danger');
                    return;
                }

                $('#notification').css('display', 'none'); // Ẩn khung nếu không có dữ liệu
                // Lấy giá trị userId từ phần tử có id="userInfo"
                user = JSON.parse(user);
                var userId = user.id;

                // Lấy giá trị từ input có id="messageInput"
                var link = $('#messageInput').val().trim();

                // Kiểm tra xem input có giá trị không
                if (link === '') {
                    showNotification('Vui lòng nhập link vào trước khi sử dụng chức năng tải file.',
                        'alert-warning');
                    return;
                }

                // Lấy base URL của trang web hiện tại
                var currentUrl = window.location.href;
                var baseUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/') + 1);

                // Kiểm tra URL hiện tại và xác định giá trị của website
                var website = '';
                var fragment = currentUrl.split('#')[1];
                if (fragment === 'Freepik' || fragment === 'Envato' || fragment === 'AdobeStock' ||
                    fragment === 'Pikbest' || fragment === 'Pngtree' || fragment === 'MotionArray' ||
                    fragment === 'Lovepik' || fragment === 'Artlist' || fragment === 'Storyblock' ||
                    fragment === 'Vecteezy' || fragment === 'Flaticon') {
                    website = fragment;
                } else {
                    showNotification('Vui lòng chọn website cần tải.', 'alert-warning');
                    return;
                }

                // Kiểm tra xem link có phải là URL hợp lệ của website đã chọn không
                var urlPattern;
                switch (website) {
                    case 'Freepik':
                        urlPattern = /freepik\.com\/.*/;
                        break;
                    case 'Envato':
                        urlPattern = /envato\.com\/.*/;
                        break;
                    case 'AdobeStock':
                        urlPattern = /stock\.adobe\.com\/.*/;
                        break;
                    case 'Pikbest':
                        urlPattern = /pikbest\.com\/.*/;
                        break;
                    case 'Pngtree':
                        urlPattern = /pngtree\.com\/.*/;
                        break;
                    case 'MotionArray':
                        urlPattern = /motionarray\.com\/.*/;
                        break;
                    case 'Lovepik':
                        urlPattern = /lovepik\.com\/.*/;
                        break;
                    case 'Artlist':
                        urlPattern = /artlist\.io\/.*/;
                        break;
                    case 'Storyblock':
                        urlPattern = /storyblocks\.com\/.*/;
                        break;
                    case 'Vecteezy':
                        urlPattern = /vecteezy\.com\/.*/;
                        break;
                    case 'Flaticon':
                        urlPattern = /flaticon\.com\/.*/;
                        break;
                    default:
                        showNotification('Website không hợp lệ.', 'alert-warning');
                        return;
                }
                if (!urlPattern.test(link)) {
                    showNotification('Link không hợp lệ cho website ' + website +
                        '. Vui lòng kiểm tra lại.', 'alert-warning');
                    return;
                }

                // Kiểm tra xem link có chứa idFile không
                var idFile;
                console.log(website);
                switch (website) {
                    case 'AdobeStock':
                        var idFilePatternOption1 = /asset_id=(\d+)/g; // Option 1
                        var idFilePatternOption2 = /\/(\d+)(?:\?|$)/; // Option 2

                        var matchOption1 = idFilePatternOption1.exec(link);
                        var matchOption2 = idFilePatternOption2.exec(link);

                        if (matchOption1 !== null) {
                            idFile = matchOption1[1];
                        } else if (matchOption2 !== null) {
                            idFile = matchOption2[1];
                        } else {
                            showNotification('Không tìm thấy idFile trong link. Vui lòng kiểm tra lại.',
                                'alert-warning');
                            return;
                        }
                        break;
                    case 'Freepik':
                        if (link.length == 0 || link.indexOf(
                                'https://www.freepik.com/') == -1) {
                            return showNotification('Vui lòng nhập link freepik', 'alert-warning')
                        }
                        if (link.indexOf('premium-video') != -1 && $(
                                "input[name=typeDownload]:checked").val() != 'video') {
                            return showNotification('Vui lòng chọn video', 'alert-warning')
                        }
                        break;

                    default:
                        // Điều chỉnh cách lấy idFile cho các website khác ở đây
                        showNotification('Chức năng tải file từ ' + website + ' chưa được hỗ trợ.',
                            'alert-warning');
                        return;
                }

                // Gửi request đến API để tải file
                var intervalGetUrl = null;
                $.ajax({
                    type: "POST",
                    data: {
                        id: user.id,
                        text: link,
                    },
                    url: "/api/sendMessage",
                    success: function(response) {
                        if (response.status == 0) {
                            toastr.success('Tải thành công', "Thông báo");
                            intervalGetUrl = setInterval(async () => {
                                let result = await getCacheById(user.id);
                                if (result.status == 0) {
                                    if (result.data) {
                                        // display result url
                                        let url = result.data.url;
                                        $('.btn-open-modal-result').click();
                                        $('.url').text(url);
                                        // stop call get ur
                                        clearInterval(intervalGetUrl);
                                    }
                                } else {
                                    // return error
                                    toastr.error(response.message, "Thông báo");
                                    // stop call get ur
                                    clearInterval(intervalGetUrl);
                                }
                            }, 4000);
                        } else {
                            toastr.error(response.message, "Thông báo");
                        }
                    },
                });


                async function getCacheById(id) {
                    let result = null;
                    let formData = new FormData();
                    formData.append('id', id);
                    await $.ajax({
                        method: "POST",
                        url: `/api/getCacheById`,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            result = response;
                        }
                    })

                    return result;
                }

                // Hàm hiển thị thông báo
                function showNotification(message, alertClass) {
                    $('#notification').removeClass().addClass('alert').addClass(alertClass).text(message)
                        .show();
                }
            });
        });
    </script>
@endpush
@section('content')
    <div class="container">
        <h1 class="title">CHỌN WEBSITE CẦN TẢI</h1>
        <hr class="separator">
        <div class="option-switcher">
            <div class="option">
                <div id="Freepik" onclick="selectOption('Freepik', event)"><img src="/asset/freepik.png"
                        alt="Freepik Icon">Freepik</div>
            </div>
            <div class="option">
                <div id="Envato" onclick="selectOption('Envato', event)"><img src="/asset/envato.png"
                        alt="Envato Icon">Envato Elements</div>
            </div>
            <div class="option">
                <div id="AdobeStock" onclick="selectOption('AdobeStock', event)"><img src="/asset/adobestock.png"
                        alt="Adobe Stock Icon">Adobe Stock</div>
            </div>
            <div class="option">
                <div id="Pikbest" onclick="selectOption('Pikbest', event)"><img src="/asset/pikbest.png"
                        alt="Pikbest Icon">Pikbest</div>
            </div>
            <div class="option">
                <div id="MotionArray" onclick="selectOption('MotionArray', event)"><img src="/asset/motionarray.png"
                        alt="Motion Array Icon">Motion Array</div>
            </div>
            <div class="option">
                <div id="Lovepik" onclick="selectOption('Lovepik', event)"><img src="/asset/lovepik.png"
                        alt="Lovepik Icon">Lovepik</div>
            </div>
            <div class="option">
                <div id="Pngtree" onclick="selectOption('Pngtree', event)"><img src="/asset/pngtree.png"
                        alt="Pngtree Icon">Pngtree</div>
            </div>
            <div class="option">
                <div id="Artlist" onclick="selectOption('Artlist', event)"><img src="/asset/artlist.png"
                        alt="Artlist Icon">Artlist</div>
            </div>
            <div class="option">
                <div id="Storyblock" onclick="selectOption('Storyblock', event)"><img src="/asset/storyblocks.png"
                        alt="Storyblocks Icon">Storyblocks</div>
            </div>
            <div class="option">
                <div id="Vecteezy" onclick="selectOption('Vecteezy', event)"><img src="/asset/vecteezy.png"
                        alt="Vecteezy Icon">Vecteezy</div>
            </div>
            <div class="option">
                <div id="Flaticon" onclick="selectOption('Flaticon', event)"><img src="/asset/flaticon.png"
                        alt="Flaticon Icon">Flaticon</div>
            </div>
        </div>

    </div>
    <div class="main-content">
        <!-- Your main content here -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4" style="height: 416px;">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">GETLINK HERE!</h6>
                    </div>
                    <div class="card-body" data-dashlane-rid="d3558ec42fb066ad" data-form-type="">

                        <div class="form-group message-input-container">
                            <label for="messageInput">Dán link cần tải vào ô bên dưới và nhấn nút Download:</label>
                            <textarea class="form-control message-input" id="messageInput" spellcheck="false" data-dashlane-rid="1518be2f631a0d2d"
                                style="height: 114px;" data-form-type=""></textarea>
                        </div>
                        <div class="form-group" style="text-align: center;">
                            <button class="btn btn-lg btn-outline-info btn-getlink" id="getlink_btn"
                                data-dashlane-rid="4f12969a7bd7df33" data-dashlane-label="true" data-form-type="">
                                <span class="text">DOWNLOAD</span>
                            </button>
                            <button data-dashlane-rid="7df0e654d6340e33" id="reset_btn" onclick="resetForm()"
                                class="btn btn-lg btn-outline-warning btn-getlink" data-dashlane-label="true"
                                data-form-type="">
                                <span class="text">RESET</span>
                            </button>
                        </div>

                        <div class="m-separator m-separator--dashed"></div>
                        <div id="notification" class="alert alert-info" style="display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">HƯỚNG DẪN!</h6>
                    </div>

                    <div class="card-body overflow-auto" style="height: 363px;">

                        <div id="freepikContent" style="display: block;">
                            <div class="form-group">
                                <h6 for="freepikLink">HƯỚNG DẪN TẢI FREEPIK:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập Freepik.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://www.freepik.com/premium-psd/night-club-party-facebook-timeline-covers_58866770.htm
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="envatoContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="envatoLink">HƯỚNG DẪN TẢI ENVATO ELEMENTS:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập elements.envato.com và tìm kiếm File
                                    cần tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://elements.envato.com/space-digital-introduction-VKUJEG2</p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="pikbestContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="pikbestLink">HƯỚNG DẪN TẢI PIKBEST:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập pikbest.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://pikbest.com/png-images/red-text-selamat-hari-raya-idul-fitri-with-mosque-sign-and-eid-mubarak_9997330.html
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="motionContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="motionLink">HƯỚNG DẪN TẢI MOTION ARRAY:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập motionarray.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://motionarray.com/after-effects-templates/colorful-3d-social-media-intro-2384008/
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="lovepikContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="lovepikLink">HƯỚNG DẪN TẢI LOVEPIK:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập lovepik.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://lovepik.com/image-466080622/seaside-simple-pink-summer-promotion-web-ui.html
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="pngtreeContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="pngtreeLink">HƯỚNG DẪN TẢI PNGTREE:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập pngtree.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://pngtree.com/freepng/original-national-tide-wind-carp-leaping-dragon-gate-illustration-poster_7462378.html
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="artlistContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="artlistLink">HƯỚNG DẪN TẢI ARTLIST:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập artlist.io và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://artlist.io/royalty-free-music/song/freeze/88709</p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="flaticonContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="flaticonLink">HƯỚNG DẪN TẢI FLATICON:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập flaticon.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://www.flaticon.com/free-icon-font/address-card_9821470</p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->Flaticon hiện tại chỉ hỗ trợ tải icon lẻ dạng SVG. Sau khi File
                                được tự động mở ở tab mới, bạn hãy mở chuột phải và Save as lại dạng SVG là xong nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="storyblocksContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="storyblocksLink">HƯỚNG DẪN TẢI STORYBLOCKS:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập storyblocks.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://www.storyblocks.com/video/stock/view-of-black-quadcopter-with-camera-flying-on-background-of-nature-soa8cvgnwj8ar2lso
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="vecteezyContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="vecteezyLink">HƯỚNG DẪN TẢI VECTEEZY:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập vecteezy.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://www.vecteezy.com/vector-art/1255564-abstract-geometric-triangle-seamless-pattern
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                        <div id="adobestockContent" style="display: none;">
                            <div class="form-group">
                                <h6 for="adobestockLink">HƯỚNG DẪN TẢI ADOBE STOCK:</h6>
                                <p>
                                    - <span class="highlight">Bước 1:</span> Truy cập stock.adobe.com và tìm kiếm File cần
                                    tải<br>
                                    - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                </p>
                                <blockquote>
                                    <p>https://stock.adobe.com/vn/images/3d-render-abstract-background-with-colorful-spectrum-bright-neon-rays-and-glowing-lines/411360907?prev_url=detail&amp;asset_id=461089776
                                    </p>
                                </blockquote>
                                - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                <br>
                                <hr> <!-- Thanh ngang -->File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                không bạn hãy bấm vào link bên dưới để tải lại nha!
                                <p></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalResult" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Link tải</h4>
                    <button type="button" class="closeModalResult close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="url" style="font-style:italic;color:orange">Link tải</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="btn-open-modal-result" data-target="#modalResult" data-toggle="modal" />
@endsection
