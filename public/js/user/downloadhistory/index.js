var dataTable = null;
var user = null;

$(document).ready(function () {
    user = JSON.parse(localStorage.getItem('user'));

    dataTable = $("#table").DataTable({
        ajax: {
            url: `/api/downloadhistories/getAll?user_id=${user.id}`,
            dataSrc: "downloadHistories",
        },
        columns: [
            {
                data: function (d) {
                    return d.user.name;
                },
            },
            {
                data: function (d) {
                    return d.url;
                },
            },
            {
                data: function (d) {
                    return d.created_at;
                },
            },
            {
                data: function (d) {
                    return `<a class="btn btn-sm btn-success" target="_blank" downloaded href="${d.url}">
                                <i class="fa-solid fa-download"></i>
                            </a>`;
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
            url: `/api/packages/${id}/destroy`,
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

