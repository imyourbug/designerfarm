var dataTable = null;

$(document).ready(function () {
    dataTable = $("#table").DataTable({
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
            url: `/api/packagedetails/getAll`,
            dataSrc: "packageDetails",
        },
        columns: [
            {
                data: function (d) {
                    return d.name;
                },
            },
            // {
            //     data: function (d) {
            //         return `${formatCash(d.price)}`;
            //     },
            // },
            // {
            //     data: function (d) {
            //         return `${formatCash(d.price_sale || 0)}`;
            //     },
            // },
            // {
            //     data: function (d) {
            //         return `${d.number_file}/${d.type == 0 ? 'năm' : 'ngày'}`;
            //     },
            // },
            // {
            //     data: function (d) {
            //         return d.expire;
            //     },
            // },
            {
                data: function (d) {
                    return d.type == 0 ? 'Tải lẻ' : 'Tải theo tháng hoặc năm';
                },
            },
            {
                data: function (d) {
                    return d.type == 0 ? 'Không' : d.website_id;
                },
            },
            {
                data: function (d) {
                    return d.description;
                },
            },
            {
                data: function (d) {
                    return `<img style="width: 50px;height:50px" src="${d.avatar}" alt="image" />`;
                },
            },
            {
                data: function (d) {
                    return `<a class="btn btn-sm btn-primary btn-edit" target="_blank" href="/admin/packagedetails/update/${d.id}">
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
            url: `/api/packagedetails/${id}/destroy`,
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
