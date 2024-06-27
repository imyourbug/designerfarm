var dataTable = null;
var user = null;

$(document).ready(function () {
    user = JSON.parse(localStorage.getItem('user'));

    dataTable = $("#table").DataTable({
        ordering: false,
        ajax: {
            url: `/api/members/getAll?user_id=${user.id}`,
            dataSrc: "members",
        },
        columns: [
            {
                data: function (d) {
                    return d.package_detail.package.name;
                },
            },
            {
                data: function (d) {
                    return d.number_file;
                },
            },
            {
                data: function (d) {
                    return d.number_file - d.downloaded_number_file;
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
        ],
    });
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
