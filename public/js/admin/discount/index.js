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
            url: `/api/discounts/getAll`,
            dataSrc: "discounts",
        },
        columns: [
            {
                data: function (d) {
                    return d.code;
                },
            },
            {
                data: function (d) {
                    return d.discount;
                },
            },
            {
                data: function (d) {
                    return d.created_at;
                },
            },
            {
                data: function (d) {
                    return `<a class="btn btn-sm btn-primary btn-edit" target="_blank" href="/admin/discounts/update/${d.id}">
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
            url: `/api/discounts/${id}/destroy`,
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
