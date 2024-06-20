@extends('layout.main')
@push('styles')
@endpush
@push('scripts')
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('AlertDownloadedSuccessfullyChannel');
        channel.bind('AlertDownloadedSuccessfullyEvent', function(data) {
            let user = JSON.parse(localStorage.getItem('user'));
            let loading = $('#submit-code-loading');
            let text = $('#submit-code-text');
            text.addClass('d-none');
            loading.removeClass('d-none');

            if (user && user.id == data.userId) {
                text.removeClass('d-none');
                loading.addClass('d-none');
                // $('#btn-clode-all-modal').click();
                // display result url
                let url = data.url;
                $('.url').text(url);
                $('.btn-open-modal-result').click();
                // set url download
                $('.btn-download').prop('href', url);
                window.open(`${url}`, '_blank').focus();
                // reset
                $('#reset_btn').click();
            }
        });

        var website = '';

        var WEB_TYPE = [
            'Freepik',
            'Envato',
            'AdobeStock',
            'Pikbest',
            'Pngtree',
            'Motionarray',
            'Lovepik',
            'Artlist',
            'Storyblocks',
            'Vecteezy',
            'Flaticon',
            'Creativefabrica',
            'Yayimage',
            'Slidesgo',
        ];

        $(document).on('click', '#reset_btn', function() {
            $('#messageInput').val('');
            $('#notification').css('display', 'none');
            $('.option-website').removeClass('active');
            website = '';
        });

        $(document).on('click', '.option-website', function() {
            event.preventDefault();
            let status = $(this).data('status');
            if (status == 0) {
                toastr.error('Website đang bảo trì! Hãy chọn website khác.');
                return;
            }
            let id = $(this).data('id');
            website = id;
            $('.option-website').removeClass('active');
            $(this).addClass('active');
            //
            handleIDClick(id);
            resetForm();
        });

        $(document).ready(function() {
            // default
            // $('#Freepik').click();
            $('.btn-open-modal-notification').click();
            //
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
                link = link.replace(/\?fbclid.*/, '').replace(/#.*/, '');

                // Kiểm tra xem input có giá trị không
                if (link === '') {
                    showNotification('Vui lòng nhập link vào trước khi sử dụng chức năng tải file.',
                        'alert-warning');
                    return;
                }

                // Kiểm tra URL hiện tại và xác định giá trị của website
                if (!WEB_TYPE.includes(website)) {
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
                    case 'Motionarray':
                        urlPattern = /motionarray\.com\/.*/;
                        break;
                    case 'Lovepik':
                        urlPattern = /lovepik\.com\/.*/;
                        break;
                    case 'Artlist':
                        urlPattern = /artlist\.io\/.*/;
                        break;
                    case 'Storyblocks':
                        urlPattern = /storyblocks\.com\/.*/;
                        break;
                    case 'Vecteezy':
                        urlPattern = /vecteezy\.com\/.*/;
                        break;
                    case 'Flaticon':
                        urlPattern = /flaticon\.com\/.*/;
                        break;
                    case 'Creativefabrica':
                        urlPattern = /creativefabrica\.com\/.*/;
                        break;
                    case 'Yayimage':
                        urlPattern = /yayimages\.com\/.*/;
                        break;
                    case 'Slidesgo':
                        urlPattern = /slidesgo\.com\/.*/;
                        break;
                    case 'Artlist':
                        urlPattern = /artlist\.io\/.*/;
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
                var idFile = '';
                switch (website) {
                    case 'Vecteezy':
                        if (link.length == 0 || link.indexOf(
                                'https://www.vecteezy.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning');
                        }
                        if (!/\/vector-art\//.test(link)) {
                            return showNotification('Không tải được file không hỗ trợ!', 'alert-warning');
                        }
                        break;
                    case 'Storyblocks':
                        if (link.length == 0 || link.indexOf(
                                'https://www.storyblocks.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning');
                        }
                        if (!/\/video\/|\/audio\/|\/images\//.test(link)) {
                            return showNotification('Không tải được file không hỗ trợ!', 'alert-warning');
                        }
                        break;
                    case 'Pikbest':
                        if (link.length == 0 || link.indexOf(
                                'https://pikbest.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning');
                        }
                        break;
                    case 'Flaticon':
                        if (link.length == 0 || link.indexOf(
                                'https://www.flaticon.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning');
                        }
                        if (/\/pack|stickers-pack/.test(link)) {
                            return showNotification('Không tải được file không hỗ trợ', 'alert-warning');
                        }
                        break;
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
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        if (link.indexOf('premium-video') != -1 && $(
                                "input[name=typeDownload]:checked").val() != 'video') {
                            return showNotification('Vui lòng chọn video', 'alert-warning')
                        }
                        break;
                    case 'Envato':
                        if (link.length == 0 || link.indexOf(
                                'https://elements.envato.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Motionarray':
                        if (link.length == 0 || link.indexOf(
                                'https://motionarray.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Lovepik':
                        if (link.length == 0 || link.indexOf(
                                'https://lovepik.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Pngtree':
                        if (link.length == 0 || link.indexOf(
                                'https://pngtree.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Creativefabrica':
                        if (link.length == 0 || link.indexOf(
                                'https://www.creativefabrica.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Yayimage':
                        if (link.length == 0 || link.indexOf(
                                'https://yayimages.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Slidesgo':
                        if (link.length == 0 || link.indexOf(
                                'https://slidesgo.com/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        break;
                    case 'Artlist':
                        if (link.length == 0 || link.indexOf(
                                'https://artlist.io/') == -1) {
                            return showNotification(`Vui lòng nhập link ${website}`, 'alert-warning')
                        }
                        //

                        let typeDownload = $('input[name="typeDownload"]:checked').val();
                        let typeRequired = [
                            'Final',
                            'After',
                            'Premiere',
                            'Davinci',
                        ];
                        if (!typeRequired.includes(typeDownload) &&
                            link.includes('video-templates/')
                        ) {
                            return showNotification('Vui lòng chọn ít nhất 1 loại file:' + typeRequired
                                .join(','),
                                'alert-warning');
                        }

                        break;
                    default:
                        // Điều chỉnh cách lấy idFile cho các website khác ở đây
                        showNotification('Chức năng tải file từ ' + website + ' chưa được hỗ trợ.',
                            'alert-warning');
                        return;
                }

                // Gửi request đến API để tải file
                let typeDownload = '';
                let typeWeb = '';

                const loading = $('#submit-code-loading');
                const text = $('#submit-code-text');
                text.addClass('d-none');
                loading.removeClass('d-none');
                $.ajax({
                    type: "POST",
                    data: {
                        id: user.id,
                        text: link,
                        typeDownload: $('input[name="typeDownload"]:checked').val(),
                        typeWeb: website,
                    },
                    url: "/api/sendMessage",
                    success: function(response) {
                        if (response.status == 0) {
                            toastr.success(
                                'Tải thành công! Bạn sẽ nhận được link tải sau vài giây!',
                                "Thông báo");
                        } else {
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                            toastr.error(response.message, "Thông báo");
                        }
                    },
                });

                // Hàm hiển thị thông báo
                function showNotification(message, alertClass) {
                    $('#notification').removeClass().addClass('alert').addClass(alertClass).text(message)
                        .show();
                }
            });
        });

        // Đối tượng chứa thông tin về các ID và các lựa chọn tương ứng
        var options = {
            "Freepik": [{
                    value: "image",
                    label: "JPG/PSD/AI"
                },
                {
                    value: "video",
                    label: "VIDEO"
                }
            ],
            "Envato": [{
                    value: "file",
                    label: "FILE"
                },
                {
                    value: "license",
                    label: "LICENSE"
                }
            ],
            "Motionarray": [{
                    value: "file",
                    label: "FILE"
                },
                {
                    value: "license",
                    label: "LICENSE"
                }
            ],
            "Lovepik": [{
                    value: "image",
                    label: "JPG/PSD/AI"
                },
                {
                    value: "video",
                    label: "VIDEO"
                }
            ],
            "Artlist": [{
                    value: "license",
                    label: "LICENSE"
                },
                {
                    value: "Music",
                    label: "MUSIC/VIDEO"
                },
                {
                    value: "Final",
                    label: "FinalCut"
                },
                {
                    value: "After",
                    label: "After Effect"
                },
                {
                    value: "Premiere",
                    label: "Premiere Pro"
                },
                {
                    value: "Davinci",
                    label: "Davinci"
                }
            ],
            "Yayimage": [{
                    value: "file",
                    label: "FILE"
                },
                {
                    value: "video",
                    label: "VIDEO"
                }
            ],
        };

        // Xử lý sự kiện click trên các ID
        function handleIDClick(id) {
            console.log(id);
            // Ẩn tất cả các form-group trước khi hiển thị nội dung mới
            $('.block-content').css('display', 'none');
            // Hiển thị nội dung của ID được click
            $(`#${id}Content`).css('display', 'block');

            // Xóa tất cả các radio buttons cũ
            clearRadioButtons();

            // Thêm radio buttons mới cho ID được click
            var idOptions = options[id];
            if (idOptions) {
                var radioButtonsHTML = '<div style="text-align: center;">';
                let i = 0;
                idOptions.forEach(function(option) {
                    radioButtonsHTML += `
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" ${i == 0 ? 'checked' : ''} type="radio" name="typeDownload" value="${option.value}" data-dashlane-rid="${generateDashlaneRid()}" id="${id}${option.value}" data-form-type="">
                        <label class="form-check-label" for="${id}${option.value}">${option.label}</label>
                    </div>
                `;
                    i = 1;
                });
                radioButtonsHTML += '</div>';

                $('.message-input-container').append(radioButtonsHTML);
            }
        }

        function resetForm() {
            $('#messageInput').val('');
            $('#notification').css('display', 'none');
        }

        // Hàm xóa tất cả các radio buttons
        function clearRadioButtons() {
            var radioButtons = document.querySelectorAll('input[name="typeDownload"]');
            radioButtons.forEach(function(radioButton) {
                radioButton.parentNode.remove();
            });

            // $('input[name="typeDownload"]').parentNode.remove();
        }

        // Hàm tạo một dashlane-rid ngẫu nhiên (chỉ mô phỏng)
        function generateDashlaneRid() {
            return Math.random().toString(36).substr(2, 10);
        }

        // Lấy ra tất cả các liên kết trong .sidenav
        var links = document.querySelectorAll(".sidenav a");

        // Xử lý sự kiện click cho mỗi liên kết
        links.forEach(function(link) {
            link.addEventListener("click", function(event) {
                // Loại bỏ lớp selected từ tất cả các liên kết
                links.forEach(function(link) {
                    link.classList.remove("selected");
                });

                // Thêm lớp selected cho liên kết được click
                event.target.classList.add("selected");
            });
        });
    </script>
@endpush
@section('content')
    <div class="container">
        <h1 class="title">CHỌN WEBSITE CẦN TẢI</h1>
        <hr class="separator">
        <div class="option-switcher">
            @foreach ($websites as $website)
                <div class="option">
                    <div id="{{ $website->code }}" class="option-website" data-sample_link="{{ $website->sample_link }}"
                        data-id="{{ $website->code }}" data-website_link="{{ $website->website_link }}"
                        data-status="{{ $website->status }}"><img style="width: 16px;height:16px"
                            src="{{ $website->image }}" alt="{{ $website->code }} Icon">{{ $website->name }}</div>
                </div>
            @endforeach
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
                                <span id="submit-code-loading"
                                    class="d-none spinner-border spinner-border-sm spinner"></span>
                                <span id="submit-code-text" class="text">DOWNLOAD</span>
                            </button>
                            <button data-dashlane-rid="7df0e654d6340e33" id="reset_btn"
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

                        @foreach ($websites as $website)
                            <div class="block-content" id="{{ $website->code }}Content" style="display: none;">
                                <div class="form-group">
                                    <h6 for="freepikLink">HƯỚNG DẪN TẢI <span
                                            class="website-name">{{ strtoupper($website->code) }}</span>:</h6>
                                    <p>
                                        - <span class="highlight">Bước 1:</span> Truy cập <span
                                            class="website-link">{{ $website->website_link }}</span> và tìm kiếm File cần
                                        tải<br>
                                        - <span class="highlight">Bước 2:</span> Copy link của File có dạng sau:
                                    </p>
                                    <blockquote>
                                        <p class="website-sample">
                                            {{ $website->sample_link }}
                                        </p>
                                    </blockquote>
                                    - <span class="highlight">Bước 3:</span> Dán link vào ô bên cạnh và bấm Download<br>
                                    <br>
                                    <hr>File sẽ được <span class="bold">tự động tải xuống</span>. Nếu
                                    không bạn hãy bấm vào link bên dưới để tải lại nha!
                                    <p></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalResult" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Link tải</h4>
                    <button type="button" class="closeModalResult close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="url" style="font-style:italic;color:orange">Link tải</p>
                    <a style="float: right;" href="#" target="_blank" download
                        class="btn-download btn btn-sm btn-success"><i class="fa-solid fa-download"></i></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalNotification" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="closeModalNotification close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    @if (!empty($settings['popup-image']))
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <img src="{{ $settings['popup-image'] ?? '' }}" alt="Image" style="width: 100%" />
                            </div>
                        </div>
                    @endif
                    @if (!empty($settings['popup-text']))
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! $settings['popup-text'] ?? '' !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="btn-open-modal-result" data-target="#modalResult" data-toggle="modal" />
    <input type="hidden" class="btn-open-modal-notification" data-target="#modalNotification" data-toggle="modal" />
@endsection
