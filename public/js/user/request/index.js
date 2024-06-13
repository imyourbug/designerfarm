var dataTable = null;
var user = null;

$(document).ready(function () {
    user = JSON.parse(localStorage.getItem('user'));

    dataTable = $("#table").DataTable({
        ajax: {
            url: `/api/requests/getAll?user_id=${user.id}`,
            dataSrc: "requests",
        },
        columns: [
            // {
            //     data: function (d) {
            //         return d.user.email;
            //     },
            // },
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
            // {
            //     data: function (d) {
            //         return d.expire;
            //     },
            // },
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
                    return getStatus(d.status);
                },
            },
        ],
    });
});

function getStatus(status = '') {
    let renderStatus = '';
    switch (true) {
        case status == 0:
            renderStatus = `<span class="btn btn-primary">Đang chờ</span>`;
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
