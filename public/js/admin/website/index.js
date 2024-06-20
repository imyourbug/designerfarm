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
            url: `/api/websites/getAll`,
            dataSrc: "websites",
        },
        columns: [
            {
                data: function (d) {
                    return d.name;
                },
            },
            {
                data: function (d) {
                    return d.code;
                },
            },
            {
                data: function (d) {
                    return `<img style="width: 50px;height:50px" src="${d.image}" alt="image" />`;
                },
            },
            {
                data: function (d) {
                    return getStatus(d.id, d.status);
                },
            },
            {
                data: function (d) {
                    return `<a class="btn btn-sm btn-primary btn-edit" target="_blank" href="/admin/websites/update/${d.id}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button data-id="${d.id}" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>`;
                },
            },
        ],
    });
});


function getStatus(id = '', status = '') {
    let renderStatus = '';
    switch (true) {
        case status == 0:
            renderStatus = `<div class="btn-group">
                <span class="btn btn-danger">Đang bảo trì</span>
                <button type="button" class="btn btn-danger btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(67px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a data-id=${id} data-status=${1} class="dropdown-item btn-change-status" href="#">Hoạt động</a>
                </div>
                </div>`;
            break;
        case status == 1:
            renderStatus = `<div class="btn-group">
                <span class="btn btn-success">Đang hoạt động</span>
                <button type="button" class="btn btn-success btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(67px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a data-id=${id} data-status=${0} class="dropdown-item btn-change-status" href="#">Bảo trì</a>
                </div>
                </div>`;
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
        $.ajax({
            type: "POST",
            url: `/api/websites/update`,
            data: {
                id,
                status,
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
            url: `/api/websites/${id}/destroy`,
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
