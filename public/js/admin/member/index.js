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
            url: `/api/members/getAll`,
            dataSrc: "members",
        },
        columns: [
            {
                data: function (d) {
                    return d.user.name;
                },
            },
            {
                data: function (d) {
                    return d.package_detail.package.name;
                },
            },
            {
                data: function (d) {
                    return d.package_detail.number_file;
                },
            },
            {
                data: function (d) {
                    return d.package_detail.number_file - d.downloaded_number_file;
                },
            },
            {
                data: function (d) {
                    return d.expire;
                },
            },
            {
                data: function (d) {
                    return d.expired_at;
                },
            },
            {
                data: function (d) {
                    return d.package_detail.package.type == 0 ? 'Tải lẻ' : 'Tải theo tháng hoặc năm';
                },
            },
            {
                data: function (d) {
                    return d.package_detail.package.type == 0 ? 'Không' : d.package_detail.package.website_id;
                },
            },
            {
                data: function (d) {
                    return `<a target="_blank" class="btn btn-primary btn-sm" href='/admin/members/update/${d.id}'>
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

$(document).on("click", ".btn-delete", function () {
    if (confirm("Bạn có muốn xóa?")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/members/${id}/destroy`,
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
//         .url("/api/members/getAll?" + getQueryUrlWithParams())
//         .load();

//     //
//     await $.ajax({
//         type: "GET",
//         url: `/api/members/getAll?${getQueryUrlWithParams()}`,
//         success: function (response) {
//             if (response.status == 0) {
//                 response.members.forEach((e) => {
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
//         .url(`/api/members/getAll`)
//         // .url(`/api/members/getAll?today=${new Date().toJSON().slice(0, 10)}`)
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
//                 url: `/api/members/deleteAll`,
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
