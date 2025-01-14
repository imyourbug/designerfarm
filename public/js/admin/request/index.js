var dataTable = null;

$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ordering: false,
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: "excel",
                        text: "Xuất Excel",
                        exportOptions: {
                            columns: ":not(:last-child)",
                        },
                    },
                    "colvis",
                ],
            },
            top2Start: 'pageLength',
        },
        ajax: {
            url: `/api/requests/getAll`,
            dataSrc: "requests",
        },
        columns: [
            {
                data: function (d) {
                    return d.user.name;
                },
            },
            {
                data: function (d) {
                    return `<b>${d.content}</b>`;
                },
            },
            {
                data: function (d) {
                    return d.package_detail.package.name;
                },
            },
            {
                data: function (d) {
                    return `${formatCash(d.total)}`;
                },
            },
            {
                data: function (d) {
                    return d.expire;
                },
            },
            {
                data: function (d) {
                    return d.package_detail.package.type == 0 ? 'Tải lẻ' : 'Tải theo tháng hoặc năm';
                },
            },
            {
                data: function (d) {
                    return d.package_detail.package.type == 0 ? 'Không' : d.website_id;
                },
            },
            {
                data: function (d) {
                    return getStatus(d.id, d.website_id || '', d.status);
                },
            },
            {
                data: function (d) {
                    return `<button data-id="${d.id}" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>`;
                },
            },
        ],
    });
});

function getStatus(id = '', website_id = '', status = '') {
    let renderStatus = '';
    switch (true) {
        case status == 0:
            renderStatus = `<div class="btn-group">
                <span class="btn btn-primary">Đang chờ</span>
                <button type="button" class="btn btn-primary btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(67px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a data-id=${id} data-website_id='${website_id}' data-status=${1} class="dropdown-item btn-change-status" href="#">Đã xác nhận</a>
                <a data-id=${id} data-website_id='${website_id}' data-status=${2} class="dropdown-item btn-change-status" href="#">Đã hủy</a>
                </div>
                </div>`;
            break;
        case status == 1:
            renderStatus = '<span class="btn btn-success">Đã xác nhận</span>';
            break;
        case status == 2:
            renderStatus = '<span class="btn btn-danger">Đã hủy</span>';
            break;
        default:
            break;
    }

    return renderStatus;
}

$(document).on("click", ".btn-change-status", function () {
    if (confirm("Bạn có muốn đổi trạng thái?")) {
        let id = $(this).data("id");
        let status = $(this).data("status");
        let website_id = $(this).data("website_id");
        $.ajax({
            type: "POST",
            url: `/api/requests/update`,
            data: {
                id,
                status,
                website_id
            },
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Cập nhật thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete", function () {
    if (confirm("Bạn có muốn xóa?")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/requests/${id}/destroy`,
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

function formatCash(str) {
    str = str.toString();
    if (str && str !== "0") {
        return str
            .split("")
            .reverse()
            .reduce((prev, next, index) => {
                return (index % 3 ? next : next + ".") + prev;
            });
    }

    return str;
}
