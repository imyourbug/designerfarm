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

// function getStatus(id = '', website_id = '', status = '') {
//     let renderStatus = '';
//     switch (true) {
//         case status == 0:
//             renderStatus = `<div class="btn-group">
//                 <span class="btn btn-primary">Đang chờ</span>
//                 <button type="button" class="btn btn-primary btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
//                 <span class="sr-only">Toggle Dropdown</span>
//                 </button>
//                 <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(67px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
//                  <form action="/admin/requests/update" method="post">
//                     <input type="hidden" value="${website_id}" name="website_id" />
//                     <input type="hidden" value="${$('#csrf-token').prop('content')}" name="_token" />
//                     <input type="hidden" value="${id}" name="id" />
//                     <input type="hidden" value="1" name="status" />
//                     <button onclick="return confirm('Bạn có muốn đổi trạng thái?')">Đã xác nhận</button>
//                 </form>
//                 <a data-id=${id} data-website_id='${website_id}' data-status=${2} class="dropdown-item" onclick="return confirm('Bạn có muốn đổi trạng thái?')" href="/admin/requests/updateGet?id=${id}&website_id=${website_id}&status=${2}">Đã hủy</a>
//                 </div>
//                 </div>`;
//             break;
//         case status == 1:
//             renderStatus = '<span class="btn btn-success">Đã xác nhận</span>';
//             break;
//         case status == 2:
//             renderStatus = '<span class="btn btn-danger">Đã hủy</span>';
//             break;
//         default:
//             break;
//     }

//     return renderStatus;
// }

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

// var searchParams = new Map([
//     ["from", ""],
//     ["to", ""],
//     ["content", ""],
//     ["phone", ""],
//     ["note", ""],
//     ["uid", ""],
//     ["name_facebook", ""],
//     ["title", ""],
//     ["user", ""],
//     ["link_or_post_id", ""],
// ]);

// var isFiltering = [];

// function getQueryUrlWithParams() {
//     let query = `user_id=`;
//     Array.from(searchParams).forEach(([key, values], index) => {
//         query += `&${key}=${typeof values == "array" ? values.join(",") : values}`;
//     })

//     return query;
// }


// function reloadAll() {
//     // enable or disable button
//     $('.btn-control').prop('disabled', tempAllRecord.length ? false : true);
//     $('.count-select').text(`Đã chọn: ${tempAllRecord.length}`);
// }

// $(document).on("click", ".btn-select-all", function () {
//     tempAllRecord = [];
//     if ($(this).is(':checked')) {
//         $('.btn-select').each(function () {
//             if ($(this).is(':checked')) {
//                 $(this).prop('checked', false);
//             } else {
//                 $(this).prop('checked', true);
//                 tempAllRecord.push($(this).data('id'));
//             }
//         });
//     } else {
//         $('.btn-select').each(function () {
//             $(this).prop('checked', false);
//         });
//     }
//     reloadAll();
//     console.log(tempAllRecord);
// });

// $(document).on("click", ".btn-select", async function () {
//     let id = $(this).data("id");
//     if ($(this).is(':checked')) {
//         if (!tempAllRecord.includes(id)) {
//             tempAllRecord.push(id);
//         }
//     } else {
//         tempAllRecord = tempAllRecord.filter((e) => e != id);
//     }
//     reloadAll();
// });

// $(document).on("click", ".btn-filter", async function () {
//     isFiltering = [];
//     tempAllRecord = [];
//     Array.from(searchParams).forEach(([key, values], index) => {
//         searchParams.set(key, String($('#' + key).val()).length ? $('#' + key).val() : '');
//         if ($('#' + key).val() && $('#' + key).attr('data-name')) {
//             isFiltering.push($('#' + key).attr('data-name'));
//         }
//     });
//     // display filtering
//     displayFiltering();

//     // reload
//     // dataTable.clear().rows.add(tempAllRecord).draw();
//     dataTable.ajax
//         .url("/api/requests/getAll?" + getQueryUrlWithParams())
//         .load();

//     //
//     await $.ajax({
//         type: "GET",
//         url: `/api/requests/getAll?${getQueryUrlWithParams()}`,
//         success: function (response) {
//             if (response.status == 0) {
//                 response.requests.forEach((e) => {
//                     tempAllRecord.push(e.id);
//                 });
//             }
//         }
//     });

//     // auto selected
//     tempAllRecord.forEach((e) => {
//         $(`.btn-select[data-id="${e}"]`).prop('checked', true);
//     });
//     $('.btn-select-all').prop('checked', true);
//     // reload all
//     reloadAll();
//     //
//     $('.count-package').text(`Bình luận: ${tempAllRecord.length}`);
// });

// $(document).on("click", ".btn-refresh", function () {
//     Array.from(searchParams).forEach(([key, values], index) => {
//         $('#' + key).val('');
//     });

//     // display filtering
//     isFiltering = [];
//     displayFiltering();

//     // reload table
//     dataTable.ajax
//         .url(`/api/requests/getAll`)
//         // .url(`/api/requests/getAll?today=${new Date().toJSON().slice(0, 10)}`)
//         .load();

//     // reload count and record
//     reload();
//     // reload all
//     reloadAll();
// });

// function displayFiltering() {
//     isFiltering = isFiltering.filter(function (item, pos, self) {
//         return self.indexOf(item) == pos;
//     });
//     $('.filtering').text(`Lọc theo: ${isFiltering.join(',')}`);
// }

// $(document).on("click", ".btn-delete-multiple", function () {
//     if (confirm("Bạn có muốn xóa các package đang hiển thị?")) {
//         if (tempAllRecord.length) {
//             $.ajax({
//                 type: "POST",
//                 url: `/api/requests/deleteAll`,
//                 data: { ids: tempAllRecord },
//                 success: function (response) {
//                     if (response.status == 0) {
//                         toastr.success("Xóa thành công");
//                         reload();
//                         dataTable.ajax.reload();
//                     } else {
//                         toastr.error(response.message);
//                     }
//                 },
//             });
//         } else {
//             toastr.error('Link trống');
//         }
//     }
// });
