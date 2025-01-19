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
        },
        ajax: {
            url: "/api/keys/getAll",
            dataSrc: "keys",
        },
        columns: [
            {
                data: "type",
            },
            {
                data: "app_id",
            },
            {
                data: "app_key",
            },
            {
                data: "app_secret",
            },
            {
                data: function (d) {
                    return d.status == 0 ? 'Inactive' : 'Active';
                },
            },
            {
                data: function (d) {
                    let btnDelete = `<button data-id="${d.id}" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>`;
                    return `<a class="btn btn-primary btn-sm" href='/admin/keys/update/${d.id}'>
                            <i class="fas fa-edit"></i>
                            </a>
                            ${btnDelete}`;
                },
            },
        ],
    });
});

$(document).on("click", ".btn-delete", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/keys/${id}/destroy`,

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
