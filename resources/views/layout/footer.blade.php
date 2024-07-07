<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span style="color: rgb(196, 1, 26);font-weight: 700;"><a target="__blank"
                    href="https://t.me/DownloadFileSupport">Channel
                    Hỗ trợ telegram</a></span><br><br>
            <span>Copyright © Premium Download Services </span>
        </div>
        <div class="m-separator m-separator--dashed"></div>
        <span class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search filename"
            style="font-weight: 700;">
            <marquee scrollamount="10">ĐÂY LÀ BẢN THỬ NGHIỆM. NẾU CÓ BẤT KÌ LỖI NÀO VUI LÒNG BÁO QUẢN TRỊ VIÊN ĐỂ ĐƯỢC
                HỖ TRỢ KỊP THỜI</marquee>
        </span>
    </div>
    @if (request()->route()->getName() === 'home')
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Từ khóa tìm kiếm</h6>
                    </div>
                    <div class="card-body">
                        <ul class="tags">
                            <li><a href="#getlink-%s" data-url="Get link %s" class="tag">Get link </a></li>
                            <li><a href="#%s-mien-phi" data-url="%s Free" class="tag"> Free</a>
                            </li>
                            <li><a href="#%s-mien-phi" data-url="%s Free" class="tag"> Free</a>
                            </li>
                            <li><a href="#getlink-%s-free" data-url="%s Free" class="tag">Get link Free</a></li>
                            <li><a href="#getlink-%s-free" data-url="%s Free" class="tag">Get link miễn phí</a>
                            </li>
                            <li><a href="#%s-free" data-url="%s Free" class="tag"> free</a></li>
                            <li><a href="#%s-mien-phi" data-url="%s Free" class="tag"> mien phi</a></li>
                            <li><a href="#%s-mien-phi" class="tag" data-url="leech %s">leech </a></li>
                            <li><a href="#%s-mien-phi" class="tag" data-url="%s download"> download</a></li>
                            <li><a href="#%s-mien-phi" class="tag" data-url="%s tai mien phi"> tai mien phi</a>
                            </li>
                            <li><a href="#%s-gia-re" class="tag" data-url="%s giá rẻ"> giá rẻ</a></li>
                            <li><a href="#%s-gia-re-nhat-the-gioi" class="tag" data-url="%s giá rẻ nhất thế giới">
                                    giá rẻ nhất thế giới</a></li>
                            <li><a href="#%s-gia-4000-dong" class="tag" data-url="%s giá 4000 đồng"> giá 4000
                                    đồng</a></li>
                            <li><a href="#tai-hinh-%s" class="tag" data-url="tai hinh %s">tai hinh </a></li>
                            <li><a href="#-tải-hình-%s" class="tag" data-url="tải hình %s"> tải hình </a></li>
                            <li><a href="#-get-hình-%s" class="tag" data-url="get hình %s"> get hình </a></li>
                            <li><a href="#-get-ảnh-%s" class="tag" data-url="get ảnh %s"> get ảnh </a></li>
                            <li><a href="#-tải-%s" class="tag" data-url="tải %s"> tải </a></li>
                            <li><a href="#-get-%s" class="tag" data-url="get %s"> get </a></li>
                            <li><a href="#-get-premium-%s" class="tag" data-url="get premium %s"> get premium </a>
                            </li>
                            <li><a href="#-trang-get-%s" class="tag" data-url="trang get %s"> trang get </a></li>
                            <li><a href="#-get-link-%s" class="tag" data-url="get link %s"> get link </a></li>
                            <li><a href="#-download-%s" class="tag" data-url="download %s"> download </a></li>
                            <li><a href="#-free-%s" class="tag" data-url="free %s"> free </a></li>
                            <li><a href="#-%s-download" class="tag" data-url="%s download"> download</a></li>
                            <li><a href="#-download-%s-free" class="tag" data-url="download %s free"> download
                                    free</a></li>
                            <li><a href="#-mua-hình-%s" class="tag" data-url="mua hình %s"> mua hình </a></li>
                            <li><a href="#-get-link-%s" class="tag" data-url="get link %s"> get link </a></li>
                            <li><a href="#-get-link-%s" class="tag" data-url="get link %s"> get link </a></li>
                            <li><a href="#-get-%s-premium" class="tag" data-url="get %s premium"> get
                                    premium</a></li>
                            <li><a href="#-get-link-premium-%s" class="tag" data-url="get link premium %s"> get
                                    link premium </a></li>
                            <li><a href="#-download-%s-without-watermark" class="tag" data-url="download %s without watermark"> download
                                    without
                                    watermark</a></li>
                            <li><a href="#-tải-ảnh-%s" class="tag" data-url="tải ảnh %s"> tải ảnh </a></li>
                            <li><a href="#-tải-ảnh-%s-miễn-phí" class="tag" data-url="tải ảnh %s miễn phí"> tải
                                    ảnh %s miễn phí</a></li>
                            <li><a href="#-download-free-%s" class="tag" data-url="download free %s"> download
                                    free </a></li>
                            <li><a href="#-get-link-%s-free" class="tag" data-url="get link %s free"> get link
                                    free</a></li>
                            <li><a href="#-%s-free-download" class="tag" data-url="%s free download"> free
                                    download</a></li>
                            <li><a href="#-%s-downloader" class="tag" data-url="%s downloader"> downloader</a>
                            </li>
                            <li><a href="#-mua-ảnh-%s" class="tag" data-url="mua ảnh %s"> mua ảnh </a></li>
                            <li><a href="#-tải-vector-miễn-phí" class="tag" data-url="tải vector miễn phí"> tải
                                    vector miễn phí</a></li>
                            <li><a href="#-get-image-%s" class="tag" data-url="get image %s"> get image </a>
                            </li>
                            <li><a href="#-get-link-%s-premium" class="tag" data-url="get link %s premium"> get
                                    link premium</a></li>
                            <li><a href="#-lấy-ảnh-từ-%s" class="tag" data-url="lấy ảnh từ %s"> lấy ảnh từ </a>
                            </li>
                            <li><a href="#-cách-tải-ảnh-từ-%s" class="tag" data-url="cách tải ảnh từ %s"> cách tải
                                    ảnh từ </a></li>
                            <li><a href="#-cách-lấy-hình-trên-%s" class="tag" data-url="cách lấy hình trên %s">
                                    cách lấy hình trên </a></li>
                            <li><a href="#-download-%s-miễn-phí" class="tag" data-url="download %s miễn phí">
                                    download miễn phí</a></li>
                            <li><a href="#-mua-hình-trên-%s" class="tag" data-url="mua hình trên %s"> mua hình
                                    trên </a></li>
                            <li><a href="#-tải-hình-%s" class="tag" data-url="tải hình %s"> tải hình </a></li>
                            <li><a href="#-tải-ảnh-từ-%s" class="tag" data-url="tải ảnh từ %s"> tải ảnh từ </a>
                            </li>
                            <li><a href="#-get-link-%s" class="tag" data-url="get link %s"> get link </a></li>
                            <li><a href="#-tải-ảnh-trên-%s" class="tag" data-url="tải ảnh trên %s"> tải ảnh trên
                                    </a></li>
                            <li><a href="#-tải-%s-miễn-phí" class="tag" data-url="tải %s miễn phí"> tải miễn
                                    phí</a></li>
                            <li><a href="#-tải-ảnh-%s-free" class="tag" data-url="tải ảnh %s free"> tải ảnh
                                    free</a></li>
                            <li><a href="#-tải-hình-%s-miễn-phí" class="tag" data-url="tải hình %s miễn phí"> tải
                                    hình miễn phí</a></li>
                            <li><a href="#-download-ảnh-%s" class="tag" data-url="download ảnh %s"> download ảnh
                                    </a></li>
                            <li><a href="#-cách-download-hình-trên-%s-free" class="tag" data-url="cách download hình trên %s free"> cách download
                                    hình trên free</a></li>
                            <li><a href="#-mua-%s" class="tag" data-url="mua %s"> mua </a></li>
                            <li><a href="#-%s-get-link" class="tag" data-url="%s get link"> get link</a></li>
                            <li><a href="#-lấy-hình-từ-%s" class="tag" data-url="lấy hình từ %s"> lấy hình từ
                                    </a></li>
                            <li><a href="#-cách-tải-vector-trên-%s-free" class="tag" data-url="cách "> cách tải
                                    vector trên free</a></li>
                            <li><a href="#-cách-download-ảnh-từ-%s" class="tag" data-url="cách download ảnh từ ">
                                    cách download ảnh từ </a>
                            </li>
                            <li><a href="#-cách-tải-ảnh-%s-miễn-phí" class="tag" data-url="cách tải ảnh %s "> cách
                                    tải ảnh miễn phí</a>
                            </li>
                            <li><a href="#-mua-ảnh-%s" class="tag" data-url="mua ảnh %s"> mua ảnh </a></li>
                            <li><a href="#-tải-%s-free" class="tag" data-url="tải %s free"> tải free</a></li>
                            <li><a href="#-tài-khoản-%s" class="tag" data-url="tài khoản %s"> tài khoản </a>
                            </li>
                            <li><a href="#-free-download-%s" class="tag" data-url="free download %s"> free
                                    download </a></li>
                            <li><a href="#-download-ảnh-chất-lượng-cao" class="tag" data-url="download ảnh chất lượng cao"> download ảnh chất
                                    lượng
                                    cao</a>
                            </li>
                            <li><a href="#-tai-hinh-mien-phi" class="tag" data-url="tai hinh mien phi"> tai hinh
                                    mien phi</a></li>
                            <li><a href="#-mua-ảnh-trên-%s" class="tag" data-url="mua ảnh trên %s"> mua ảnh trên
                                    </a></li>
                            <li><a href="#-mua-tài-khoản-%s" class="tag" data-url="mua tài khoản %s"> mua tài
                                    khoản </a></li>
                            <li><a href="#-mua-ảnh-từ-%s" class="tag" data-url="mua ảnh từ %s"> mua ảnh từ </a>
                            </li>
                            <li><a href="#-getlink-%s" class="tag" data-url="getlink %s"> getlink </a></li>
                            <li><a href="#-tải-ảnh-free-từ-%s" class="tag" data-url="tải ảnh free từ %s"> tải ảnh
                                    free từ </a></li>
                            <li><a href="#-get-link-premium" class="tag" data-url="get link premium"> get link
                                    premium</a></li>
                            <li><a href="#-get-%s-online" class="tag" data-url="get %s online"> get online</a>
                            </li>
                            <li><a href="#-trang-web-tải-ảnh-chất-lượng-cao" class="tag" data-url="trang web tải ảnh chất lượng cao"> trang web
                                    tải ảnh chất
                                    lượng
                                    cao</a></li>
                            <li><a href="#-tai-hinh-dep-mien-phi" class="tag" data-url="tai hinh dep mien phi">
                                    tai hinh dep mien phi</a></li>
                            <li><a href="#-leech-%s" class="tag" data-url="leech %s"> leech </a></li>
                            <li><a href="#-cách-download-miễn-phí-trên-%s" class="tag" data-url="cách download miễn phí trên %s"> cách download miễn phí trên
                                    </a></li>
                            <li><a href="#-mua-ảnh-%s-giá-rẻ" class="tag" data-url="mua ảnh %s giá rẻ"> mua ảnh %s
                                    giá rẻ</a></li>
                            <li><a href="#-get-link-vector-%s" class="tag" data-url="get link vector %s"> get link
                                    vector </a></li>
                            <li><a href="#-cách-mua-hình-trên-%s" class="tag" data-url="cách mua hình trên %s">
                                    cách mua hình trên </a></li>
                            <li><a href="#-mua-hình-ảnh-chất-lượng-cao" class="tag" data-url="mua hình ảnh chất lượng cao"> mua hình ảnh
                                    chất lượng
                                    cao</a>
                            </li>
                            <li><a href="#-cách-mua-ảnh-trên-%s" class="tag" data-url="cách mua ảnh trên %s"> cách
                                    mua ảnh trên </a></li>
                            <li><a href="#-mua-vector-%s" class="tag" data-url="mua vector %s"> mua vector </a>
                            </li>
                            <li><a href="#-tải-hình-vector-miễn-phí" class="tag"
                                    data-url="tải hình vector miễn phí"> tải hình vector miễn phí</a></li>
                            <li><a href="#-get-free-%s" class="tag" data-url="get free %s"> get free </a></li>
                            <li><a href="#-kho-ảnh-chất-lượng-cao-miễn-phí" class="tag" data-url="kho ảnh chất lượng cao miễn phí"> kho ảnh
                                    chất lượng cao
                                    miễn
                                    phí</a></li>
                            <li><a href="#-cách-lấy-ảnh-trên-%s" class="tag" data-url="cách lấy ảnh trên %s"> cách
                                    lấy ảnh trên </a></li>
                            <li><a href="#-get-vector-%s" class="tag" data-url="get vector %s"> get vector </a>
                            </li>
                            <li><a href="#-bán-hình-%s" class="tag" data-url="bán hình %s"> bán hình </a></li>
                            <li><a href="#-tải-%s-miễn-phí" class="tag" data-url="tải %s miễn phí"> tải miễn
                                    phí</a></li>
                            <li><a href="#-download-từ-%s" class="tag" data-url="download từ %s"> download từ
                                    </a></li>
                            <li><a href="#-cách-tải-hình-trên-%s" class="tag" data-url="cách tải hình trên %s">
                                    cách tải hình trên </a></li>
                            <li><a href="#-get-%s-free" class="tag" data-url="get %s free"> get free</a></li>
                            <li><a href="#-mua-ảnh-chất-lượng-cao" class="tag" data-url="mua ảnh chất lượng cao">
                                    mua ảnh chất lượng cao</a></li>
                            <li><a href="#-cách-download-vector-trên-%s" class="tag"
                                    data-url="cách download vector trên %s"> cách
                                    download vector trên
                                    </a></li>
                            <li><a href="#-cách-lấy-ảnh-trên-%s-free" class="tag" data-url="cách lấy ảnh trên %s free"> cách lấy ảnh free</a></li>
                            <li><a href="#-mua-ảnh-trên-%s-giá-rẻ" class="tag" data-url="mua ảnh trên %s giá rẻ">
                                    mua ảnh trên giá rẻ</a></li>
                            <li><a href="#-%s-downloader-online" class="tag" data-url="%s downloader online">
                                    downloader online</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

</footer>
