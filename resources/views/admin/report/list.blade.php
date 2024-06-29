@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endpush
@push('scripts')
    <script src="/js/admin/package/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).on('change', '.select-date', function() {
            let from = $('#from').val();
            let to = $('#to').val();
            $.ajax({
                type: "GET",
                url: `/api/reports/getRevenue?from=${from}&to=${to}`,
                success: function(response) {
                    if (response.status == 0) {
                        let labels = [];
                        let records = [];
                        response.result.forEach(e => {
                            labels.push(`${e.month}/${e.year}`);
                            records.push(e.all_total);
                        });
                        if (chartRevenue) {
                            chartRevenue.data.labels = labels;
                            chartRevenue.data.datasets[0].data = records;
                            chartRevenue.update();
                        }
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
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


        var chartRevenue = null;

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: `/api/reports/getRevenue`,
                success: function(response) {
                    if (response.status == 0) {
                        let labels = [];
                        let records = [];
                        response.result.forEach(e => {
                            labels.push(`${e.month}/${e.year}`);
                            records.push(e.all_total);
                        });
                        chartRevenue = new Chart($('#chartRevenue'), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Doanh thu (VNĐ)',
                                    data: records,
                                    backgroundColor: '#E9CD8E',
                                    borderWidth: 1,
                                    order: 2,
                                }, ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(
                                                value,
                                                index,
                                                ticks
                                            ) {
                                                return `${formatCash(value)} VNĐ`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Doanh thu</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Từ</label>
                            <input type="date" id="from" class="select-date form-control" />
                        </div>
                        <div class="col-lg-6">
                            <label for="">Đến</label>
                            <input type="date" id="to" class="select-date form-control" />
                        </div>
                    </div>
                    <br>
                    <h3 style="text-align: center">Doanh thu theo tháng</h3>
                    <canvas id="chartRevenue" style="display:block;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection