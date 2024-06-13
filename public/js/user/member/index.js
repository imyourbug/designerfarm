var dataTable = null;

$(document).ready(function () {
    dataTable = $("#table").DataTable({
        ajax: {
            url: `/api/members/getAll`,
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
                    return d.package_detail.type == 0 ? 'Tải lẻ' : 'Tải theo tháng hoặc năm';
                },
            },
            {
                data: function (d) {
                    return d.package_detail.type == 0 ? 'Không' : d.website_id;
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
